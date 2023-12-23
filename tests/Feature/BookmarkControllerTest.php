<?php

namespace Tests\Feature;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class BookmarkControllerTest extends TestCase
{
    use WithFaker;

    public function test_register_success(){

        // Send a POST request to the register endpoint
        $response = $this->post('/api/register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => '12345678',
        ]);

        // Assert that the response has a 200 status code (for successful registration)
        $response->assertStatus(200);
        
    }

    public function test_register_failed_invalid_email_format(){

        $response = $this->post('/api/register', [
            'name' => $this->faker->name,
            'email' => 'John Doe', // Provide an invalid email format
            'password' => '12345678',
        ]);

        // Assert that the response has a 422 status code (Unprocessable Entity) or another status code indicating failure.
        $response->assertStatus(422);
    }

    public function test_register_failed_duplicate_email(){

        $response = $this->post('/api/register', [
            'name' => $this->faker->name,
            'email' => '123@gmail.com', // Provide an existing email
            'password' => '12345678',
        ]);

        // Assert that the response has a 422 status code (Unprocessable Entity) or another status code indicating failure.
        $response->assertStatus(422);
    }

    public function test_login_success(){

        // Send a POST request to the login endpoint
        $response = $this->post('/api/login', [
            'email' => '123@gmail.com',
            'password' => '12345678',
        ]);

        // Assert that the response has a 200 status code (for successful login)
        $response->assertStatus(200);

        // Optionally, you can assert other things like checking if the user is authenticated
        $this->assertAuthenticated();
    }

    public function test_login_failed(){
            
            // Send a POST request to the login endpoint
            $response = $this->post('/api/login', [
                'email' => $this->faker->unique()->safeEmail,
                'password' => '12345678',
            ]);

            // Assert that the response has a 400 status code (for successful login)
            $response->assertStatus(400);
    }

    public function test_get_user_success(){

        // Create a user and obtain their token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Send a GET request to the endpoint that retrieves user data
        $response = $this->get('/api/get_user', [
            'token' => $token, // Include the token in the request data
        ]);

        // Assert that the response has a 200 status code (for successful retrieval)
        $response->assertStatus(200);
    }


    public function test_stores_data_success()
    {
        // Create a user
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Data to be stored
        $bookmarkData = [
            'title' => $this->faker->words(3, true),
            'url' => $this->faker->url,
            'platform' => 'Facebook',
            'user_id' => $user->id,
        ];

        // Include the token in the request headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/create', $bookmarkData);

        // Assert the response status code
        $response->assertStatus(201); // Assuming you return 201 for a successful creation

        // Optionally, you can assert the response data or database records as needed
        $response->assertJson([
            'message' => 'Bookmark created successfully',
        ]);

        // Assert that the bookmark was stored in the database
        $this->assertDatabaseHas('bookmarks', $bookmarkData);
    }

    public function test_store_data_failed(){

        // Create a user
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Data with invalid values
        $invalidBookmarkData = [
            'title' => '', // Invalid title (empty)
            'url' => 'invalid-url', // Invalid URL format
            'platform' => '', // Invalid platform (empty)
            'user_id' => $user->id,
        ];

        // Include the token in the request headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/api/create', $invalidBookmarkData);

        // Assert the response status code (assuming you return a 400 status code for validation failure)
        $response->assertStatus(400);

        // Assert that the bookmark was not stored in the database
        $this->assertDatabaseMissing('bookmarks', $invalidBookmarkData);
    }

    public function test_get_list_bookmark(){

        // Create a user and obtain their token
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Send a GET request to the endpoint that retrieves user data with the token in the headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/bookmarks');

        // Assert that the response has a 200 status code (for successful retrieval)
        $response->assertStatus(200);
    }

    public function test_update_data_success(){

        // Create a user
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Create a bookmark manually
        $bookmarkData = [
            'title' => 'Example Bookmark',
            'url' => 'https://example.com',
            'platform' => 'Instagram',
            'user_id' => $user->id,
        ];

        // Save the bookmark to the database
        $bookmark = Bookmark::create($bookmarkData);

        // Data to be updated
        $updatedBookmarkData = [
            'title' => $this->faker->words(3, true),
            'url' => $this->faker->url,
            'platform' => 'Twitter', // Updated platform
            'user_id' => $user->id,
        ];

        // Include the token in the request headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/update/' . $bookmark->id, $updatedBookmarkData);

        // Assert the response status code
        $response->assertStatus(200); // Assuming you return 200 for a successful update

        // Optionally, you can assert the response data or database records as needed
        $response->assertJson([
            'message' => 'Bookmark updated successfully',
        ]);

        // Assert that the bookmark was updated in the database
        $this->assertDatabaseHas('bookmarks', $updatedBookmarkData);
    }

    public function test_update_data_failed(){

        // Create a user
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Create a bookmark manually
        $bookmarkData = [
            'title' => 'Example Bookmark',
            'url' => 'https://example.com',
            'platform' => 'Instagram',
            'user_id' => $user->id,
        ];

        // Save the bookmark to the database
        $bookmark = Bookmark::create($bookmarkData);

        // Data to be updated with invalid data
        $invalidBookmarkData = [
            'title' => '', // Invalid title (empty)
            'url' => 'invalid-url', // Invalid URL format
            'platform' => 'Twitter',
            'user_id' => $user->id,
        ];

        // Include the token in the request headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('PUT', '/api/update/' . $bookmark->id, $invalidBookmarkData);

        // Assert the response status code (assuming you return a 400 status code for validation failure)
        $response->assertStatus(400);

        // Assert that the bookmark was not updated in the database
        $this->assertDatabaseMissing('bookmarks', $invalidBookmarkData);
    }

    public function test_delete_data(){

        // Create a user
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);

        // Create a bookmark manually
        $bookmarkData = [
            'title' => 'Example Bookmark',
            'url' => 'https://example.com',
            'platform' => 'Instagram',
            'user_id' => $user->id,
        ];

        // Save the bookmark to the database
        $bookmark = Bookmark::create($bookmarkData); 

        // Include the token in the request headers
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('DELETE', '/api/delete/' . $bookmark->id);

        // Assert the response status code (assuming you return a 200 status code for successful deletion)
        $response->assertStatus(200);

        // Assert that the bookmark was deleted from the database
        $this->assertDatabaseMissing('bookmarks', [
            'id' => $bookmark->id,
        ]);
    }

    public function test_countplatform(){
        // Send a GET request to the count platform endpoint
        $response = $this->get('/api/countPlatform');

        // Assert that the response has a 200 status code (for successful login)
        $response->assertStatus(200);
    }



    
}
