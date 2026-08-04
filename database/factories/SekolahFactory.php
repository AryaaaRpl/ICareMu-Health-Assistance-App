<?php

namespace Database\Factories;

use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Sekolah>
 */
class SekolahFactory extends Factory
{
    protected $model = Sekolah::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            'nama_sekolah' => 'SMP Negeri ' . $faker->numberBetween(1, 10) . ' ' . $faker->city(),
            'npsn' => (string) $faker->unique()->numberBetween(10000000, 99999999),
        ];
    }
}
