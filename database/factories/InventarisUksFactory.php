<?php

namespace Database\Factories;

use App\Models\InventarisUks;
use App\Models\Sekolah;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventarisUks>
 */
class InventarisUksFactory extends Factory
{
    protected $model = InventarisUks::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('id_ID');

        $items = [
            ['nama' => 'Paracetamol 500mg', 'kategori' => 'Obat', 'satuan' => 'Strip'],
            ['nama' => 'Betadine Antiseptik 60ml', 'kategori' => 'Obat', 'satuan' => 'Botol'],
            ['nama' => 'Perban Kasa Steril 10cm', 'kategori' => 'Logistik', 'satuan' => 'Roll'],
            ['nama' => 'Thermometer Digital', 'kategori' => 'Alat Medis', 'satuan' => 'Unit'],
            ['nama' => 'Minyak Kayu Putih 100ml', 'kategori' => 'Obat', 'satuan' => 'Botol'],
            ['nama' => 'Oralit Sachet', 'kategori' => 'Obat', 'satuan' => 'Box'],
            ['nama' => 'Rivanol 300ml', 'kategori' => 'Obat', 'satuan' => 'Botol'],
            ['nama' => 'Alcohol 70% 100ml', 'kategori' => 'Obat', 'satuan' => 'Botol'],
            ['nama' => 'Masker Medis 3-Ply', 'kategori' => 'Logistik', 'satuan' => 'Box'],
            ['nama' => 'Plester Luka Hansaplast', 'kategori' => 'Logistik', 'satuan' => 'Box'],
            ['nama' => 'Stetoskop Digital', 'kategori' => 'Alat Medis', 'satuan' => 'Unit'],
            ['nama' => 'Tensimeter Digital', 'kategori' => 'Alat Medis', 'satuan' => 'Unit'],
            ['nama' => 'Timbangan Badan Digital', 'kategori' => 'Alat Medis', 'satuan' => 'Unit'],
            ['nama' => 'Kotak P3K Lengkap', 'kategori' => 'Alat Medis', 'satuan' => 'Unit'],
            ['nama' => 'Kapas Steril 50g', 'kategori' => 'Logistik', 'satuan' => 'Pack'],
        ];

        $selectedItem = $faker->randomElement($items);
        $stok = $faker->numberBetween(2, 40); // Generates some low stock items (<10)
        $dateObj = $faker->dateTimeBetween('-14 days', 'now');

        return [
            'sekolah_id' => Sekolah::factory(),
            'nama_barang' => $selectedItem['nama'],
            'kategori' => $selectedItem['kategori'],
            'jumlah' => $stok,
            'stok' => $stok,
            'satuan' => $selectedItem['satuan'],
            'kondisi' => $faker->randomElement(['Baik', 'Baik', 'Baik', 'Rusak']),
            'keterangan' => 'Inventaris resmi ruang UKS sekolah.',
            'tanggal_kedaluwarsa' => $faker->dateTimeBetween('+6 months', '+3 years')->format('Y-m-d'),
            'created_at' => $dateObj,
            'updated_at' => $dateObj,
        ];
    }
}
