<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard Manajer Gudang</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Pantau kondisi stok dan transaksi hari ini</p>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- ========================= --}}
        {{-- CARD RINGKASAN HARI INI --}}
        {{-- ========================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            {{-- STOK MENIPIS --}}
            <div class="rounded-3xl bg-gradient-to-br from-rose-500 to-rose-700 p-6 shadow-lg text-white">
                <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-rose-100">Stok Menipis</p>
                <h3 class="text-4xl font-bold mt-2">{{ $lowStocks->count() }}</h3>
                <p class="text-xs text-rose-200 mt-1">produk perlu restok segera</p>
            </div>

            {{-- BARANG MASUK HARI INI --}}
            <div class="rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 shadow-lg text-white">
                <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-emerald-100">Barang Masuk Hari Ini</p>
                <h3 class="text-4xl font-bold mt-2">{{ $todayIn->count() }}</h3>
                <p class="text-xs text-emerald-200 mt-1">transaksi masuk</p>
            </div>

            {{-- BARANG KELUAR HARI INI --}}
            <div class="rounded-3xl bg-gradient-to-br from-amber-400 to-amber-600 p-6 shadow-lg text-white">
                <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-amber-100">Barang Keluar Hari Ini</p>
                <h3 class="text-4xl font-bold mt-2">{{ $todayOut->count() }}</h3>
                <p class="text-xs text-amber-200 mt-1">transaksi keluar</p>
            </div>

        </div>

        {{-- ========================= --}}
        {{-- STOK MENIPIS --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

            <h3 class="text-xl font-semibold text-red-500 mb-6">⚠ Produk Stok Menipis (≤ 5)</h3>

            @if($lowStocks->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-6 py-4 font-semibold">Produk</th>
                                <th class="px-6 py-4 font-semibold">Kategori</th>
                                <th class="px-6 py-4 font-semibold">Supplier</th>
                                <th class="px-6 py-4 font-semibold text-center">Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStocks as $product)
                                <tr class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                                    <td class="px-6 py-4">{{ $product->category->name ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $product->supplier->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-2xl p-4">
                    Semua stok produk aman ✓
                </div>
            @endif

        </div>

        {{-- ========================= --}}
        {{-- BARANG MASUK HARI INI --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

            <h3 class="text-xl font-semibold text-emerald-600 dark:text-emerald-400 mb-6">📦 Barang Masuk Hari Ini</h3>

            @if($todayIn->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-6 py-4 font-semibold">Produk</th>
                                <th class="px-6 py-4 font-semibold text-center">Qty</th>
                                <th class="px-6 py-4 font-semibold">Dicatat Oleh</th>
                                <th class="px-6 py-4 font-semibold">Note</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                                <th class="px-6 py-4 font-semibold text-center">Waktu</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todayIn as $t)
                                <tr class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-6 py-4 font-medium">{{ $t->product->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $t->qty }}</td>
                                    <td class="px-6 py-4">{{ $t->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $t->note ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $t->status == 'confirmed' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                            {{ strtoupper($t->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">{{ $t->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status === 'pending')
                                            <form action="{{ route('stock-transactions.confirm', $t->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium transition"
                                                        onclick="return confirm('Konfirmasi penerimaan barang ini?')">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-emerald-500 text-xs font-medium">✓ Done</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-700/30 text-gray-500 rounded-2xl p-4 text-sm">
                    Belum ada barang masuk hari ini
                </div>
            @endif

        </div>

        {{-- ========================= --}}
        {{-- BARANG KELUAR HARI INI --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

            <h3 class="text-xl font-semibold text-amber-500 mb-6">🚚 Barang Keluar Hari Ini</h3>

            @if($todayOut->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-6 py-4 font-semibold">Produk</th>
                                <th class="px-6 py-4 font-semibold text-center">Qty</th>
                                <th class="px-6 py-4 font-semibold">Dicatat Oleh</th>
                                <th class="px-6 py-4 font-semibold">Note</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                                <th class="px-6 py-4 font-semibold text-center">Waktu</th>
                                <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($todayOut as $t)
                                <tr class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-6 py-4 font-medium">{{ $t->product->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $t->qty }}</td>
                                    <td class="px-6 py-4">{{ $t->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $t->note ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $t->status == 'confirmed' ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                            {{ strtoupper($t->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">{{ $t->created_at->format('H:i') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($t->status === 'pending')
                                            <form action="{{ route('stock-transactions.confirm', $t->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium transition"
                                                        onclick="return confirm('Konfirmasi pengeluaran barang ini?')">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-emerald-500 text-xs font-medium">✓ Done</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-700/30 text-gray-500 rounded-2xl p-4 text-sm">
                    Belum ada barang keluar hari ini
                </div>
            @endif

        </div>

    </div>

</x-app-layout>