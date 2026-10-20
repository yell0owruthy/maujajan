<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model//Mendefinisikan model OrderDetail untuk berinteraksi dengan data rincian pesanan di database.
{
    use HasFactory;

    protected $table = 'order_details';//Memastikan model ini terhubung langsung ke tabel order_details.
    protected $guarded = ['id'];//Mengizinkan semua kolom (seperti order_id, food_id, quantity, dan subtotal) diisi secara langsung menggunakan OrderDetail::create([...]), kecuali kolom id.

    public function food()//Membuat relasi Many-to-One (Milik / Merujuk ke Satu) ke model Food melalui kolom food_id. Artinya, setiap 1 baris rincian pesanan merujuk pada 1 menu makanan tertentu—sehingga nantinya kamu bisa langsung mengambil nama atau harga makanan cukup dengan menulis $detail->food->name.
    {
        return $this->belongsTo(Food::class,'food_id');
    }
    public function order()//Membuat relasi Many-to-One ke model Order melalui kolom order_id. Artinya, setiap baris rincian pesanan ini adalah bagian/milik dari 1 transaksi pesanan (Order) utama.
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
