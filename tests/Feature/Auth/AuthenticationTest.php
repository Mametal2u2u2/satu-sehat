<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => 'Pasien', 'guard_name' => 'web']);
    }

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.login');
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pasien');

        $component = Volt::test('pages.auth.login')
            ->set('form.login', $user->username ?? $user->email)
            ->set('form.password', 'password')
            ->set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('patient.dashboard', absolute: false));

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pasien');

        $component = Volt::test('pages.auth.login')
            ->set('form.login', $user->username ?? $user->email)
            ->set('form.password', 'wrong-password')
            ->set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    }

    public function test_navigation_menu_can_be_rendered(): void
    {
        $user = User::factory()->create();
        $user->assignRole('Pasien');

        $this->actingAs($user);

        $response = $this->get('/dashboard');

        $response->assertRedirect(route('patient.dashboard'));
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('layout.navigation');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
