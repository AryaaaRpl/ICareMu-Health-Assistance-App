<?php

namespace Database\Factories;

use App\Models\ArtikelIsmuba;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ArtikelIsmuba>
 */
class ArtikelIsmubaFactory extends Factory
{
    protected $model = ArtikelIsmuba::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');
        $title = $faker->sentence(5);

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'content' => $faker->paragraphs(4, true),
            'kategori' => $faker->randomElement(['Thibbun Nabawi', 'Adab Kebersihan', 'Fiqih Sakit']),
            'image_url' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=600&auto=format&fit=crop&q=80',
        ];
    }
}
