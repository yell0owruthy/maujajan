<x-app-layout>
    {{-- Bagian judul halaman di header atas --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Dissert</h2>
    </x-slot>

    <div class="py-12 max-w-2xl mx-auto sm:px-6 lg:px-8">
        {{-- Form untuk mengirim data makanan baru ke route foods.store (fungsi store di FoodController) --}}
        {{-- enctype="multipart/form-data" wajib ada agar form bisa mengunggah file gambar --}}
        <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-sm border">
            {{-- Token keamanan wajib di Laravel untuk setiap form bermetode POST --}}
            @csrf

            {{-- Input Nama Makanan --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Dissert</label>
                <input type="text" name="name" class="w-full border rounded p-2" required>
            </div>

            {{-- Pilihan Dropdown Kategori Makanan --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori</label>
                <select name="category" class="w-full border rounded p-2" required>
                    <option value="Minuman">Minuman</option>
                    <option value="Dissert">Dissert</option>
                    <option value="Chiki">Chiki</option>
                </select>
            </div>

            {{-- Input Harga Makanan (hanya menerima angka karena type="number") --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Harga (Rp)</label>
                <input type="number" name="price" class="w-full border rounded p-2" required>
            </div>

            {{-- Input Deskripsi Makanan (kotak teks panjang 3 baris) --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Deskripsi</label>
                <textarea name="description" class="w-full border rounded p-2" rows="3" required></textarea>
            </div>

            {{-- Input Upload File Gambar Makanan (opsional / tidak ada atribut required) --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Gambar Makanan</label>
                <input type="file" name="image" class="w-full border rounded p-2">
            </div>

            {{-- Tombol Submit untuk menyimpan data --}}
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded font-semibold">Simpan Data</button>
        </form>
    </div>
</x-app-layout>