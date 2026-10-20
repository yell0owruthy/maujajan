<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;//Menonaktifkan event bawaan pada Model selama proses pengisian data berlangsung agar proses seeding berjalan lebih cepat dan tidak memicu aksi otomatis yang tidak diperlukan.

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([//Membuat 1 data pengguna baru di tabel users dengan rincian spesifik:
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password'=> Hash::make('admin123'),
        ]);

        //Memanggil dan menjalankan file seeder lain bernama FoodSeeder (biasanya digunakan untuk mengisi daftar menu makanan awal ke tabel foods agar kodenya rapi dan terpisah dari DatabaseSeeder).
        $this->call([
            FoodSeeder::class,
        ]);
    }
}
