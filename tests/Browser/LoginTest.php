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
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->pause(5000)
                    ->press('Sign Up')
                    ->type('email', 'johndoe1@gmail.com')
                    ->type('name', 'AutoTest')
                    ->type('password', '12345678')
                    ->assertSee('Confirm')
                    ->press('Confirm')
                    ->pause(5000)
                    ->type('email', 'johndoe1@gmail.com')
                    ->type('password', '12345678')
                    ->assertSee('Confirm')
                    ->press('Confirm')
                    ->pause(5000)
                    ->assertSee('Create')
                    ->press('Create')
                    ->type('title', 'AutoTest')
                    ->type('url', 'https://www.youtube.com/watch?v=5qap5aO4i9A')
                    ->select('platform', 'youtube')
                    ->assertSee('Confirm')
                    ->press('Confirm')
                    ->pause(5000)
                    ->press('Create')
                    ->type('title', 'Belajar Golang')
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
                    ->assertSee('Confirm')
                    ->press('Confirm')
                    ->pause(5000)
                    ->type('search', 'Testing')
                    ->pause(5000)
                    ->click('@dlt-button')
                    ->press('Yes, delete it!')
                    ->pause(5000)
                    ->assertSee('Log out')
                    ->clickLink('Log out')
                    ->press('Yes')
                    ->visit('/')
                    ->pause(10000)
                    ->assertSee('BookSmart');
        });
    }
}
