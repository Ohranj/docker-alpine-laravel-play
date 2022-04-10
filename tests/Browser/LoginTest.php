<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    /**
     * Login success test
     * @group login
     * @return void
     */
    public function testSuccessLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Fitness Tracker')
                ->type('#email', env('APP_MASTER_EMAIL'))
                ->type('password', env('APP_MASTER_PASSWORD'))
                ->press('Log in')
                ->waitForLocation('/home')
                ->assertPathIs('/home')
                ->screenshot('Login-Success');
        });
    }

    /**
     * Login fail example
     * @group login
     * @return void
     */
    public function testFailLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->deleteCookie('fitness_tracker_session')
                ->deleteCookie('XSRF-TOKEN')
                ->visit('/')
                ->assertSee('Fitness Tracker')
                ->type('#email', env('APP_MASTER_EMAIL'))
                ->type('password', 'FakePassword')
                ->press('Log in')
                ->waitForLocation('/')
                ->with('#f_login', fn ($form) => $form->waitForTextIn('#f_login', 'Invalid credentials'))
                ->screenshot('Login-Fail');
        });
    }
}
