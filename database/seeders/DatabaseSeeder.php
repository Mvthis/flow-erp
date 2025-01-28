<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Création des utilisateurs
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Création des produits
        Product::insert([
            [
                'name' => 'Produit 1',
                'quantity' => 10,
                'price' => 20.99,
                'category' => 'Catégorie A',
            ],
            [
                'name' => 'Produit 2',
                'quantity' => 15,
                'price' => 35.50,
                'category' => 'Catégorie B',
            ],
            [
                'name' => 'Produit 3',
                'quantity' => 8,
                'price' => 12.75,
                'category' => 'Catégorie C',
            ],
            [
                'name' => 'Produit 4',
                'quantity' => 20,
                'price' => 5.99,
                'category' => 'Catégorie A',
            ],
            [
                'name' => 'Produit 5',
                'quantity' => 3,
                'price' => 100.00,
                'category' => 'Catégorie B',
            ],
        ]);
    }
}
