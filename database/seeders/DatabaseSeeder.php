<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Sekolah;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::create([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin_super',
        ]);

        Sekolah::create([
            'nama_sekolah' => 'SMK Muhammadiyah 1 Genteng',
            'npsn' => '12345678',
        ]);

        Sekolah::create([
            'nama_sekolah' => 'SMK Muhammadiyah 2 Genteng',
            'npsn' => '87654321',
        ]);
        $this->call([
            UserRoleSeeder::class,
        ]);
    }
}
