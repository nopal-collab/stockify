<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Detail Transaksi</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Informasi lengkap transaksi #{{ $transaction->id }}
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SUCCESS --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 p-4">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <p class="text-sm font-medium text-green-700 dark:text-green-300">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm overflow-hidden">

                {{-- HERO —  tipe + status --}}
                <div class="p-8 flex flex-col sm:flex-row items-start gap-6">

                    {{-- ICON TIPE --}}
                    <div class="flex-shrink-0">
                        @if($transaction->type === 'in')
                            <div class="w-20 h-20 rounded-3xl bg-green-100 dark:bg-green-900/40 flex items-center justify-center">
                                <svg class="w-10 h-10 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                                </svg>
                            </div>
                        @else
                            <div class="w-20 h-20 rounded-3xl bg-red-100 dark:bg-red-900/40 flex items-center justify-center">
                                <svg class="w-10 h-10 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- INFO UTAMA --}}
                    <div class="flex-1">
                        <div class="flex flex-wrap items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                {{ $transaction->type === 'in' ? 'Barang Masuk' : 'Barang Keluar' }}
                                — {{ $transaction->product->name ?? '-' }}
                            </h3>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-4">
                            {{-- STATUS --}}
                            @if($transaction->status === 'confirmed')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    Dikonfirmasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                    Menunggu Konfirmasi
                                </span>
                            @endif

                            {{-- TIPE --}}
                            @if($transaction->type === 'in')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-400">
                                    STOCK IN
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400">
                                    STOCK OUT
                                </span>
                            @endif
                        </div>

                        {{-- TOMBOL KONFIRMASI — staff & pending --}}
                        @if(auth()->user()->role === 'staff_gudang' && $transaction->status === 'pending')
                            <form action="{{ route('stock-transactions.confirm', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-2xl font-semibold transition text-sm shadow-lg shadow-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Konfirmasi Transaksi
                                </button>
                            </form>
                        @endif
                    </div>

                </div>

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                {{-- STAT: QTY --}}
                <div class="grid grid-cols-2 divide-x divide-gray-100 dark:divide-gray-700">
                    <div class="p-6 text-center">
                        <p class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Jumlah</p>
                        <p class="text-3xl font-bold {{ $transaction->type === 'in' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $transaction->type === 'in' ? '+' : '-' }}{{ number_format($transaction->qty) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">unit</p>
                    </div>
                    <div class="p-6 text-center">
                        <p class="text-xs text-gray-400 mb-1 font-medium uppercase tracking-wide">Stok Produk Saat Ini</p>
                        <p class="text-3xl font-bold text-gray-900 dark:text-white">
                            {{ number_format($transaction->product->stock ?? 0) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">unit tersedia</p>
                    </div>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                {{-- DETAIL INFO --}}
                <div class="p-8">
                    <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                        Informasi Transaksi
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Produk</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $transaction->product->name ?? '-' }}
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Kategori</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $transaction->product->category->name ?? '-' }}
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Dicatat Oleh</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $transaction->user->name ?? '-' }}
                                <span class="text-xs text-gray-400 font-normal ml-1">({{ $transaction->user->role ?? '' }})</span>
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Tanggal Dibuat</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $transaction->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 sm:col-span-2">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Catatan</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $transaction->note ?? '—' }}
                            </p>
                        </div>

                    </div>
                </div>

            </div>

                <div class="px-8 pb-8">
                    <a href="{{ route('stock-transactions.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white text-sm font-semibold transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Daftar Transaksi
                    </a>
                </div>

        </div>
    </div>

</x-app-layout>