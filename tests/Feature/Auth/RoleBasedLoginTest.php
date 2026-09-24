<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoleBasedLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create roles
        Role::firstOrCreate(['name' => 'Pasien']);
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Dokter']);
    }

    /**
     * Test Case A: Login Pasien + Akun PASIEN -> Berhasil diarahkan ke Dashboard Pasien.
     */
    public function test_case_a_patient_logs_in_via_patient_portal_succeeds(): void
    {
        $patient = User::factory()->create([
            'username' => 'pasien_test',
            'password' => bcrypt('password123'),
        ]);
        $patient->assignRole('Pasien');

        $component = Volt::test('pages.auth.login')
            ->set('form.login', 'pasien_test')
            ->set('form.password', 'password123')
            ->set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('patient.dashboard', absolute: false));

        $this->assertAuthenticatedAs($patient);
    }

    /**
     * Test Case B: Login Pasien + Akun ADMIN -> Ditolak, tetap di Login Pasien, pesan error sesuai.
     */
    public function test_case_b_admin_logs_in_via_patient_portal_is_rejected(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin_test',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('Super Admin');

        $component = Volt::test('pages.auth.login')
            ->set('form.login', 'admin_test')
            ->set('form.password', 'password123')
            ->set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');

        $component->call('login');

        $component
            ->assertHasErrors(['form.login' => 'Akun ini tidak memiliki akses ke Portal Pasien. Silakan gunakan Login Admin.'])
            ->assertNoRedirect();

        $this->assertGuest();
    }

    /**
     * Test Case C: Login Admin + Akun ADMIN -> Berhasil diarahkan ke Dashboard Admin.
     */
    public function test_case_c_admin_logs_in_via_admin_portal_succeeds(): void
    {
        $admin = User::factory()->create([
            'username' => 'admin_test2',
            'password' => bcrypt('password123'),
        ]);
        $admin->assignRole('Super Admin');

        $component = Volt::test('pages.auth.admin-login')
            ->set('form.login', 'admin_test2')
            ->set('form.password', 'password123')
            ->set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('admin.dashboard', absolute: false));

        $this->assertAuthenticatedAs($admin);
    }

    /**
     * Test Case D: Login Admin + Akun PASIEN -> Ditolak, tetap di Login Admin, pesan error sesuai.
     */
    public function test_case_d_patient_logs_in_via_admin_portal_is_rejected(): void
    {
        $patient = User::factory()->create([
            'username' => 'pasien_test2',
            'password' => bcrypt('password123'),
        ]);
        $patient->assignRole('Pasien');

        $component = Volt::test('pages.auth.admin-login')
            ->set('form.login', 'pasien_test2')
            ->set('form.password', 'password123')
            ->set('form.turnstile_token', 'MANUAL-DEV-VERIFIED');

        $component->call('login');

        $component
            ->assertHasErrors(['form.login' => 'Akun ini tidak memiliki akses ke Portal Admin. Silakan gunakan Login Pasien.'])
            ->assertNoRedirect();

        $this->assertGuest();
    }

    /**
     * Test Case E: Akun PASIEN mencoba membuka /admin/dashboard secara manual -> ditolak oleh middleware.
     */
    public function test_case_e_patient_cannot_access_admin_dashboard(): void
    {
        $patient = User::factory()->create();
        $patient->assignRole('Pasien');

        $response = $this->actingAs($patient)->get('/admin/dashboard');

        $response->assertRedirect(route('patient.dashboard'));
        $response->assertSessionHas('error');
    }

    /**
     * Test Case F: Akun ADMIN mencoba membuka /pasien/dashboard secara manual -> ditolak oleh middleware.
     */
    public function test_case_f_admin_cannot_access_patient_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('Super Admin');

        $response = $this->actingAs($admin)->get('/pasien/dashboard');

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');
    }
}
