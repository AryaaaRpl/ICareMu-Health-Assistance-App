<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Siswa;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada setidaknya satu sekolah
        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => '12345678'],
            ['nama_sekolah' => 'SMK Muhammadiyah 1 Genteng']
        );

        // 1. Admin Super
        User::firstOrCreate(
            ['email' => 'admin_super@icaremu.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin_super',
            ]
        );

        // 2. Admin Sekolah
        User::firstOrCreate(
            ['email' => 'admin_sekolah@icaremu.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'admin_sekolah',
                'sekolah_id' => $sekolah->id,
            ]
        );

        // 3. Guru UKS
        User::firstOrCreate(
            ['email' => 'guru_uks@icaremu.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'guru_uks',
                'sekolah_id' => $sekolah->id,
            ]
        );

        // 4. Siswa
        $siswaUser = User::firstOrCreate(
            ['email' => 'siswa@icaremu.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'sekolah_id' => $sekolah->id,
            ]
        );

        // Buat relasi tabel siswas agar login NISN juga berfungsi
        Siswa::firstOrCreate(
            ['nisn' => '1234567890'],
            [
                'user_id' => $siswaUser->id,
                'sekolah_id' => $sekolah->id,
                'nama_lengkap' => 'Siswa Dummy iCareMu',
                'tanggal_lahir' => '2010-01-01',
                'nama_ortu' => 'Bapak Siswa',
                'no_wa_ortu' => '081234567890',
                'golongan_darah' => 'O',
            ]
        );

        // 5. Orang Tua
        User::firstOrCreate(
            ['email' => 'ortu@icaremu.com'],
            [
                'password' => Hash::make('password'),
                'role' => 'ortu',
                'sekolah_id' => $sekolah->id,
            ]
        );
    }
}
