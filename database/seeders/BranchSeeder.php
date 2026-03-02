<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            Branch::create([
                'name'     => 'Branch' . $i,
                'code'     => 'B' . str_pad($i, 3, 0, STR_PAD_LEFT),
                'location' => 'Location' . $i,
            ]);
        }
    }
}
