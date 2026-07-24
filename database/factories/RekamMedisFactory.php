<?php

namespace Database\Factories;

use App\Models\RekamMedis;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RekamMedis>
 */
class RekamMedisFactory extends Factory
{
    protected $model = RekamMedis::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $tinggiBadan = $faker->randomFloat(2, 135, 175); // cm
        $beratBadan = $faker->randomFloat(2, 30, 75);   // kg

        $heightInMeters = $tinggiBadan / 100;
        $imtScore = round($beratBadan / ($heightInMeters * $heightInMeters), 2);

        $statusRisiko = match (true) {
            $imtScore < 18.5 => 'underweight',
            $imtScore < 25.0 => 'normal',
            $imtScore < 30.0 => 'overweight',
            default => 'obese',
        };

        $keluhanList = [
            'Demam tinggi dan sakit kepala sejak kemarin.',
            'Pusing dan mual setelah pelajaran olahraga.',
            'Nyeri perut bagian bawah dan badan terasa lemas.',
            'Luka lecet pada lutut kanan akibat jatuh di lapangan.',
            'Batuk berdahak dan tenggorokan gatal.',
            'Sakit gigi berlubang di bagian geraham kanan.',
            'Mata merah, perih, dan berair.',
            'Sesak nafas ringan setelah kegiatan fisik.',
            'Mimisan akibat cuaca panas berlebihan.',
            'Meriang dan pegal-pegal seluruh tubuh.',
        ];

        $penangananList = [
            'Diberikan Paracetamol 500mg dan diminta istirahat 1 jam di UKS.',
            'Pembersihan luka dengan Rivanol/Betadine dan dipasang perban steril.',
            'Minum air hangat, kompres dahi, dan diberikan minyak kayu putih.',
            'Diberikan minum Teh Hangat dan oralit untuk meredakan mual.',
            'Diberikan kompres dingin pada hidung dan posisi istirahat terlentang.',
            'Diberikan obat kumur antiseptik dan disarankan periksa ke dokter gigi.',
            'Pembersihan mata dengan tetes mata steril dan istirahat secukupnya.',
            'Diistirahatkan di tempat teduh dan diberikan air mineral hangat.',
        ];

        $statusPenangananOptions = [
            'Selesai',
            'Istirahat di UKS',
            'Rujuk ke Puskesmas',
            'Dalam Penanganan',
            'Dipulangkan ke Rumah',
        ];

        $dateObj = $faker->dateTimeBetween('-14 days', 'now');
        $tanggal = $dateObj->format('Y-m-d');

        return [
            'sekolah_id' => Sekolah::factory(),
            'siswa_id' => User::factory(),
            'keluhan_utama' => $faker->randomElement($keluhanList),
            'tinggi_badan' => $tinggiBadan,
            'berat_badan' => $beratBadan,
            'suhu' => $faker->randomFloat(1, 36.0, 38.5),
            'tekanan_darah' => $faker->randomElement(['100/60', '110/70', '120/80', '115/75', '125/85']),
            'imt_score' => $imtScore,
            'status_risiko' => $statusRisiko,
            'status_penanganan' => $faker->randomElement($statusPenangananOptions),
            'status' => $faker->randomElement(['Selesai', 'Rawat UKS', 'Dirujuk']),
            'penanganan' => $faker->randomElement($penangananList),
            'tanggal' => $tanggal,
            'tanggal_periksa' => $tanggal,
            'created_at' => $dateObj,
            'updated_at' => $dateObj,
        ];
    }
}
