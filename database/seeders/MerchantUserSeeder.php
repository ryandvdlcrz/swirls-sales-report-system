<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class MerchantUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
       foreach (Branch::all() as $branch){
        User::firstOrCreate(
            ['branch_id' => $branch->id],
            [
                'username' => 'merchant' . $branch->id,
                'password' => Hash::make('merchant123'),
                'role' => 'merchant',
            ]
        );
       }
    }
}
