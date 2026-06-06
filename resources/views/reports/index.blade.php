<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Laporan
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Ekspor & analisis data stok, transaksi, dan aktivitas
            </p>
        </div>
    </x-slot>

    @php $role = Auth::user()->role; @endphp

    <div class="space-y-6">

        {{-- ================================================================
             TAB NAVIGATION
        ================================================================ --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100
                    dark:border-gray-700 shadow-sm p-2 flex gap-2 flex-wrap">

            {{-- TAB: Laporan Stok — admin & manajer_gudang --}}
            <a href="{{ route('reports.index', array_merge(request()->except('tab'), ['tab' => 'stock'])) }}"
               class="flex items-center gap-2 px-5 py-3 rounded-2xl font-medium text-sm transition
                      {{ $activeTab === 'stock'
                            ? 'bg-blue-600 text-white shadow'
                            : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4"/>
                </svg>
                Laporan Stok
            </a>

            {{-- TAB: Laporan Transaksi — admin & manajer_gudang --}}
            <a href="{{ route('reports.index', array_merge(request()->except('tab'), ['tab' => 'transactions'])) }}"
               class="flex items-center gap-2 px-5 py-3 rounded-2xl font-medium text-sm transition
                      {{ $activeTab === 'transactions'
                            ? 'bg-blue-600 text-white shadow'
                            : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8L10 18l-5-5"/>
                </svg>
                Laporan Transaksi
            </a>

            {{-- TAB: Aktivitas Pengguna — admin only --}}
            @if($role === 'admin')
                <a href="{{ route('reports.index', array_merge(request()->except('tab'), ['tab' => 'activity'])) }}"
                   class="flex items-center gap-2 px-5 py-3 rounded-2xl font-medium text-sm transition
                          {{ $activeTab === 'activity'
                                ? 'bg-blue-600 text-white shadow'
                                : 'text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2
                                 M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Aktivitas Pengguna
                </a>
            @endif

        </div>

        {{-- ================================================================
             TAB CONTENT: LAPORAN STOK
        ================================================================ --}}
        @if($activeTab === 'stock')

            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100
                        dark:border-gray-700 shadow-sm p-6 space-y-6">

                {{-- Header & tombol export --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                            📦 Laporan Stok Barang
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            Data stok per produk dengan filter kategori & periode
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('reports.stock.pdf', request()->except('tab')) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl
                                  bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40
                                  text-red-600 dark:text-red-400 font-medium text-sm transition">
                            Export PDF
                        </a>
                        <a href="{{ route('reports.stock.excel', request()->except('tab')) }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl
                                  bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/40
                                  text-green-600 dark:text-green-400 font-medium text-sm transition">
                            Export Excel
                        </a>
                    </div>

                </div>

                {{-- Filter --}}
                <form method="GET" action="{{ route('reports.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">

                    <input type="hidden" name="tab" value="stock">

                    <select name="category_id"
                            class="rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                   px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="date" name="date_from"
                           value="{{ $filters['date_from'] ?? '' }}"
                           class="rounded-2xl border border-gray-200 dark:border-gray-700
                                  bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <input type="date" name="date_to"
                           value="{{ $filters['date_to'] ?? '' }}"
                           class="rounded-2xl border border-gray-200 dark:border-gray-700
                                  bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <div class="flex gap-2">
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white
                                       px-4 py-3 rounded-2xl font-medium text-sm transition">
                            Filter
                        </button>
                        <a href="{{ route('reports.index', ['tab' => 'stock']) }}"
                           class="px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700
                                  text-gray-500 dark:text-gray-400
                                  hover:bg-gray-100 dark:hover:bg-gray-700 text-sm transition">
                            Reset
                        </a>
                    </div>

                </form>

                {{-- Summary cards --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl p-4">
                        <p class="text-xs text-blue-600 dark:text-blue-400 font-medium uppercase tracking-wide">
                            Total Produk
                        </p>
                        <p class="text-3xl font-bold text-blue-700 dark:text-blue-300 mt-1">
                            {{ $products->total() }}
                        </p>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-2xl p-4">
                        <p class="text-xs text-green-600 dark:text-green-400 font-medium uppercase tracking-wide">
                            Total Stok
                        </p>
                        <p class="text-3xl font-bold text-green-700 dark:text-green-300 mt-1">
                            {{ number_format($totalStockIn) }}
                        </p>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-left">
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">No</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Produk</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Kategori</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Supplier</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Stok</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Harga</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Tgl Input</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($products as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition
                                           text-gray-800 dark:text-gray-200">
                                    <td class="px-5 py-3.5">
                                        {{ $products->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-5 py-3.5 font-medium">{{ $product->name }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30
                                                     text-blue-700 dark:text-blue-300 rounded-lg text-xs">
                                            {{ $product->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">
                                        {{ $product->supplier->name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($product->stock <= 5)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1
                                                         bg-red-50 dark:bg-red-900/30
                                                         text-red-600 dark:text-red-400
                                                         rounded-lg text-xs font-semibold">
                                                ⚠ {{ $product->stock }}
                                            </span>
                                        @else
                                            <span class="font-semibold">{{ $product->stock }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">
                                        {{ $product->created_at->format('d M Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                                        Tidak ada data produk
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>{{ $products->appends(request()->query())->links() }}</div>

            </div>

        @endif

        {{-- ================================================================
             TAB CONTENT: LAPORAN TRANSAKSI
        ================================================================ --}}
        @if($activeTab === 'transactions')

            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100
                        dark:border-gray-700 shadow-sm p-6 space-y-6">

                {{-- Header & tombol export --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                            🔄 Laporan Transaksi Barang
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            Riwayat barang masuk & keluar per periode
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('reports.transaction.pdf', request()->except('tab')) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl
                                  bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40
                                  text-red-600 dark:text-red-400 font-medium text-sm transition">
                            Export PDF
                        </a>
                        <a href="{{ route('reports.transaction.excel', request()->except('tab')) }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl
                                  bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/40
                                  text-green-600 dark:text-green-400 font-medium text-sm transition">
                            Export Excel
                        </a>
                    </div>

                </div>

                {{-- Filter --}}
                <form method="GET" action="{{ route('reports.index') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-3">

                    <input type="hidden" name="tab" value="transactions">

                    <select name="type"
                            class="rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                   px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Semua Tipe</option>
                        <option value="in"  {{ ($filters['type'] ?? '') === 'in'  ? 'selected' : '' }}>
                            ▲ Masuk
                        </option>
                        <option value="out" {{ ($filters['type'] ?? '') === 'out' ? 'selected' : '' }}>
                            ▼ Keluar
                        </option>
                    </select>

                    <select name="category_id"
                            class="rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                   px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}"
                                {{ ($filters['category_id'] ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>

                    <input type="date" name="date_from"
                           value="{{ $filters['date_from'] ?? '' }}"
                           class="rounded-2xl border border-gray-200 dark:border-gray-700
                                  bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <input type="date" name="date_to"
                           value="{{ $filters['date_to'] ?? '' }}"
                           class="rounded-2xl border border-gray-200 dark:border-gray-700
                                  bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <div class="flex gap-2">
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white
                                       px-4 py-3 rounded-2xl font-medium text-sm transition">
                            Filter
                        </button>
                        <a href="{{ route('reports.index', ['tab' => 'transactions']) }}"
                           class="px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700
                                  text-gray-500 dark:text-gray-400
                                  hover:bg-gray-100 dark:hover:bg-gray-700 text-sm transition">
                            Reset
                        </a>
                    </div>

                </form>

                {{-- Summary cards --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-2xl p-4">
                        <p class="text-xs text-green-600 dark:text-green-400 font-medium uppercase tracking-wide">
                            Total Masuk (qty)
                        </p>
                        <p class="text-3xl font-bold text-green-700 dark:text-green-300 mt-1">
                            {{ number_format($totalIn) }}
                        </p>
                    </div>
                    <div class="bg-red-50 dark:bg-red-900/20 rounded-2xl p-4">
                        <p class="text-xs text-red-600 dark:text-red-400 font-medium uppercase tracking-wide">
                            Total Keluar (qty)
                        </p>
                        <p class="text-3xl font-bold text-red-700 dark:text-red-300 mt-1">
                            {{ number_format($totalOut) }}
                        </p>
                    </div>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-left">
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">No</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Produk</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Kategori</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">User</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Tipe</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Qty</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Catatan</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($transactions as $t)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition
                                           text-gray-800 dark:text-gray-200">
                                    <td class="px-5 py-3.5">
                                        {{ $transactions->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-5 py-3.5 font-medium">
                                        {{ $t->product->name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30
                                                     text-blue-700 dark:text-blue-300 rounded-lg text-xs">
                                            {{ $t->product->category->name ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">
                                        {{ $t->user->name ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @if($t->type === 'in')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1
                                                         bg-green-50 dark:bg-green-900/30
                                                         text-green-600 dark:text-green-400
                                                         rounded-lg text-xs font-semibold">
                                                ▲ Masuk
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1
                                                         bg-red-50 dark:bg-red-900/30
                                                         text-red-600 dark:text-red-400
                                                         rounded-lg text-xs font-semibold">
                                                ▼ Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 font-semibold">{{ $t->qty }}</td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">
                                        {{ $t->note ?? '-' }}
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">
                                        {{ $t->created_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8"
                                        class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                                        Tidak ada data transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>{{ $transactions->appends(request()->query())->links() }}</div>

            </div>

        @endif

        {{-- ================================================================
             TAB CONTENT: LAPORAN AKTIVITAS (admin only)
        ================================================================ --}}
        @if($activeTab === 'activity' && $role === 'admin')

            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100
                        dark:border-gray-700 shadow-sm p-6 space-y-6">

                {{-- Header & tombol export --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                            📋 Laporan Aktivitas Pengguna
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                            Riwayat seluruh aktivitas user di sistem
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('reports.activity.pdf', request()->except('tab')) }}"
                           target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl
                                  bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40
                                  text-red-600 dark:text-red-400 font-medium text-sm transition">
                            Export PDF
                        </a>
                        <a href="{{ route('reports.activity.excel', request()->except('tab')) }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl
                                  bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/40
                                  text-green-600 dark:text-green-400 font-medium text-sm transition">
                            Export Excel
                        </a>
                    </div>

                </div>

                {{-- Filter --}}
                <form method="GET" action="{{ route('reports.index') }}"
                      class="grid grid-cols-1 md:grid-cols-4 gap-3">

                    <input type="hidden" name="tab" value="activity">

                    <input type="text" name="search"
                           value="{{ $filters['search'] ?? '' }}"
                           placeholder="Cari user / aktivitas..."
                           class="rounded-2xl border border-gray-200 dark:border-gray-700
                                  bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <input type="date" name="date_from"
                           value="{{ $filters['date_from'] ?? '' }}"
                           class="rounded-2xl border border-gray-200 dark:border-gray-700
                                  bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <input type="date" name="date_to"
                           value="{{ $filters['date_to'] ?? '' }}"
                           class="rounded-2xl border border-gray-200 dark:border-gray-700
                                  bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white
                                  px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <div class="flex gap-2">
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white
                                       px-4 py-3 rounded-2xl font-medium text-sm transition">
                            Filter
                        </button>
                        <a href="{{ route('reports.index', ['tab' => 'activity']) }}"
                           class="px-4 py-3 rounded-2xl border border-gray-200 dark:border-gray-700
                                  text-gray-500 dark:text-gray-400
                                  hover:bg-gray-100 dark:hover:bg-gray-700 text-sm transition">
                            Reset
                        </a>
                    </div>

                </form>

                {{-- Summary card --}}
                <div class="bg-purple-50 dark:bg-purple-900/20 rounded-2xl p-4">
                    <p class="text-xs text-purple-600 dark:text-purple-400 font-medium uppercase tracking-wide">
                        Total Log
                    </p>
                    <p class="text-3xl font-bold text-purple-700 dark:text-purple-300 mt-1">
                        {{ number_format($totalLogs) }}
                    </p>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto rounded-2xl border border-gray-100 dark:border-gray-700">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50 text-left">
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">No</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">User</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Role</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Aktivitas</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Deskripsi</th>
                                <th class="px-5 py-3.5 font-semibold text-gray-600 dark:text-gray-300">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse($logs as $log)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition
                                           text-gray-800 dark:text-gray-200">
                                    <td class="px-5 py-3.5">
                                        {{ $logs->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-5 py-3.5 font-medium">
                                        {{ $log->user->name ?? 'Unknown' }}
                                    </td>
                                    <td class="px-5 py-3.5">
                                        @php
                                            $roleColors = [
                                                'admin'          => 'bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300',
                                                'manajer_gudang' => 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300',
                                                'staff_gudang'   => 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300',
                                            ];
                                            $rc = $roleColors[$log->user->role ?? ''] ?? 'bg-gray-100 text-gray-600';
                                        @endphp
                                        <span class="px-2.5 py-1 rounded-lg text-xs {{ $rc }}">
                                            {{ str_replace('_', ' ', $log->user->role ?? '-') }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5">
                                        <span class="px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30
                                                     text-blue-700 dark:text-blue-300 rounded-lg text-xs font-medium">
                                            {{ $log->activity }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">
                                        {{ $log->description }}
                                    </td>
                                    <td class="px-5 py-3.5 text-gray-500 dark:text-gray-400">
                                        {{ $log->created_at->format('d M Y, H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-5 py-10 text-center text-gray-400 dark:text-gray-500">
                                        Tidak ada data aktivitas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>{{ $logs->appends(request()->query())->links() }}</div>

            </div>

        @endif

    </div>

</x-app-layout>