<?php

namespace Tests\Feature;

use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BackendIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_nisn_and_access_dashboard(): void
    {
        $sekolah = Sekolah::create([
            'nama_sekolah' => 'SMK Muhammadiyah 1 Genteng',
            'npsn' => '12345678',
        ]);

        $user = User::create([
            'sekolah_id' => $sekolah->id,
            'email' => 'siswa@test.com',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
        ]);

        $siswa = Siswa::create([
            'user_id' => $user->id,
            'sekolah_id' => $sekolah->id,
            'nama_lengkap' => 'Siswa Test',
            'nisn' => '0012345678',
            'tanggal_lahir' => '2008-01-01',
        ]);

        $response = $this->post('/login', [
            'credential' => '0012345678',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/app/dashboard-siswa');
        $this->assertAuthenticatedAs($user);
    }

    public function test_registration_step1_creates_user_and_siswa(): void
    {
        $sekolah = Sekolah::create([
            'nama_sekolah' => 'SMK Muhammadiyah 1 Genteng',
            'npsn' => '12345678',
        ]);

        $response = $this->post('/register', [
            'nama_lengkap' => 'Ahmad Baru',
            'nisn' => '0099887766',
            'email' => 'ahmad@test.com',
            'password' => 'password123',
            'sekolah_id' => $sekolah->id,
        ]);

        $response->assertRedirect('/register/payment');
        $this->assertDatabaseHas('users', ['email' => 'ahmad@test.com']);
        $this->assertDatabaseHas('siswas', ['nisn' => '0099887766']);
    }
}
