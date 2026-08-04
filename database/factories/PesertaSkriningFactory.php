<?php

namespace Database\Factories;

use App\Models\JadwalSkrining;
use App\Models\PesertaSkrining;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PesertaSkrining>
 */
class PesertaSkriningFactory extends Factory
{
    protected $model = PesertaSkrining::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $statusList = ['Hadir', 'Tidak Hadir', 'Izin', 'Sakit'];
        $catatanList = [
            'Hasil pemeriksaan dalam kondisi normal dan sehat.',
            'Ditemukan karies gigi ringan, disarankan sikat gigi teratur.',
            'Ketajaman penglihatan sedikit menurun (perlu periksa ke dokter mata).',
            'Kondisi fisik sehat dan gizi baik.',
            'Terdapat plak pada gigi seri, perlu pembersihan rutin.',
        ];

        return [
            'sekolah_id' => Sekolah::factory(),
            'jadwal_id' => JadwalSkrining::factory(),
            'jadwal_skrining_id' => JadwalSkrining::factory(),
            'siswa_id' => User::factory(),
            'status_kehadiran' => $faker->randomElement($statusList),
            'catatan_hasil' => $faker->randomElement($catatanList),
            'catatan' => $faker->randomElement($catatanList),
        ];
    }
}
