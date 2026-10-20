<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) { //Memerintahkan Laravel untuk membuat tabel baru dengan nama order_details
            $table->id();//embuat kolom id sebagai Primary Key dengan fitur auto-increment (bertambah otomatis setiap ada data baru)

            //foreign key ke table orders
            $table->foreignId('order_id')//Membuat kolom order_id sebagai Foreign Key yang terhubung ke kolom id pada tabel orders
                  ->constrained('orders')
                  ->onDelete('cascade');//bertujuan agar jika data pesanan utama di tabel orders dihapus, maka seluruh rincian pesanan terkait di tabel order_details ikut terhapus otomatis.

            //foreign key ke table foods
            $table->foreignId('food_id')//Membuat kolom food_id sebagai Foreign Key yang terhubung ke kolom id pada tabel foods, sehingga sistem mengetahui makanan apa yang dipesan pada baris tersebut.
                  ->constrained('foods')
                  ->onDelete('cascade');
            
            $table->integer('quantity');//Membuat kolom bertipe angka bulat (integer) untuk menyimpan jumlah porsi makanan yang dipesan
            $table->integer('subtotal');//Membuat kolom bertipe angka bulat untuk menyimpan total harga dari item tersebut (biasanya hasil dari harga makanan dikali quantity).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
