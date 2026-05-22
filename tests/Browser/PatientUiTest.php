<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class PatientUiTest extends DuskTestCase
{
    private function createTestUser(string $email, string $name, string $password, string $role): User
    {
        $user = User::firstOrNew(['email' => $email]);

        $user->forceFill([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ])->save();

        return $user;
    }

    public function test_login_page_loads_correctly(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();

            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->assertPresent('input[name="email"]')
                    ->assertPresent('input[name="password"]')
                    ->assertPresent('button[type="submit"]');
        });
    }

    public function test_admin_can_login_and_access_admin_panel(): void
    {
        $this->createTestUser(
            'admin_ui@test.com',
            'Administrador UI',
            'Admin12345!',
            'admin'
        );

        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();

            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->type('input[name="email"]', 'admin_ui@test.com')
                    ->type('input[name="password"]', 'Admin12345!')
                    ->click('button[type="submit"]')
                    ->pause(1000)
                    ->visit('/admin')
                    ->assertSee('administrador');
        });
    }

    public function test_doctor_can_login_and_access_doctor_panel(): void
    {
        $this->createTestUser(
            'doctor_ui@test.com',
            'Doctor UI',
            'Doctor12345!',
            'doctor'
        );

        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();

            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->type('input[name="email"]', 'doctor_ui@test.com')
                    ->type('input[name="password"]', 'Doctor12345!')
                    ->click('button[type="submit"]')
                    ->pause(1000)
                    ->visit('/doctor')
                    ->assertSee('doctor');
        });
    }

    public function test_admin_cannot_access_doctor_panel_from_browser(): void
    {
        $this->createTestUser(
            'admin_block@test.com',
            'Admin Bloqueado',
            'Admin12345!',
            'admin'
        );

        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();

            $browser->visit('/login')
                    ->assertPathIs('/login')
                    ->type('input[name="email"]', 'admin_block@test.com')
                    ->type('input[name="password"]', 'Admin12345!')
                    ->click('button[type="submit"]')
                    ->pause(1000)
                    ->visit('/doctor')
                    ->assertSee('permiso');
        });
    }
}