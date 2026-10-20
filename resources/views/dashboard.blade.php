{{-- Memakai layout utama aplikasi agar tampilan dashboard konsisten. --}}
<x-app-layout>
    {{-- Menentukan konten yang akan ditampilkan pada slot header layout. --}}
    <x-slot name="header">
        {{-- Menampilkan judul halaman dashboard. --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{-- Menggunakan fungsi translasi Laravel untuk teks judul. --}}
            {{ __('Daftar Pesanan Masuk') }}
        {{-- Menutup elemen judul halaman. --}}
        </h2>
    {{-- Menutup definisi slot header. --}}
    </x-slot>

    {{-- Memberi jarak vertikal untuk area utama halaman. --}}
    <div class="py-12">
        {{-- Membatasi lebar konten dan mengatur margin serta padding responsif. --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Memeriksa apakah session memiliki pesan sukses untuk ditampilkan. --}}
            @if(session('success'))
                {{-- Menampilkan pesan sukses dengan warna dan gaya notifikasi. --}}
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm font-medium">
                    {{-- Mencetak isi pesan sukses dari session. --}}
                    {{ session('success') }}
                {{-- Menutup kotak notifikasi sukses. --}}
                </div>
            {{-- Mengakhiri kondisi pemeriksaan pesan sukses. --}}
            @endif

            {{-- Membuat kartu putih sebagai wadah tabel pesanan. --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                {{-- Memberi padding dan memungkinkan tabel digulir secara horizontal. --}}
                <div class="p-6 text-gray-900 overflow-x-auto">
                    {{-- Membuat tabel selebar wadah dengan teks rata kiri. --}}
                    <table class="w-full text-left border-collapse">
                        {{-- Membuka bagian kepala tabel dan memberi gaya latar. --}}
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            {{-- Memulai baris judul kolom. --}}
                            <tr>
                                {{-- Judul kolom untuk nomor pesanan. --}}
                                <th class="p-4 border-b"># ID</th>
                                {{-- Judul kolom untuk nama pelanggan. --}}
                                <th class="p-4 border-b">Pelanggan</th>
                                {{-- Judul kolom untuk nomor meja. --}}
                                <th class="p-4 border-b">No. Meja</th>
                                {{-- Judul kolom untuk rincian item pesanan. --}}
                                <th class="p-4 border-b">Rincian Pesanan</th>
                                {{-- Judul kolom untuk total harga pesanan. --}}
                                <th class="p-4 border-b">Total Harga</th>
                                {{-- Judul kolom untuk status pesanan. --}}
                                <th class="p-4 border-b">Status</th>
                                {{-- Judul kolom untuk kontrol perubahan status. --}}
                                <th class="p-4 border-b text-center">Aksi Status</th>
                            {{-- Menutup baris judul kolom. --}}
                            </tr>
                        {{-- Menutup bagian kepala tabel. --}}
                        </thead>
                        {{-- Membuka bagian isi tabel dan memberi garis pemisah antarbaris. --}}
                        <tbody class="divide-y text-sm">
                            {{-- Menampilkan setiap pesanan; bagian @empty dipakai jika tidak ada pesanan. --}}
                            @forelse($orders as $order)
                                {{-- Memulai baris data untuk satu pesanan. --}}
                                <tr class="hover:bg-gray-50">
                                    {{-- Menampilkan ID pesanan dengan tanda pagar. --}}
                                    <td class="p-4 font-bold text-gray-700">#{{ $order->id }}</td>
                                    {{-- Menampilkan nama pelanggan pesanan. --}}
                                    <td class="p-4 font-medium">{{ $order->customer_name }}</td>
                                    {{-- Membuka sel yang menampilkan nomor meja. --}}
                                    <td class="p-4">
                                        {{-- Memberi tampilan lencana pada informasi meja. --}}
                                        <span class="bg-blue-100 text-blue-800 font-bold px-2.5 py-1 rounded-full text-xs">
                                            {{-- Menampilkan nomor meja milik pesanan. --}}
                                            Meja {{ $order->table_number }}
                                        {{-- Menutup lencana nomor meja. --}}
                                        </span>
                                    {{-- Menutup sel nomor meja. --}}
                                    </td>
                                    {{-- Membuka sel untuk daftar rincian makanan yang dipesan. --}}
                                    <td class="p-4">
                                        {{-- Membuat daftar berpoin untuk item-item pesanan. --}}
                                        <ul class="list-disc list-inside space-y-1 text-gray-600">
                                            {{-- Mengulang semua rincian yang berelasi dengan pesanan ini. --}}
                                            @foreach($order->orderDetails as $detail)
                                                {{-- Memulai satu item rincian pesanan. --}}
                                                <li>
                                                    {{-- Menampilkan nama makanan; memakai 'Menu' jika relasi makanan kosong. --}}
                                                    <strong>{{ $detail->food->name ?? 'Menu' }}</strong> 
                                                    {{-- Menampilkan jumlah item yang dipesan. --}}
                                                    x{{ $detail->quantity }} 
                                                    {{-- Menampilkan subtotal item dalam format angka rupiah. --}}
                                                    <span class="text-xs text-gray-400">(Rp {{ number_format($detail->subtotal) }})</span>
                                                {{-- Menutup satu item rincian pesanan. --}}
                                                </li>
                                            {{-- Mengakhiri pengulangan rincian pesanan. --}}
                                            @endforeach
                                        {{-- Menutup daftar rincian pesanan. --}}
                                        </ul>
                                    {{-- Menutup sel rincian pesanan. --}}
                                    </td>
                                    {{-- Membuka sel untuk total harga dengan penekanan visual. --}}
                                    <td class="p-4 font-bold text-green-600">
                                        {{-- Menampilkan total harga dalam format angka rupiah. --}}
                                        Rp {{ number_format($order->total_price) }}
                                    {{-- Menutup sel total harga. --}}
                                    </td>
                                    {{-- Membuka sel yang menampilkan status pesanan. --}}
                                    <td class="p-4">
                                        {{-- Memeriksa apakah status pesanan adalah pending. --}}
                                        @if(strtolower($order->status) == 'pending')
                                            {{-- Menampilkan status pending dengan lencana kuning. --}}
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-1 rounded">PENDING</span>
                                        {{-- Memeriksa status completed atau selesai tanpa membedakan huruf besar-kecil. --}}
                                        @elseif(strtolower($order->status) == 'completed' || strtolower($order->status) == 'selesai')
                                            {{-- Menampilkan status selesai dengan lencana hijau. --}}
                                            <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-1 rounded">SELESAI</span>
                                        {{-- Menangani status lain selain pending dan completed/selesai. --}}
                                        @else
                                            {{-- Menampilkan status lainnya dengan lencana merah dalam huruf kapital. --}}
                                            <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-1 rounded">{{ strtoupper($order->status) }}</span>
                                        {{-- Mengakhiri percabangan tampilan status pesanan. --}}
                                        @endif
                                    {{-- Menutup sel status pesanan. --}}
                                    </td>
                                    {{-- Membuka sel berisi kontrol untuk mengubah status pesanan. --}}
                                    <td class="p-4 text-center">
                                        {{-- Mengirim perubahan status ke route admin menggunakan metode POST. --}}
                                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                                            {{-- Menyisipkan token CSRF untuk melindungi formulir. --}}
                                            @csrf
                                            {{-- Mengubah metode POST menjadi PATCH untuk pembaruan data. --}}
                                            @method('PATCH')
                                            {{-- Membuat pilihan status dan otomatis mengirim formulir saat pilihan berubah. --}}
                                            <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-300 rounded p-1.5 bg-white shadow-sm font-semibold">
                                                {{-- Menandai opsi pending sebagai terpilih jika status saat ini pending. --}}
                                                <option value="pending" {{ strtolower($order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                {{-- Menandai opsi selesai sebagai terpilih untuk status completed atau selesai. --}}
                                                <option value="completed" {{ strtolower($order->status) == 'completed' || strtolower($order->status) == 'selesai' ? 'selected' : '' }}>Selesai / Lunas</option>
                                                {{-- Menandai opsi batal sebagai terpilih untuk status cancelled atau batal. --}}
                                                <option value="cancelled" {{ strtolower($order->status) == 'cancelled' || strtolower($order->status) == 'batal' ? 'selected' : '' }}>Batalkan</option>
                                            {{-- Menutup daftar pilihan status. --}}
                                            </select>  
                                        {{-- Menutup formulir pembaruan status. --}}
                                        </form>
                                    {{-- Menutup sel kontrol status. --}}
                                    </td>
                                {{-- Menutup baris data pesanan. --}}
                                </tr>
                            {{-- Menampilkan satu baris pemberitahuan jika tidak ada pesanan. --}}
                            @empty
                                {{-- Memulai baris kosong yang mencakup seluruh tujuh kolom tabel. --}}
                                <tr>
                                    {{-- Memberi tahu pengguna bahwa belum ada pesanan masuk. --}}
                                    <td colspan="7" class="p-6 text-center text-gray-500">Belum ada pesanan masuk.</td>
                                {{-- Menutup baris pemberitahuan kosong. --}}
                                </tr>
                            {{-- Mengakhiri perulangan pesanan beserta kondisi kosongnya. --}}
                            @endforelse
                        {{-- Menutup bagian isi tabel. --}}
                        </tbody>
                    {{-- Menutup tabel pesanan. --}}
                    </table>
                {{-- Menutup wadah dalam tabel. --}}
                </div>
            {{-- Menutup kartu tabel pesanan. --}}
            </div>

        {{-- Menutup pembatas lebar konten utama. --}}
        </div>
    {{-- Menutup area utama halaman. --}}
    </div>
{{-- Menutup layout utama aplikasi. --}}
</x-app-layout>
