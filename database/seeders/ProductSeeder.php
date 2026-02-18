<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Big Cone'],
            ['name' => 'Carfait'],
            ['name' => 'Daydream Classic'],
            ['name' => 'Daydream Premium'],
            ['name' => 'Iced Coffee Float'],
            ['name' => 'Milkshake'],
            ['name' => 'Soda Float'],
            ['name' => 'Sundae Cone'],
            ['name' => 'Sundae Cup'],
            ['name' => 'Swirls Delight'],
            ['name' => 'Vanilla Cone'],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
