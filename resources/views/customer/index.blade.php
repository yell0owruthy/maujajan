<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu dan Pemesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4 font-sans sm:p-6">
    <main class="mx-auto max-w-5xl">
        <header class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-gray-800">Menu Maujajan</h1>
            <p class="mt-1 text-sm text-gray-500">Pilih menu dan jumlah yang ingin dipesan</p>
        </header>

        @if (session('success'))
            <div role="status" class="mb-6 rounded-xl border border-green-400 bg-green-100 px-4 py-3 text-center font-semibold text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div role="alert" class="mb-6 rounded-xl border border-red-400 bg-red-100 px-4 py-3 text-center font-semibold text-red-700">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div role="alert" class="mb-6 rounded-xl border border-red-400 bg-red-100 px-4 py-3 font-semibold text-red-700">
                <ul class="list-inside list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $categories = $foods->pluck('category')->filter()->unique();
        @endphp

        <div class="mb-6 flex flex-wrap justify-center gap-3">
            <button type="button" data-category="all" onclick="filterCategory(this)" class="category-filter rounded-full bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-md">
                Semua Menu
            </button>
            @foreach ($categories as $category)
                <button type="button" data-category="{{ $category }}" onclick="filterCategory(this)" class="category-filter rounded-full border bg-white px-5 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-200">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <form action="{{ route('customer.checkout') }}" method="POST">
            @csrf

            <section class="mb-8 rounded-xl border bg-white p-6 shadow-sm">
                <h2 class="mb-4 border-b pb-2 text-lg font-bold text-gray-700">Informasi Pemesan</h2>
                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label for="customer_name" class="mb-1 block text-sm font-semibold text-gray-600">Nama Lengkap</label>
                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            maxlength="255"
                            required
                            placeholder="Masukkan nama pemesan"
                            class="w-full rounded-lg border px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>
                    <div>
                        <label for="table_number" class="mb-1 block text-sm font-semibold text-gray-600">Nomor Meja</label>
                        <input
                            type="number"
                            id="table_number"
                            name="table_number"
                            value="{{ old('table_number') }}"
                            min="1"
                            step="1"
                            required
                            placeholder="Masukkan nomor meja"
                            class="w-full rounded-lg border px-4 py-2 outline-none focus:ring-2 focus:ring-indigo-500"
                        >
                    </div>
                </div>
            </section>

            <section>
                <h2 class="mb-4 text-lg font-bold text-gray-700">Pilih Menu</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @forelse ($foods as $food)
                        <article data-category="{{ $food->category }}" class="food-card flex flex-col justify-between overflow-hidden rounded-xl border bg-white shadow-sm">
                            <div>
                                @if ($food->image)
                                    <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}" class="h-40 w-full object-cover">
                                @else
                                    <div class="flex h-40 items-center justify-center bg-gray-200 font-medium text-gray-400">Tanpa Gambar</div>
                                @endif

                                <div class="p-4">
                                    <div class="mb-2 flex items-center justify-between gap-2">
                                        <span class="rounded bg-indigo-100 px-2.5 py-0.5 text-xs font-semibold text-indigo-700">{{ $food->category }}</span>
                                        <span class="font-bold text-green-600">Rp {{ number_format($food->price, 0, ',', '.') }}</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">{{ $food->name }}</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $food->description }}</p>
                                </div>
                            </div>

                            <div class="border-t bg-gray-50 p-4">
                                <label for="food-{{ $food->id }}" class="mb-1 block text-xs font-semibold text-gray-600">Jumlah</label>
                                <input
                                    type="number"
                                    id="food-{{ $food->id }}"
                                    name="items[{{ $food->id }}]"
                                    min="0"
                                    step="1"
                                    value="{{ old('items.' . $food->id, 0) }}"
                                    class="w-full rounded-lg border px-3 py-2 text-center font-bold text-gray-700 outline-none focus:ring-2 focus:ring-indigo-500"
                                >
                            </div>
                        </article>
                    @empty
                        <p class="col-span-full py-10 text-center text-gray-500">Belum ada menu yang tersedia.</p>
                    @endforelse
                </div>
            </section>

            @if ($foods->isNotEmpty())
                <div class="mt-8 text-right">
                    <button type="submit" class="rounded-xl bg-indigo-600 px-8 py-3 font-bold text-white shadow-md transition hover:bg-indigo-700">
                        Buat Pesanan
                    </button>
                </div>
            @endif
        </form>
    </main>

    <script>
        function filterCategory(button) {
            const category = button.dataset.category;

            document.querySelectorAll('.category-filter').forEach((filterButton) => {
                filterButton.className = 'category-filter rounded-full border bg-white px-5 py-2 text-sm font-semibold text-gray-600 transition hover:bg-gray-200';
            });
            button.className = 'category-filter rounded-full bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-md';

            document.querySelectorAll('.food-card').forEach((card) => {
                card.style.display = category === 'all' || card.dataset.category === category ? 'flex' : 'none';
            });
        }
    </script>
</body>
</html>
