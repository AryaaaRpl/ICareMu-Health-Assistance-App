<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        return [
            'name' => $faker->name(),
            'email' => $faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => 'siswa',
            'payment_status' => 'paid',
            'nisn_nbm' => (string) $faker->unique()->numberBetween(1000000000, 9999999999),
            'nama_wali' => $faker->name(),
            'no_wa_wali' => '08' . $faker->numberBetween(100000000, 999999999),
            'tinggi_badan' => $faker->randomFloat(2, 140, 175),
            'berat_badan' => $faker->randomFloat(2, 35, 75),
            'golongan_darah' => $faker->randomElement(['A', 'B', 'AB', 'O']),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
