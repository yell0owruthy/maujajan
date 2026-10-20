<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Food extends Model//Membuat class Food yang mewarisi fitur Eloquent Model bawaan Laravel, sehingga kamu bisa mengelola data makanan (menambah, menampilkan, mengedit, dan menghapus data) tanpa perlu menulis perintah SQL manual.
{
    use HasFactory;//Mengaktifkan fitur Factory pada model Food agar model ini bisa digunakan untuk membuat data dummy otomatis jika diperlukan.
    protected $table ='foods';//Memaksa model Food agar terhubung ke tabel bernama foods (menggunakan huruf s) di database. Baris ini sangat penting karena secara bawaan Laravel menganggap bentuk jamak dari food adalah tetap food (tanpa s).
    protected $guarded  = ['id'];//Mengizinkan semua kolom di tabel foods (seperti nama makanan, harga, stok, dll.) untuk diisi secara langsung menggunakan Food::create([...])—kecuali kolom id yang dilindungi agar tidak bisa diubah manual. Ini adalah alternatif dari $fillable, sehingga kamu tidak perlu mendaftarkan nama kolom satu per satu.
}
