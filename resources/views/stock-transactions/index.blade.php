<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Transaksi Stok
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Riwayat barang masuk dan keluar gudang
            </p>

        </div>

    </x-slot>

    <div class="space-y-8">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- ACTION BUTTONS --}}
        <div class="flex flex-wrap gap-3">

            @if(in_array(auth()->user()->role, ['admin', 'manajer_gudang']))
                <a href="{{ route('stock-transactions.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Transaksi
                </a>
            @endif

            <a href="{{ route('stock-transactions.pdf') }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export PDF
            </a>

            <a href="{{ route('stock-transactions.excel') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-green-50 hover:bg-green-100 text-green-600 dark:bg-green-900/20 dark:hover:bg-green-900/40 dark:text-green-400 text-sm font-medium transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>

        </div>

        {{-- ================================================================ --}}
        {{-- TABEL BARANG MASUK (IN) --}}
        {{-- ================================================================ --}}

        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-white">Barang Masuk</h3>
                        <p class="text-xs text-gray-400">Total: {{ $transactionsIn->total() }} transaksi</p>
                    </div>

                </div>

                <span class="px-3 py-1 rounded-full bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-semibold">
                    STOCK IN
                </span>

            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead class="bg-green-50/60 dark:bg-green-900/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Produk</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Qty</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Dicatat Oleh</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Catatan</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                        @forelse($transactionsIn as $transaction)
                            <tr class="hover:bg-green-50/30 dark:hover:bg-green-900/10 transition">

                                <td class="px-6 py-4 text-sm text-gray-400">
                                    {{ $transactionsIn->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-sm text-gray-800 dark:text-white">
                                    {{ $transaction->product->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-green-600 dark:text-green-400">
                                        +{{ $transaction->qty }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $transaction->user->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                    {{ $transaction->note ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($transaction->status === 'confirmed')
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-semibold">
                                            Dikonfirmasi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 text-xs font-semibold">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('stock-transactions.show', $transaction->id) }}"
                                           class="px-3 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white text-xs font-medium transition">
                                            Detail
                                        </a>
                                        @if(auth()->user()->role === 'staff_gudang')
                                            @if($transaction->status !== 'confirmed')
                                                <form action="{{ route('stock-transactions.confirm', $transaction->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="px-3 py-2 rounded-xl bg-green-600 hover:bg-green-700 text-white text-xs font-medium transition">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-green-500 font-medium">✓ Selesai</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-400 text-sm">
                                    Belum ada transaksi barang masuk.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- Pagination IN --}}
            @if($transactionsIn->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $transactionsIn->links() }}
                </div>
            @endif

        </div>

        {{-- ================================================================ --}}
        {{-- TABEL BARANG KELUAR (OUT) --}}
        {{-- ================================================================ --}}

        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

            {{-- Header --}}
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">

                <div class="flex items-center gap-3">

                    <div class="w-9 h-9 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                        </svg>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 dark:text-white">Barang Keluar</h3>
                        <p class="text-xs text-gray-400">Total: {{ $transactionsOut->total() }} transaksi</p>
                    </div>

                </div>

                <span class="px-3 py-1 rounded-full bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 text-xs font-semibold">
                    STOCK OUT
                </span>

            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead class="bg-red-50/60 dark:bg-red-900/10">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Produk</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Qty</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Dicatat Oleh</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Catatan</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Tanggal</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                        @forelse($transactionsOut as $transaction)
                            <tr class="hover:bg-red-50/30 dark:hover:bg-red-900/10 transition">

                                <td class="px-6 py-4 text-sm text-gray-400">
                                    {{ $transactionsOut->firstItem() + $loop->index }}
                                </td>

                                <td class="px-6 py-4 font-semibold text-sm text-gray-800 dark:text-white">
                                    {{ $transaction->product->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <span class="font-bold text-red-600 dark:text-red-400">
                                        -{{ $transaction->qty }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $transaction->user->name ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate">
                                    {{ $transaction->note ?? '-' }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($transaction->status === 'confirmed')
                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 text-xs font-semibold">
                                            Dikonfirmasi
                                        </span>
                                    @else
                                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400 text-xs font-semibold">
                                            Menunggu
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $transaction->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('stock-transactions.show', $transaction->id) }}"
                                           class="px-3 py-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white text-xs font-medium transition">
                                            Detail
                                        </a>
                                        @if(auth()->user()->role === 'staff_gudang')
                                            @if($transaction->status !== 'confirmed')
                                                <form action="{{ route('stock-transactions.confirm', $transaction->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="px-3 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-medium transition">
                                                        Konfirmasi
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-xs text-green-500 font-medium">✓ Selesai</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center text-gray-400 text-sm">
                                    Belum ada transaksi barang keluar.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- Pagination OUT --}}
            @if($transactionsOut->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $transactionsOut->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>