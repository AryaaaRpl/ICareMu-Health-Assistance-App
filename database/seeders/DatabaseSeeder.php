<?php

namespace Database\Seeders;

use App\Models\InventarisUks;
use App\Models\JadwalSkrining;
use App\Models\KesehatanReproduksi;
use App\Models\PesertaSkrining;
use App\Models\RekamMedis;
use App\Models\RiwayatKonsultasi;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Sekolahs
        $sekolah = Sekolah::create([
            'nama_sekolah' => 'SMKS Muhammadiyah 1 Genteng - Banyuwangi',
            'npsn' => '20525611',
        ]);

        $sekolah2 = Sekolah::create([
            'nama_sekolah' => 'SMA Muhammadiyah 1 Yogyakarta',
            'npsn' => '20403152',
        ]);

        // 2. Create UKS Admin User
        $adminUks = User::create([
            'sekolah_id' => $sekolah->id,
            'email' => 'uks@smkmuh1genteng.sch.id',
            'password' => Hash::make('password'),
            'role' => 'guru_uks',
            'payment_status' => 'paid',
        ]);

        // 3. Create Student Users & Siswa profiles
        $studentUser1 = User::create([
            'sekolah_id' => $sekolah->id,
            'email' => 'daniswara@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'payment_status' => 'paid',
            'payment_order_id' => 'ORD-10001',
        ]);

        $siswa1 = Siswa::create([
            'user_id' => $studentUser1->id,
            'sekolah_id' => $sekolah->id,
            'nama_lengkap' => 'Daniswara Ahmad',
            'nisn' => '0087433166',
            'tanggal_lahir' => '2008-05-14',
            'nama_ortu' => 'Budi Santoso',
            'no_wa_ortu' => '081234567890',
            'golongan_darah' => 'O',
        ]);

        $studentUser2 = User::create([
            'sekolah_id' => $sekolah->id,
            'email' => 'clara@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'payment_status' => 'paid',
            'payment_order_id' => 'ORD-10002',
        ]);

        $siswa2 = Siswa::create([
            'user_id' => $studentUser2->id,
            'sekolah_id' => $sekolah->id,
            'nama_lengkap' => 'Clara Novita Sari',
            'nisn' => '3095436482',
            'tanggal_lahir' => '2009-08-20',
            'nama_ortu' => 'Slamet Rahardjo',
            'no_wa_ortu' => '082198765432',
            'golongan_darah' => 'A',
        ]);

        $studentUser3 = User::create([
            'sekolah_id' => $sekolah->id,
            'email' => 'syaqilla@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'payment_status' => 'paid',
            'payment_order_id' => 'ORD-10003',
        ]);

        $siswa3 = Siswa::create([
            'user_id' => $studentUser3->id,
            'sekolah_id' => $sekolah->id,
            'nama_lengkap' => 'Syaqilla Sasikirana Maheswari',
            'nisn' => '0091984189',
            'tanggal_lahir' => '2009-02-10',
            'nama_ortu' => 'Agus Priyono',
            'no_wa_ortu' => '085712344321',
            'golongan_darah' => 'B',
        ]);

        // 4. Create Rekam Medis
        RekamMedis::create([
            'siswa_id' => $siswa1->id,
            'sekolah_id' => $sekolah->id,
            'created_by' => $adminUks->id,
            'tanggal_periksa' => now()->subDays(2)->toDateString(),
            'tinggi_badan' => 170.0,
            'berat_badan' => 65.0,
            'imt_score' => 22.49,
            'status_risiko' => 'Normal',
            'catatan_medis' => 'Kondisi fisik sehat dan fit.',
            'status_verifikasi' => 'Terverifikasi',
        ]);

        RekamMedis::create([
            'siswa_id' => $siswa2->id,
            'sekolah_id' => $sekolah->id,
            'created_by' => $adminUks->id,
            'tanggal_periksa' => now()->subDays(5)->toDateString(),
            'tinggi_badan' => 160.0,
            'berat_badan' => 68.0,
            'imt_score' => 26.56,
            'status_risiko' => 'Gemuk (Overweight)',
            'catatan_medis' => 'Disarankan untuk mengatur konsumsi kalori dan olahraga rutin.',
            'status_verifikasi' => 'Terverifikasi',
        ]);

        // 5. Create Inventaris UKS
        InventarisUks::create([
            'sekolah_id' => $sekolah->id,
            'nama_barang' => 'Paracetamol 500mg (Tablet)',
            'kategori' => 'Obat-obatan',
            'stok' => 150,
            'tanggal_kedaluwarsa' => '2027-12-31',
        ]);

        InventarisUks::create([
            'sekolah_id' => $sekolah->id,
            'nama_barang' => 'Betadine Antiseptik 60ml',
            'kategori' => 'Obat Luar',
            'stok' => 8, // Low stock
            'tanggal_kedaluwarsa' => '2026-10-15',
        ]);

        InventarisUks::create([
            'sekolah_id' => $sekolah->id,
            'nama_barang' => 'Kasa Steril Box 16x16',
            'kategori' => 'Alat Kesehatan',
            'stok' => 45,
            'tanggal_kedaluwarsa' => '2028-01-01',
        ]);

        // 6. Create Jadwal Skrining & Peserta Skrining
        $jadwal = JadwalSkrining::create([
            'sekolah_id' => $sekolah->id,
            'jenis_skrining' => 'Skrining Berkala IMT & THT',
            'tanggal_pelaksanaan' => now()->addDays(7)->toDateString(),
            'lokasi' => 'Ruang UKS Utama',
            'status' => 'PENDING',
        ]);

        PesertaSkrining::create([
            'sekolah_id' => $sekolah->id,
            'jadwal_id' => $jadwal->id,
            'siswa_id' => $siswa1->id,
            'status_kehadiran' => 'Terdaftar',
            'catatan_hasil' => 'Menunggu pelaksanaan skrining.',
        ]);

        // 7. Create Menstrual Health Log
        KesehatanReproduksi::create([
            'siswa_id' => $siswa2->id,
            'sekolah_id' => $sekolah->id,
            'tanggal_haid' => now()->subDays(15)->toDateString(),
            'status_ai_amenore' => 'Siklus Normal',
        ]);

        // 8. Create Consultation Log
        RiwayatKonsultasi::create([
            'sekolah_id' => $sekolah->id,
            'siswa_id' => $siswa1->id,
            'jenis_konsultasi' => 'Kesehatan',
            'isi_pertanyaan' => 'Bagaimana cara mengatasi pusing saat setelah berolahraga?',
            'jawaban' => 'Pastikan hidrasi tubuh tercukupi dan lakukan pendinginan (cooling down) secara bertahap.',
        ]);
    }
}
