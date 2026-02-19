<?php

    namespace Database\Seeders;

    use Illuminate\Database\Console\Seeds\WithoutModelEvents;
    use Illuminate\Database\Seeder;
    use App\Models\Flavor;

    class FlavorSeeder extends Seeder
    {
        public function run(): void
        {
            $flavors = [
                // Big Cone, Sundae Cone, Sundae Cup, Swirls Delight flavors
                'Big Cone',
                'Blueberry',
                'Chocolate',
                'Caramel',
                'Mango',
                'Strawberry',

                // Carfait flavors
                'Blueberry Cheesecake',
                'Choco Brownie Fudge',
                'Mango Passion',
                'Strawberry Stripes',
                'Ultimate Chocolate',

                // Daydream Classic flavors
                'Brownie Avalanche',
                'Oreo Strawberry',
                'Oreo Chocolate',
                'Oreo Vanilla',
                'Snickers',
                'Kitkat',

                // Daydream Premium flavors
                'Chocolate Almond Fudge',
                'M&M Brownie Fudge',
                'Mango Banana Twist',
                'Strawberry Banana',
                'Vanilla Almond Fudge',
                'Very Rocky Road',

                // Iced Coffee Float flavors
                'Choco',
                'Coffee',
                'Creamy Latte',
                'Chocomalt (Milo)',

                // Milkshake flavors
                'Coffee Banana',
                'Mango Graham',

                // Soda Float flavors
                'Coke / Pepsi',
                'Mountain Dew / Royal',
                'Root beer / Sarsi',

                // Vanilla Cone flavors
                'White Chocolate',
                'Ube',
            ];

            foreach ($flavors as $flavor) {
                Flavor::updateorCreate(['name' => $flavor]);
            }

            $uniqueFlavors = array_unique($flavors);
            sort($uniqueFlavors);

            foreach ($uniqueFlavors as $flavor) {
                Flavor::create(['name' => $flavor]);
            }
        }
    }