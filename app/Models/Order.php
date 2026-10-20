<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model//Mendefinisikan model Order yang otomatis terhubung ke tabel orders di database.
{
    use HasFactory;

    protected $guarded = ['id'];//: Mengizinkan semua kolom di tabel orders untuk diisi langsung menggunakan Order::create([...]), kecuali kolom id.

    public function orderDetails()//Membuat fungsi relasi bernama orderDetails agar saat kamu mengambil data suatu pesanan (Order), kamu bisa langsung memanggil daftar rincian item makanan yang ada di dalam pesanan tersebut (misalnya dengan $order->orderDetails).
    {
        return $this->hasMany(OrderDetail::class, 'order_id');//Mendefinisikan relasi One-to-Many (Satu ke Banyak). Artinya, 1 data pesanan (Order) bisa memiliki banyak rincian item pesanan (OrderDetail) yang dihubungkan melalui Foreign Key order_id.
    }
}
