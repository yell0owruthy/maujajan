<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'name' => 'Matcha',
                'category' => 'Minuman',
                'price' => 25000,
                'description' => 'Matcha nya asli dari Jepang',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CheeseCake',
                'category' => 'Dissert',
                'price' => 50000,
                'description' => 'Kue yg lembut bagaikan awan langsung meleleh di mulut.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Potabe',
                'category' => 'Chiki',
                'price' => 5000,
                'description' => 'Es teh melati segar.',
                'image' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);     
    }
}
