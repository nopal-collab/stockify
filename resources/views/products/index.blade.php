<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Manajemen Produk
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola data produk dan inventaris
                </p>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SUCCESS ALERT --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 p-4">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-green-700 dark:text-green-300">Berhasil</h4>
                        <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- MAIN CARD --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm overflow-hidden">

                {{-- TOP BAR --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700 space-y-4">

                    {{-- ROW 1: Tombol Aksi --}}
                    <div class="flex flex-wrap gap-3">

                        {{-- TAMBAH PRODUK — admin & manajer --}}
                        @if(in_array(auth()->user()->role, ['admin', 'manajer_gudang']))
                            <a href="{{ route('products.create') }}"
                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold transition duration-300 shadow-lg shadow-blue-500/20">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Produk
                            </a>
                        @endif

                        {{-- EXPORT PDF --}}
                        <a href="{{ route('products.report') }}" target="_blank"
                           class="inline-flex items-center gap-2 bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/40 text-red-600 dark:text-red-400 px-5 py-3 rounded-2xl font-semibold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export PDF
                        </a>

                        {{-- EXPORT EXCEL --}}
                        <a href="{{ route('products.export') }}"
                           class="inline-flex items-center gap-2 bg-green-50 dark:bg-green-900/20 hover:bg-green-100 dark:hover:bg-green-900/40 text-green-600 dark:text-green-400 px-5 py-3 rounded-2xl font-semibold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Export Excel
                        </a>

                        {{-- IMPORT EXCEL — admin only --}}
                        @if(auth()->user()->role === 'admin')
                            <form action="{{ route('products.import') }}" method="POST"
                                  enctype="multipart/form-data"
                                  class="inline-flex flex-wrap items-center gap-2">
                                @csrf
                                <input type="file" name="file" required
                                       class="rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-2.5 text-sm">
                                <button type="submit"
                                        class="inline-flex items-center gap-2 bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/40 text-purple-600 dark:text-purple-400 px-5 py-3 rounded-2xl font-semibold transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Import Excel
                                </button>
                            </form>
                        @endif

                    </div>

                    {{-- ROW 2: Filter & Search --}}
                    <form action="{{ route('products.index') }}" method="GET"
                          class="flex flex-wrap gap-3">

                        {{-- SEARCH --}}
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari produk..."
                                   class="w-full sm:w-64 pl-12 pr-4 py-3 rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-500 outline-none transition">
                        </div>

                        {{-- CATEGORY --}}
                        <select name="category_id"
                                class="w-full sm:w-52 rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-3 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-500 outline-none transition">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        {{-- SUPPLIER --}}
                        <select name="supplier_id"
                                class="w-full sm:w-52 rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white px-4 py-3 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-500 outline-none transition">
                            <option value="">Semua Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                                class="bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold transition">
                            Filter
                        </button>

                        <a href="{{ route('products.index') }}"
                           class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white px-5 py-3 rounded-2xl font-semibold transition">
                            Reset
                        </a>

                    </form>

                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">

                        <thead class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Foto</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Produk</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Kategori</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Supplier</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap text-center">Stok</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Harga Beli</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Harga Jual</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($products as $product)
                                <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition duration-200">

                                    {{-- FOTO --}}
                                    <td class="px-6 py-4">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                 alt="{{ $product->name }}"
                                                 class="w-14 h-14 rounded-2xl object-cover border border-gray-100 dark:border-gray-700">
                                        @else
                                            <div class="w-14 h-14 rounded-2xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </td>

                                    {{-- PRODUK --}}
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900 dark:text-white">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-xs text-gray-400 mt-0.5 max-w-[180px] truncate">
                                            {{ $product->description }}
                                        </div>
                                    </td>

                                    {{-- KATEGORI --}}
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                            {{ $product->category->name ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- SUPPLIER --}}
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        {{ $product->supplier->name ?? '-' }}
                                    </td>

                                    {{-- STOK --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($product->stock <= $product->min_stock)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300">
                                                {{ $product->stock }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300">
                                                {{ $product->stock }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- HARGA BELI --}}
                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white whitespace-nowrap">
                                        Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                                    </td>

                                    {{-- HARGA JUAL --}}
                                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white whitespace-nowrap">
                                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            {{-- DETAIL --}}
                                            <a href="{{ route('products.show', $product->id) }}"
                                               class="inline-flex items-center gap-1.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white px-3 py-2 rounded-xl text-sm font-semibold transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                Detail
                                            </a>

                                            {{-- EDIT — admin & manajer --}}
                                            @if(in_array(auth()->user()->role, ['admin', 'manajer_gudang']))
                                                <a href="{{ route('products.edit', $product->id) }}"
                                                   class="inline-flex items-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white px-3 py-2 rounded-xl text-sm font-semibold transition">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                            @endif

                                            {{-- DELETE — admin only --}}
                                            @if(auth()->user()->role === 'admin')
                                                <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')"
                                                            class="inline-flex items-center gap-1.5 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-xl text-sm font-semibold transition">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-14 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Belum ada produk</h3>
                                            <p class="text-gray-500 dark:text-gray-400 mt-1">Tambahkan produk baru untuk memulai</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- PAGINATION --}}
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $products->appends(request()->query())->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>