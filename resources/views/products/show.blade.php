<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Detail Produk
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Informasi lengkap produk
            </p>

        </div>

    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

            {{-- HERO: GAMBAR + NAMA --}}
            <div class="flex flex-col md:flex-row gap-6 p-8">

                {{-- GAMBAR --}}
                <div class="flex-shrink-0">

                    @if($product->image)

                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-48 h-48 rounded-3xl object-cover border border-gray-200 dark:border-gray-700">

                    @else

                        <div class="w-48 h-48 rounded-3xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>

                    @endif

                </div>

                {{-- NAMA + BADGE --}}
                <div class="flex-1">

                    <div class="flex flex-wrap items-start gap-3 mb-3">

                        <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                            {{ $product->name }}
                        </h3>

                        {{-- Badge stok --}}
                        @if($product->is_low_stock)

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                ⚠ Stok Menipis
                            </span>

                        @else

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                ✓ Stok Aman
                            </span>

                        @endif

                    </div>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                        {{ $product->category?->name ?? '-' }}
                        @if($product->supplier)
                            · {{ $product->supplier->name }}
                        @endif
                    </p>

                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed">
                        {{ $product->description }}
                    </p>

                </div>

            </div>

            {{-- DIVIDER --}}
            <div class="border-t border-gray-100 dark:border-gray-700"></div>

            {{-- INFO GRID --}}
            <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-gray-100 dark:divide-gray-700">

                <div class="p-6">
                    <p class="text-xs text-gray-400 mb-1">Stok Saat Ini</p>
                    <p class="text-2xl font-bold {{ $product->is_low_stock ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-white' }}">
                        {{ number_format($product->stock) }}
                    </p>
                </div>

                <div class="p-6">
                    <p class="text-xs text-gray-400 mb-1">Stok Minimum</p>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">
                        {{ number_format($product->min_stock) }}
                    </p>
                </div>

                <div class="p-6">
                    <p class="text-xs text-gray-400 mb-1">Harga Beli</p>
                    <p class="text-lg font-semibold text-gray-800 dark:text-white">
                        Rp {{ number_format($product->harga_beli, 0, ',', '.') }}
                    </p>
                </div>

                <div class="p-6">
                    <p class="text-xs text-gray-400 mb-1">Harga Jual</p>
                    <p class="text-lg font-semibold text-green-600 dark:text-green-400">
                        Rp {{ number_format($product->harga_jual, 0, ',', '.') }}
                    </p>
                </div>

            </div>

            {{-- DIVIDER --}}
            <div class="border-t border-gray-100 dark:border-gray-700"></div>

            {{-- ATRIBUT PRODUK --}}
            @if($product->attributeValues->isNotEmpty())

                <div class="p-8">

                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                        Atribut Produk
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                        @foreach($product->attributeValues as $attrValue)

                            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">

                                <div class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 font-medium">
                                        {{ $attrValue->attribute->name }}
                                    </p>

                                    @if($attrValue->attribute->type === 'color')
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="w-5 h-5 rounded-full border border-gray-300"
                                                 @style(['background-color: ' . $attrValue->value])>
                                            </div>
                                            <span class="text-sm font-semibold text-gray-800 dark:text-white">
                                                {{ $attrValue->value }}
                                            </span>
                                        </div>
                                    @else
                                        <p class="text-sm font-semibold text-gray-800 dark:text-white mt-0.5">
                                            {{ $attrValue->value }}
                                        </p>
                                    @endif
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>

                {{-- DIVIDER --}}
                <div class="border-t border-gray-100 dark:border-gray-700"></div>

            @endif

            {{-- RIWAYAT TRANSAKSI TERAKHIR --}}
            <div class="p-8">

                <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">
                    Riwayat Transaksi Terakhir
                </h4>

                @php
                    $transactions = $product->stockTransactions()->latest()->take(5)->get();
                @endphp

                @if($transactions->isEmpty())

                    <p class="text-sm text-gray-400">Belum ada transaksi untuk produk ini.</p>

                @else

                    <div class="space-y-2">

                        @foreach($transactions as $trx)

                            <div class="flex items-center justify-between py-2 border-b border-gray-50 dark:border-gray-700 last:border-0">

                                <div class="flex items-center gap-3">

                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium
                                        {{ $trx->type === 'in'
                                            ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400'
                                            : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">

                                        {{ $trx->type === 'in' ? '+ Masuk' : '- Keluar' }}

                                    </span>

                                    <span class="text-sm text-gray-700 dark:text-gray-300">
                                        {{ $trx->qty }} unit
                                    </span>

                                    @if($trx->note)
                                        <span class="text-xs text-gray-400">— {{ $trx->note }}</span>
                                    @endif

                                </div>

                                <span class="text-xs text-gray-400">
                                    {{ $trx->created_at->format('d M Y, H:i') }}
                                </span>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>


            <div class="px-8 pb-8">
                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white text-sm font-semibold transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar Produk
                </a>
            </div>

        </div>

    </div>

</x-app-layout>