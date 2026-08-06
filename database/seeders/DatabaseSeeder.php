<?php

namespace Database\Seeders;

use App\Models\ArtikelIsmuba;
use App\Models\InventarisUks;
use App\Models\JadwalSkrining;
use App\Models\MenstrualRecord;
use App\Models\PesertaSkrining;
use App\Models\RekamMedis;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // 1. Create 1 Main Tenant (sekolah_id)
        $sekolah = Sekolah::firstOrCreate(
            ['npsn' => '20109988'],
            ['nama_sekolah' => 'SMKS Muhammadiyah 1 Genteng']
        );

        // 2. Create Admin UKS user for login
        $adminUks = User::updateOrCreate(
            ['email' => 'admin_uks@icaremu.com'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Miftakhul Afifah, A.Md. Kep.',
                'password' => Hash::make('password'),
                'role' => 'admin_uks',
                'jenis_kelamin' => 'P',
                'payment_status' => 'paid',
                'no_wa' => '081259449212',
            ]
        );

        // Super Admin user
        User::updateOrCreate(
            ['email' => 'admin_super@icaremu.com'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Endah Dila Kurniawati, S.Kom (Super Admin)',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'jenis_kelamin' => 'P',
                'payment_status' => 'paid',
                'no_wa' => '082230804973',
            ]
        );

        // 2b. Create Guru ISMUBA / Asatidz users for Halo Asatidz
        User::updateOrCreate(
            ['email' => 'ustadz.hafidz@icaremu.sch.id'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Ustadz Hafidz Azhari, S.Pd',
                'password' => Hash::make('password'),
                'role' => 'guru_ismuba',
                'jenis_kelamin' => 'L',
                'payment_status' => 'paid',
                'no_wa' => '081358359967',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ustadzah.sitimuawanah@icaremu.sch.id'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Ustadzah Siti Muawanah, S.Pd',
                'password' => Hash::make('password'),
                'role' => 'guru_ismuba',
                'jenis_kelamin' => 'P',
                'payment_status' => 'paid',
                'no_wa' => '083853564538',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ustadzah.dina@icaremu.sch.id'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Ustadzah Dina Istiningrum, S.Pd',
                'password' => Hash::make('password'),
                'role' => 'guru_ismuba',
                'jenis_kelamin' => 'P',
                'payment_status' => 'paid',
                'no_wa' => '081331477369',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ustadz.drei@icaremu.sch.id'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Ustad Drei Herba Ta\'abudi, M.Hum',
                'password' => Hash::make('password'),
                'role' => 'guru_ismuba',
                'jenis_kelamin' => 'L',
                'payment_status' => 'paid',
                'no_wa' => '082140507456',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ustadzah.hamimatulbaidhok@icaremu.sch.id'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Ustadzah Hamamatul Baidhok,S,Pd',
                'password' => Hash::make('password'),
                'role' => 'guru_ismuba',
                'jenis_kelamin' => 'P',
                'payment_status' => 'paid',
                'no_wa' => '082334174264',
            ]
        );

        // 3. Create 20 Dummy Students (Siswa)
    }
}