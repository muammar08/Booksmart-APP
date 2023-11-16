<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        // $this->browse(function (Browser $browser) {
        //     $browser->visit('/login')
        //             ->type('email', '123@gmail.com')
        //             ->type('password', '12345678')
        //             ->press('Confirm')
        //             ->assertSee('Create')
        //             ->pause(5000);
                    
        // });
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(5000)
                    ->press('Sign Up')
                    ->type('email', '123456@gmail.com')
                    ->type('name', 'AutoTest')
                    ->type('password', '12345678')
                    ->press('Confirm')
                    ->pause(5000)
                    ->type('email', '123456@gmail.com')
                    ->type('password', '12345678')
                    ->press('Confirm')
                    ->pause(5000)
                    ->press('Create')
                    ->type('title', 'AutoTest')
                    ->type('url', 'https://www.youtube.com/watch?v=5qap5aO4i9A')
                    ->select('platform', 'youtube')
                    ->press('Confirm')
                    ->pause(5000)
                    ->assertSee('AutoTest')
                    ->click('@edit-button')
                    ->pause(5000)
                    ->type('title', 'Testing')
                    ->type('url', 'https://www.youtube.com/watch?v=5qap5aO4i9A')
                    ->select('platform', 'youtube')
                    ->press('Confirm')
                    ->pause(5000)
                    ->type('search', 'Testing')
                    ->pause(5000)
                    ->click('@dlt-button')
                    ->press('Yes, delete it!')
                    ->pause(5000)
                    ->clickLink('Log out')
                    ->press('Yes')
                    ->visit('/')
                    ->pause(10000)
                    ->assertSee('BookSmart');
        });
    }
}
