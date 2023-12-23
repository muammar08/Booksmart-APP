<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        // Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'regex:/^[A-Za-z0-9]+$/', 'min:6', 'max:20'],
            //'name' => ['required', 'string', 'min:6', 'max:20'],
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:20'
        ]);

        // Check if email is already taken
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return response()->json([
                'success' => false,
                'errorCode' => 'email_taken',
                'message' => 'Email is already taken. Please use a different email address.'
            ], 422); // Use 422 for Unprocessable Entity
        }

        // Send a failed response if the request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422); // Use 422 for Unprocessable Entity
        }

        // Request is valid, create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        // User created, return a success response
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'redirect' => true,
            'data' => $user
        ], 200); // You can use 200 for success, but it's a good practice to keep it consistent
    }


 
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        //Request is validated
        //Crean token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                 'success' => false,
                 'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
     return $credentials;
            return response()->json([
                 'success' => false,
                 'message' => 'Could not create token.',
                ], 500);
        }
  
   //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'redirect' => true,
            'token' => $token,
        ]);
    }
 
    public function logout(Request $request)
    {
        //valid credential
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

  //Request is validated, do logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function get_user(Request $request)
    {
        // Validate the request
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            // Attempt to authenticate the user using the provided token
            $user = JWTAuth::authenticate($request->token);

            // If authentication is successful, return the user
            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            // If an exception occurs (e.g., token is invalid), return an error response
            return response()->json(['error' => 'Authentication failed'], 401);
        }
    }
}