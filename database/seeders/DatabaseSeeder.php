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
use Faker\Factory as Faker;
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
        $faker = Faker::create('id_ID');

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
                'name' => 'Petugas UKS (Admin)',
                'password' => Hash::make('password'),
                'role' => 'admin_uks',
                'jenis_kelamin' => 'P',
                'payment_status' => 'paid',
                'no_wa' => '081234567890',
            ]
        );

        // Super Admin user
        User::updateOrCreate(
            ['email' => 'admin_super@icaremu.com'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'jenis_kelamin' => 'L',
                'payment_status' => 'paid',
                'no_wa' => '081234567891',
            ]
        );

        // 2b. Create Guru ISMUBA / Asatidz users for Halo Asatidz
        User::updateOrCreate(
            ['email' => 'ustadz.ahmad@icaremu.sch.id'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Ustadz Ahmad Dahlan, S.Pd.I',
                'password' => Hash::make('password'),
                'role' => 'guru_ismuba',
                'jenis_kelamin' => 'L',
                'payment_status' => 'paid',
                'no_wa' => '081298765432',
            ]
        );

        User::updateOrCreate(
            ['email' => 'ustadzah.fatimah@icaremu.sch.id'],
            [
                'sekolah_id' => $sekolah->id,
                'name' => 'Ustadzah Fatimah, M.Ag',
                'password' => Hash::make('password'),
                'role' => 'guru_ismuba',
                'jenis_kelamin' => 'P',
                'payment_status' => 'paid',
                'no_wa' => '081387654321',
            ]
        );

        // 3. Create 20 Dummy Students (Siswa)
        $students = collect();
        for ($i = 1; $i <= 20; $i++) {
            $isFemale = $i % 2 === 0;
            $gender = $isFemale ? 'P' : 'L';
            $name = $isFemale ? $faker->name('female') : $faker->name('male');
            $nisn = sprintf('00%08d', $i + 12345000);

            $user = User::factory()->create([
                'sekolah_id' => $sekolah->id,
                'name' => $name,
                'email' => "siswa{$i}@icaremu.sch.id",
                'role' => 'siswa',
                'jenis_kelamin' => $gender,
                'nisn' => $nisn,
                'nama_wali' => $faker->name(),
                'no_wa_wali' => '08' . $faker->numberBetween(100000000, 999999999),
                'no_wa' => '08' . $faker->numberBetween(100000000, 999999999),
            ]);

            if (Schema::hasTable('siswa')) {
                Siswa::create([
                    'user_id' => $user->id,
                    'sekolah_id' => $sekolah->id,
                    'nama_lengkap' => $user->name,
                    'nisn' => $nisn,
                    'tanggal_lahir' => now()->subYears(rand(12, 16))->format('Y-m-d'),
                    'nama_ortu' => $user->nama_wali,
                    'no_wa_ortu' => $user->no_wa_wali,
                    'golongan_darah' => $user->golongan_darah ?? 'O',
                ]);
            }

            $students->push($user);
        }

        // 4. Attach 30 Rekam Medis records randomly
        for ($i = 0; $i < 30; $i++) {
            $student = $students->random();
            $siswaRecord = Schema::hasTable('siswa') ? Siswa::where('user_id', $student->id)->first() : null;
            $siswaId = $siswaRecord ? $siswaRecord->id : $student->id;

            RekamMedis::factory()->create([
                'sekolah_id' => $sekolah->id,
                'siswa_id' => $siswaId,
            ]);
        }

        // 5. Create 3 Jadwal Skrining
        $screeningTypes = [
            [
                'jenis' => 'Umum',
                'nama' => 'Skrining Kesehatan Umum Berkala',
                'tanggal' => now()->subDays(14)->format('Y-m-d'),
                'status' => 'completed',
                'lokasi' => 'Aula SMKS Muhammadiyah 1 Genteng',
            ],
            [
                'jenis' => 'Gigi',
                'nama' => 'Skrining Kesehatan Gigi & Mulut',
                'tanggal' => now()->addDays(5)->format('Y-m-d'),
                'status' => 'scheduled',
                'lokasi' => 'Ruang UKS Utama',
            ],
            [
                'jenis' => 'Mata',
                'nama' => 'Skrining Indera Penglihatan (Mata)',
                'tanggal' => now()->addDays(15)->format('Y-m-d'),
                'status' => 'scheduled',
                'lokasi' => 'Masjid An-Namiroh',
            ],
        ];

        foreach ($screeningTypes as $screening) {
            $jadwal = JadwalSkrining::factory()->create([
                'sekolah_id' => $sekolah->id,
                'jenis_skrining' => $screening['jenis'],
                'nama_kegiatan' => $screening['nama'],
                'tanggal_pelaksanaan' => $screening['tanggal'],
                'tanggal' => $screening['tanggal'],
                'status' => $screening['status'],
                'lokasi' => $screening['lokasi'],
            ]);

            $participatingStudents = $students->random(rand(10, 15));
            foreach ($participatingStudents as $studentUser) {
                $siswaRecord = Schema::hasTable('siswa') ? Siswa::where('user_id', $studentUser->id)->first() : null;
                $siswaId = $siswaRecord ? $siswaRecord->id : $studentUser->id;

                PesertaSkrining::factory()->create([
                    'sekolah_id' => $sekolah->id,
                    'jadwal_id' => $jadwal->id,
                    'jadwal_skrining_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                ]);
            }
        }

        // 6. Create 15 Inventaris UKS items
        $inventarisPreset = [
            ['nama' => 'Paracetamol 500mg', 'kategori' => 'Obat', 'satuan' => 'Strip', 'stok' => 50, 'kondisi' => 'Baik'],
            ['nama' => 'Betadine Antiseptik 60ml', 'kategori' => 'Obat', 'satuan' => 'Botol', 'stok' => 15, 'kondisi' => 'Baik'],
            ['nama' => 'Perban Kasa Steril 10cm', 'kategori' => 'Logistik', 'satuan' => 'Roll', 'stok' => 40, 'kondisi' => 'Baik'],
            ['nama' => 'Thermometer Digital', 'kategori' => 'Alat Medis', 'satuan' => 'Unit', 'stok' => 5, 'kondisi' => 'Baik'],
            ['nama' => 'Thermometer Raksa (Cadangan)', 'kategori' => 'Alat Medis', 'satuan' => 'Unit', 'stok' => 2, 'kondisi' => 'Rusak'],
            ['nama' => 'Minyak Kayu Putih 100ml', 'kategori' => 'Obat', 'satuan' => 'Botol', 'stok' => 12, 'kondisi' => 'Baik'],
            ['nama' => 'Oralit Sachet', 'kategori' => 'Obat', 'satuan' => 'Box', 'stok' => 8, 'kondisi' => 'Baik'],
            ['nama' => 'Rivanol 300ml', 'kategori' => 'Obat', 'satuan' => 'Botol', 'stok' => 6, 'kondisi' => 'Baik'],
            ['nama' => 'Alcohol 70% 100ml', 'kategori' => 'Obat', 'satuan' => 'Botol', 'stok' => 10, 'kondisi' => 'Baik'],
            ['nama' => 'Masker Medis 3-Ply', 'kategori' => 'Logistik', 'satuan' => 'Box', 'stok' => 20, 'kondisi' => 'Baik'],
            ['nama' => 'Plester Luka Hansaplast', 'kategori' => 'Logistik', 'satuan' => 'Box', 'stok' => 15, 'kondisi' => 'Baik'],
            ['nama' => 'Stetoskop General Care', 'kategori' => 'Alat Medis', 'satuan' => 'Unit', 'stok' => 3, 'kondisi' => 'Baik'],
            ['nama' => 'Tensimeter Digital Omron', 'kategori' => 'Alat Medis', 'satuan' => 'Unit', 'stok' => 2, 'kondisi' => 'Baik'],
            ['nama' => 'Timbangan Badan Digital', 'kategori' => 'Alat Medis', 'satuan' => 'Unit', 'stok' => 2, 'kondisi' => 'Rusak'],
            ['nama' => 'Kapas Steril 50g', 'kategori' => 'Logistik', 'satuan' => 'Pack', 'stok' => 25, 'kondisi' => 'Baik'],
        ];

        foreach ($inventarisPreset as $item) {
            InventarisUks::factory()->create([
                'sekolah_id' => $sekolah->id,
                'nama_barang' => $item['nama'],
                'kategori' => $item['kategori'],
                'satuan' => $item['satuan'],
                'jumlah' => $item['stok'],
                'stok' => $item['stok'],
                'kondisi' => $item['kondisi'],
            ]);
        }

        // 7. Seed 5 Artikel ISMUBA (Updated Schema)
        $artikelIsmubaData = [
            [
                'judul' => 'Adab Menjenguk Orang Sakit dalam Islam',
                'slug' => 'adab-menjenguk-orang-sakit-dalam-islam',
                'kategori' => 'artikel_islami',
                'konten' => "Menjenguk saudara muslim yang sedang sakit merupakan salah satu kewajiban dan amalan yang sangat mulia dalam Islam.\n\nDalam sebuah hadits, Rasulullah SAW bersabda: 'Hak seorang muslim atas muslim lainnya ada lima: menjawab salam, menjenguk orang sakit, mengantar jenazah, memenuhi undangan, dan mendoakan yang bersin.' (HR. Bukhari dan Muslim).\n\nBeberapa Adab Utama Menjenguk Orang Sakit:\n1. Mendoakan Kesembuhan: Membaca doa kesembuhan 'Laa ba'-sa thahuurun in syaa-allah' atau 'As-alullahal 'azhiim rabbal 'arsyil 'azhiim an yasyfiyak'.\n2. Memberikan Motivasi & Ketenangan: Ucapkan kata-kata yang membesarkan hati dan menenangkan pikiran pasien.\n3. Menjaga Waktu Kunjungan: Jangan terlalu lama berkunjung agar si sakit dapat beristirahat cukup.\n4. Menjaga Kebersihan UKS: Cuci tangan sebelum dan sesudah berkunjung demi kesehatan bersama.",
                'thumbnail' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?w=600&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'judul' => 'Manfaat Habbatussauda dan Madu menurut Thibbun Nabawi',
                'slug' => 'manfaat-habbatussauda-dan-madu-menurut-thibbun-nabawi',
                'kategori' => 'edukasi_kesehatan',
                'konten' => "Thibbun Nabawi mengutamakan pengobatan alami yang sesuai dengan tuntunan Rasulullah SAW untuk menjaga kekebalan tubuh siswa.\n\n1. Habbatussauda (Jintan Hitam)\nRasulullah SAW bersabda: 'Sesungguhnya pada jintan hitam terdapat penyembuh bagi segala penyakit, kecuali kematian.' (HR. Bukhari). Habbatussauda kaya akan thymoquinone yang terbukti meningkatkan imunitas tubuh dan melawan peradangan.\n\n2. Madu Alami\nAllah SWT berfirman dalam Surah An-Nahl ayat 69: 'Dari perut lebah itu keluar minuman (madu) yang bermacam-macam warnanya, di dalamnya terdapat obat yang menyembuhkan bagi manusia.' Madu bekerja sebagai antiseptik alami, meredakan batuk, dan memberikan energi instan bagi siswa di UKS.",
                'thumbnail' => 'https://images.unsplash.com/photo-1587049352847-4a222e784d38?w=600&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'judul' => 'Panduan Fikih Wanita: Thaharah dan Kebersihan Diri Saat Haid',
                'slug' => 'panduan-fikih-wanita-thaharah-dan-kebersihan-diri-saat-haid',
                'kategori' => 'fikih_wanita',
                'konten' => "Islam memberikan perhatian khusus pada kesehatan reproduksi dan kesucian wanita.\n\nDalam fiqih wanita, masa haid membutuhkan perhatian terhadap kebersihan diri (personal hygiene) dan tata cara mandi wajib (mandi janabah) setelah suci.\n\nBeberapa poin penting:\n1. Memperhatikan siklus dan menjaga kebersihan organ kewanitaan.\n2. Tata cara mandi wajib sesuai sunnah Rasulullah SAW.\n3. Istirahat yang cukup dan asupan nutrisi penambah darah.",
                'thumbnail' => 'https://images.unsplash.com/photo-1584634731339-252c581abfc5?w=600&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'judul' => 'Menjaga Kesehatan Mental Menurut Kacamata Islam dan Al-Qur\'an',
                'slug' => 'menjaga-kesehatan-mental-menurut-kacamata-islam',
                'kategori' => 'kesehatan_mental',
                'konten' => "Kesehatan mental sama pentingnya dengan kesehatan fisik. Dalam Islam, ketenangan jiwa dapat dicapai melalui dzikrullah (mengingat Allah) dan ikhlas dalam menghadapi ujian.\n\nAllah SWT berfirman: 'Ingatlah, hanya dengan mengingat Allah hati menjadi tenteram.' (QS. Ar-Ra'd: 28).\n\nTips menjaga kesehatan mental:\n1. Senantiasa berdzikir dan berdo'a saat mengalami kecemasan.\n2. Berbagi cerita dengan konsultan/guru ISMUBA di sekolah melalui layanan Halo Asatidz.\n3. Istirahat teratur dan menjaga wudhu.",
                'thumbnail' => 'https://images.unsplash.com/photo-1564121211835-e88c852648ab?w=600&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'judul' => 'Manfaat Bekam (Cupping) dan Anjuran Menjaga Kesehatan menurut Rasulullah SAW',
                'slug' => 'manfaat-bekam-dan-anjuran-menjaga-kesehatan',
                'kategori' => 'edukasi_kesehatan',
                'konten' => "Menjaga kesehatan tubuh adalah bentuk rasa syukur atas amanah nikmat sehat dari Allah SWT.\n\nSalah satu metode Thibbun Nabawi yang direkomendasikan adalah Bekam (Hijamah). Rasulullah SAW bersabda: 'Sebaik-baik pengobatan yang kalian lakukan adalah bekam.' (HR. Bukhari).\n\nManfaat Bekam & Pola Hidup Sehat Rasulullah:\n1. Membuang Toksin / Darah Kotor: Membantu melancarkan sirkulasi darah dan meredakan ketegangan otot.\n2. Pola Makan Seimbang: Berhenti makan sebelum kenyang dan menghindari konsumsi makanan berlebihan.\n3. Olahraga Sunnah: Membiasakan jalan kaki, berkuda, memanah, atau berenang untuk melatih fisik siswa.",
                'thumbnail' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?w=600&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
        ];

        foreach ($artikelIsmubaData as $art) {
            ArtikelIsmuba::updateOrCreate(
                ['slug' => $art['slug']],
                [
                    'sekolah_id' => $sekolah->id,
                    'judul' => $art['judul'],
                    'kategori' => $art['kategori'],
                    'konten' => $art['konten'],
                    'thumbnail' => $art['thumbnail'],
                    'status' => $art['status'],
                ]
            );
        }

        // 8. Seed Menstrual Records for Female Students
        $femaleStudents = User::where('role', 'siswa')->where('jenis_kelamin', 'P')->get();

        foreach ($femaleStudents as $index => $femaleStudent) {
            if ($index === 0) {
                MenstrualRecord::create([
                    'siswa_id' => $femaleStudent->id,
                    'tanggal_mulai' => now()->subMonths(4)->format('Y-m-d'),
                    'tanggal_selesai' => now()->subMonths(4)->addDays(5)->format('Y-m-d'),
                    'tingkat_nyeri' => 4,
                    'catatan' => 'Siklus terhenti lama, kram perut ringan 4 bulan lalu.',
                ]);
            } else {
                MenstrualRecord::create([
                    'siswa_id' => $femaleStudent->id,
                    'tanggal_mulai' => now()->subDays(20)->format('Y-m-d'),
                    'tanggal_selesai' => now()->subDays(15)->format('Y-m-d'),
                    'tingkat_nyeri' => rand(1, 3),
                    'catatan' => 'Siklus haid teratur.',
                ]);
            }
        }
    }
}
