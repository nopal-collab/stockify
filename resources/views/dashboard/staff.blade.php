<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard Staff Gudang</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar tugas yang harus diselesaikan hari ini</p>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- ========================= --}}
        {{-- CARD RINGKASAN TUGAS --}}
        {{-- ========================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <div class="rounded-3xl bg-gradient-to-br from-blue-600 to-blue-800 p-6 shadow-lg text-white">
                <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-blue-100">Barang Masuk Perlu Diperiksa</p>
                <h3 class="text-4xl font-bold mt-2">{{ $incomingToCheck->count() }}</h3>
                <p class="text-xs text-blue-200 mt-1">transaksi masuk pending</p>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-amber-400 to-amber-600 p-6 shadow-lg text-white">
                <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-amber-100">Barang Keluar Perlu Disiapkan</p>
                <h3 class="text-4xl font-bold mt-2">{{ $outgoingToPrepare->count() }}</h3>
                <p class="text-xs text-amber-200 mt-1">transaksi keluar pending</p>
            </div>

            <div class="rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 shadow-lg text-white">
                <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-sm font-medium text-emerald-100">Aktivitas Saya Hari Ini</p>
                <h3 class="text-4xl font-bold mt-2">{{ $todayConfirmedCount }}</h3>
                <p class="text-xs text-emerald-200 mt-1">transaksi diajukan</p>
            </div>

        </div>

        {{-- ========================= --}}
        {{-- BARANG MASUK YANG PERLU DIPERIKSA --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-blue-600 dark:text-blue-400">
                    📥 Barang Masuk yang Perlu Diperiksa
                </h3>
            </div>

            @if($incomingToCheck->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-6 py-4 font-semibold">Produk</th>
                                <th class="px-6 py-4 font-semibold text-center">Qty</th>
                                <th class="px-6 py-4 font-semibold">Dicatat Oleh</th>
                                <th class="px-6 py-4 font-semibold">Note</th>
                                <th class="px-6 py-4 font-semibold text-center">Waktu</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomingToCheck as $t)
                                <tr class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-6 py-4 font-medium">{{ $t->product->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $t->qty }}</td>
                                    <td class="px-6 py-4">{{ $t->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $t->note ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $t->created_at->format('d M H:i') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-amber-100 text-amber-600 px-3 py-1 rounded-full text-xs font-semibold">
                                            MENUNGGU KONFIRMASI
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-2xl p-4 text-sm">
                    Tidak ada barang masuk yang perlu diperiksa ✓
                </div>
            @endif

        </div>

        {{-- ========================= --}}
        {{-- BARANG KELUAR YANG PERLU DISIAPKAN --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

            <div class="mb-6">
                <h3 class="text-xl font-semibold text-amber-500">
                    📤 Barang Keluar yang Perlu Disiapkan
                </h3>
            </div>

            @if($outgoingToPrepare->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-6 py-4 font-semibold">Produk</th>
                                <th class="px-6 py-4 font-semibold text-center">Qty</th>
                                <th class="px-6 py-4 font-semibold">Dicatat Oleh</th>
                                <th class="px-6 py-4 font-semibold">Note</th>
                                <th class="px-6 py-4 font-semibold text-center">Waktu</th>
                                <th class="px-6 py-4 font-semibold text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($outgoingToPrepare as $t)
                                <tr class="border-t border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition">
                                    <td class="px-6 py-4 font-medium">{{ $t->product->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center font-semibold">{{ $t->qty }}</td>
                                    <td class="px-6 py-4">{{ $t->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $t->note ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">{{ $t->created_at->format('d M H:i') }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-amber-100 text-amber-600 px-3 py-1 rounded-full text-xs font-semibold">
                                            MENUNGGU KONFIRMASI
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded-2xl p-4 text-sm">
                    Tidak ada barang keluar yang perlu disiapkan ✓
                </div>
            @endif

        </div>

        {{-- ========================= --}}
        {{-- AKTIVITAS SAYA HARI INI --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">📋 Aktivitas Saya Hari Ini</h3>

            @if(count($myTodayActivities) > 0)
                <div class="space-y-3">
                    @foreach($myTodayActivities as $log)
                        <div class="flex items-center gap-4 p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/40">

                            <div class="w-9 h-9 rounded-full bg-blue-100 dark:bg-blue-900/40 flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>

                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                    {{ $log->activity }}
                                </p>
                                <p class="text-xs text-gray-500 mt-0.5 truncate">{{ $log->description }}</p>
                            </div>

                            <div class="text-right shrink-0">
                                <p class="text-xs text-gray-400">{{ $log->created_at->format('H:i') }}</p>
                            </div>

                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-gray-50 dark:bg-gray-700/30 text-gray-500 rounded-2xl p-4 text-sm">
                    Belum ada aktivitas hari ini — konfirmasi transaksi untuk memulai.
                </div>
            @endif

        </div>

    </div>

</x-app-layout>