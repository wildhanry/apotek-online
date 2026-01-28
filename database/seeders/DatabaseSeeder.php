<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@apotek.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Apoteker User
        User::create([
            'name' => 'Apoteker',
            'email' => 'apoteker@apotek.com',
            'password' => Hash::make('password'),
            'role' => 'apoteker',
        ]);

        // Create Customer User
        User::create([
            'name' => 'Customer',
            'email' => 'customer@apotek.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);

        // Create Dummy Products
        $products = [
            [
                'name' => 'Paracetamol 500mg',
                'slug' => 'paracetamol-500mg',
                'category' => 'Obat Bebas',
                'price' => 15000,
                'stock' => 100,
                'description' => 'Obat untuk meredakan demam dan nyeri ringan hingga sedang.',
                'image' => null,
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'slug' => 'vitamin-c-1000mg',
                'category' => 'Vitamin & Suplemen',
                'price' => 50000,
                'stock' => 80,
                'description' => 'Suplemen vitamin C untuk meningkatkan daya tahan tubuh.',
                'image' => null,
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'slug' => 'amoxicillin-500mg',
                'category' => 'Obat Keras',
                'price' => 35000,
                'stock' => 50,
                'description' => 'Antibiotik untuk mengobati infeksi bakteri.',
                'image' => null,
            ],
            [
                'name' => 'OBH Combi Batuk',
                'slug' => 'obh-combi-batuk',
                'category' => 'Obat Batuk & Flu',
                'price' => 25000,
                'stock' => 120,
                'description' => 'Obat untuk meredakan batuk berdahak.',
                'image' => null,
            ],
            [
                'name' => 'Antasida DOEN',
                'slug' => 'antasida-doen',
                'category' => 'Obat Maag',
                'price' => 12000,
                'stock' => 150,
                'description' => 'Obat untuk meredakan sakit maag dan gangguan pencernaan.',
                'image' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}

