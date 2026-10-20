<?php

namespace App\Http\Controllers; // Menentukan lokasi namespace file controller ini

use App\Models\Food; // Mengimpor model Food untuk berinteraksi dengan tabel foods di database
use Illuminate\Http\Request; // Mengimpor class Request untuk menangkap data input dari form
use Illuminate\Support\Facades\Storage; // Mengimpor class Storage untuk mengelola (cek & hapus) file gambar

class FoodController extends Controller
{
    // Menampilkan halaman daftar seluruh makanan
    public function index()
    {
        // Mengambil data makanan diurutkan dari yang terbaru dan dibagi 10 data per halaman
        $foods = Food::latest()->paginate(10);
        // Menampilkan view admin/foods/index.blade.php sambil mengirim variabel $foods
        return view('admin.foods.index', compact('foods'));
    }

    // Menampilkan halaman form tambah makanan baru
    public function create()
    {
        // Membuka file tampilan resources/views/admin/foods/create.blade.php
        return view('admin.foods.create');
    }

    // Menyimpan data makanan baru dari form ke dalam database
    public function store(Request $request)
    {
        // Memvalidasi (memeriksa) data input dari form sebelum disimpan
        $request->validate([
            'name'        => 'required|string|max:255', // Nama wajib diisi, berupa teks, maksimal 255 karakter
            'category'    => 'required|in:Makanan,Minuman,Cemilan', // Kategori wajib diisi & harus salah satu dari pilihan ini
            'price'       => 'required|numeric|min:0', // Harga wajib diisi, berupa angka, minimal 0
            'description' => 'required|string', // Deskripsi wajib diisi dan berupa teks
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Gambar boleh kosong, format jpeg/png/jpg, maks 2MB
        ]);

        // Mengatur nilai awal path gambar menjadi null (kosong)
        $imagePath = null;
        // Mengecek apakah user mengunggah file pada input 'image'
        if ($request->hasFile('image')) {
            // Menyimpan file gambar ke folder storage/app/public/foods dan menyimpan path-nya ke $imagePath
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Menyimpan data makanan baru ke tabel foods di database
        Food::create([
            'name'        => $request->name, // Mengisi kolom name dari input form name
            'category'    => $request->category, // Mengisi kolom category dari input form category
            'price'       => $request->price, // Mengisi kolom price dari input form price
            'description' => $request->description, // Mengisi kolom description dari input form description
            'image'       => $imagePath, // Mengisi kolom image dengan lokasi file gambar ($imagePath)
        ]);

        // Mengarahkan kembali ke halaman daftar makanan dengan pesan sukses
        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil ditambahkan!');
    }

    // Menampilkan halaman form edit untuk 1 data makanan yang dipilih
    public function edit(Food $food)
    {
        // Menampilkan view admin/foods/edit.blade.php sambil mengirim data $food yang akan diedit
        return view('admin.foods.edit', compact('food'));
    }

    // Memperbarui (update) data makanan yang sudah ada di database
    public function update(Request $request, Food $food)
    {
        // Memvalidasi data input dari form edit
        $request->validate([
            'name'        => 'required|string|max:255', // Nama wajib diisi, berupa teks, maksimal 255 karakter
            'category'    => 'required|in:Makanan,Minuman,Cemilan', // Kategori wajib diisi & harus salah satu dari pilihan ini
            'price'       => 'required|numeric|min:0', // Harga wajib diisi, berupa angka, minimal 0
            'description' => 'required|string', // Deskripsi wajib diisi dan berupa teks
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Gambar baru boleh kosong, format jpeg/png/jpg, maks 2MB
        ]);

        // Menyimpan path gambar lama sebagai nilai bawaan jika user tidak mengganti gambar
        $imagePath = $food->image;
        // Mengecek apakah user mengunggah file gambar baru saat edit
        if ($request->hasFile('image')) {
            // Mengecek apakah data makanan sebelumnya punya gambar lama dan filenya masih ada di storage public
            if ($food->image && Storage::disk('public')->exists($food->image)) {
                // Menghapus file gambar lama dari storage agar tidak menumpuk
                Storage::disk('public')->delete($food->image);
            }
            // Menyimpan file gambar yang baru diunggah ke folder storage/app/public/foods
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Memperbarui data makanan di database dengan data terbaru
        $food->update([
            'name'        => $request->name, // Memperbarui kolom name dari input form
            'category'    => $request->category, // Memperbarui kolom category dari input form
            'price'       => $request->price, // Memperbarui kolom price dari input form
            'description' => $request->description, // Memperbarui kolom description dari input form
            'image'       => $imagePath, // Memperbarui kolom image dengan gambar baru (atau tetap gambar lama)
        ]);

        // Mengarahkan kembali ke halaman daftar makanan dengan pesan berhasil diperbarui
        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil diperbarui!');
    }

    // Menghapus data makanan dari database beserta file gambarnya
    public function destroy(Food $food)
    {
        // Mengecek apakah makanan memiliki gambar dan file gambarnya ada di dalam folder storage public
        if ($food->image && Storage::disk('public')->exists($food->image)) {
            // Menghapus file gambar dari storage
            Storage::disk('public')->delete($food->image);
        }
        // Menghapus baris data makanan tersebut dari tabel foods di database
        $food->delete();

        // Mengarahkan kembali ke halaman daftar makanan dengan pesan berhasil dihapus
        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil dihapus!');
    }
}