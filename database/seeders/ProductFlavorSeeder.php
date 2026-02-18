<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Flavor;


class ProductFlavorSeeder extends Seeder
{
    public function run(): void
    {
        // Define product-flavor relationships
        $productFlavors = [
            'Big Cone' => [
                'Blueberry',
                'Chocolate',
                'Caramel',
                'Mango',
                'Strawberry'
            ],
            'Carfait' => [
                'Blueberry Cheesecake',
                'Choco Brownie Fudge',
                'Mango Passion',
                'Strawberry Stripes',
                'Ultimate Chocolate'
            ],
            'Daydream Classic' => [
                'Brownie Avalanche',
                'Oreo Strawberry',
                'Oreo Chocolate',
                'Oreo Vanilla',
                'Strawberry',
                'Blueberry',
                'Snickers',
                'Kitkat'
            ],
            'Daydream Premium' => [
                'Chocolate Almond Fudge',
                'M&M Brownie Fudge',
                'Mango Banana Twist',
                'Strawberry Banana',
                'Vanilla Almond Fudge',
                'Very Rocky Road'
            ],
            'Iced Coffee Float' => [
                'Choco',
                'Coffee',
                'Creamy Latte',
                'Chocomalt (Milo)'
            ],
            'Milkshake' => [
                'Choco Brownie Fudge',
                'Coffee Banana',
                'Mango Graham',
                'Oreo Chocolate',
                'Oreo Strawberry',
                'Oreo Vanilla'
            ],
            'Soda Float' => [
                'Coke / Pepsi',
                'Mountain Dew / Royal',
                'Root beer / Sarsi'
            ],
            'Sundae Cone' => [
                'Blueberry',
                'Chocolate',
                'Caramel',
                'Mango',
                'Strawberry'
            ],
            'Sundae Cup' => [
                'Blueberry',
                'Chocolate',
                'Caramel',
                'Mango',
                'Strawberry'
            ],
            'Swirls Delight' => [
                'Blueberry',
                'Chocolate',
                'Caramel',
                'Mango',
                'Strawberry'
            ],
            'Vanilla Cone' => [
                'White Chocolate',
                'Chocolate',
                'Caramel',
                'Ube',
                'Strawberry'
            ],
        ];

        foreach ($productFlavors as $productName => $flavorNames) {
            $product = Product::where('name', $productName)->first();

            if ($product) {
                foreach ($flavorNames as $flavorName) {
                    $flavor = Flavor::where('name', $flavorName)->first();

                    if ($flavor) {
                        
                        $product->flavors()->attach($flavor->id);
                    }
                }
            }
        }
    }
}