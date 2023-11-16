<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class TestApp extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testApp(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/home')
                    ->pause(5000)
                    ->press('Sign Up')
                    ->type('email', '1234@gmail.com')
                    ->type('name', 'AutoTest')
                    ->type('password', '12345678')
                    ->press('Confirm')
                    ->type('email', '1234@gmail.com')
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
                    ->press('Edit')
                    ->type('title', 'Test')
                    ->type('url', 'https://www.youtube.com/watch?v=5qap5aO4i9A')
                    ->select('platform', 'youtube')
                    ->press('Confirm')
                    ->pause(5000)
                    ->type('search', 'Test')
                    ->pause(5000)
                    ->press('Delete')
                    ->pause(5000)
                    ->press('Logout')
                    ->press('Yes')
                    ->visit('/home')
                    ->assertSee('BookMark');
        });
    }
}
