<?php

namespace Database\Factories;

use App\Models\JadwalSkrining;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<JadwalSkrining>
 */
class JadwalSkriningFactory extends Factory
{
    protected $model = JadwalSkrining::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $jenis = $faker->randomElement(['Gigi', 'Mata', 'Umum']);
        $tanggal = $faker->dateTimeBetween('-2 months', '+2 months')->format('Y-m-d');
        $isPast = $tanggal < date('Y-m-d');

        $status = $isPast
            ? $faker->randomElement(['completed', 'completed', 'cancelled'])
            : $faker->randomElement(['scheduled', 'ongoing']);

        $locations = [
            'Ruang UKS Utama',
            'Aula Sekolah',
            'Ruang Kelas 7A & 7B',
            'Ruang Serbaguna',
            'Lapangan Indoor',
        ];

        return [
            'sekolah_id' => Sekolah::factory(),
            'jenis_skrining' => $jenis,
            'nama_kegiatan' => 'Skrining Kesehatan ' . $jenis . ' Berkala',
            'tanggal_pelaksanaan' => $tanggal,
            'tanggal' => $tanggal,
            'lokasi' => $faker->randomElement($locations),
            'status' => $status,
            'keterangan' => 'Pemeriksaan berkala kesehatan ' . strtolower($jenis) . ' untuk seluruh peserta didik.',
        ];
    }
}
