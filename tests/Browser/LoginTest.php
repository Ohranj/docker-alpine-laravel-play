<?php

namespace Tests\Browser;

use App\Models\User;
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

        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/')
                ->assertSee('Fitness Tracker')
                ->type('#email', $user->email)
                ->type('password', 'Orange18')
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
        $user = User::find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->deleteCookie('fitness_tracker_session')
                ->deleteCookie('XSRF-TOKEN')
                ->visit('/')
                ->assertSee('Fitness Tracker')
                ->type('#email', $user->email)
                ->type('password', 'FakePassword')
                ->press('Log in')
                ->waitForLocation('/')
                ->with('#f_login', function ($form) {
                    $form->waitForTextIn('#f_login', 'Invalid credentials');
                })
                ->screenshot('Login-Fail');
        });
    }
}
