<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Dashboard Admin</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ringkasan lengkap seluruh aktivitas Stockify</p>
        </div>
    </x-slot>

    <div class="space-y-8">

        {{-- ========================= --}}
        {{-- FILTER PERIODE --}}
        {{-- ========================= --}}
        <div class="flex gap-2 flex-wrap">

            @foreach(['daily' => 'Hari Ini', 'weekly' => 'Minggu Ini', 'monthly' => 'Bulan Ini', 'yearly' => 'Tahun Ini'] as $key => $label)

                <a href="{{ route('dashboard', ['period' => $key]) }}"
                   class="px-5 py-2 rounded-2xl text-sm font-medium transition
                          {{ $period === $key
                              ? 'bg-blue-600 text-white shadow'
                              : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }}">
                    {{ $label }}
                </a>

            @endforeach

        </div>

        {{-- ========================= --}}
        {{-- CARD STATISTIK --}}
        {{-- ========================= --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

            {{-- JUMLAH PRODUK --}}
            <div class="rounded-3xl bg-gradient-to-br from-blue-600 to-blue-800 p-6 shadow-lg text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-blue-100">Jumlah Produk</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalProducts }}</h3>
                <p class="text-xs text-blue-200 mt-1">{{ $totalCategories }} kategori terdaftar</p>
            </div>

            {{-- TRANSAKSI MASUK (periode) --}}
            <div class="rounded-3xl bg-gradient-to-br from-emerald-500 to-emerald-700 p-6 shadow-lg text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-emerald-100">Transaksi Masuk</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalIn }}</h3>
                <p class="text-xs text-emerald-200 mt-1">
                    @switch($period)
                        @case('daily') Hari ini @break
                        @case('weekly') Minggu ini @break
                        @case('monthly') Bulan ini @break
                        @case('yearly') Tahun ini @break
                    @endswitch
                </p>
            </div>

            {{-- TRANSAKSI KELUAR (periode) --}}
            <div class="rounded-3xl bg-gradient-to-br from-rose-500 to-rose-700 p-6 shadow-lg text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-rose-100">Transaksi Keluar</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalOut }}</h3>
                <p class="text-xs text-rose-200 mt-1">
                    @switch($period)
                        @case('daily') Hari ini @break
                        @case('weekly') Minggu ini @break
                        @case('monthly') Bulan ini @break
                        @case('yearly') Tahun ini @break
                    @endswitch
                </p>
            </div>

            {{-- TOTAL SUPPLIER --}}
            <div class="rounded-3xl bg-gradient-to-br from-amber-400 to-amber-600 p-6 shadow-lg text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7"/>
                        </svg>
                    </div>
                </div>
                <p class="text-sm font-medium text-amber-100">Jumlah Supplier</p>
                <h3 class="text-4xl font-bold mt-2">{{ $totalSuppliers }}</h3>
                <p class="text-xs text-amber-200 mt-1">supplier terdaftar</p>
            </div>

        </div>

        {{-- ========================= --}}
        {{-- GRAFIK STOK BARANG --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">📊 Grafik Stok Barang</h3>
            <div class="h-72"><canvas id="stockChart"></canvas></div>
        </div>

        {{-- ========================= --}}
        {{-- GRAFIK TRANSAKSI --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">
            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">📈 Grafik Transaksi Per Bulan</h3>
            <div class="h-72"><canvas id="transactionChart"></canvas></div>
        </div>

        {{-- ========================= --}}
        {{-- AKTIVITAS PENGGUNA TERBARU --}}
        {{-- ========================= --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl shadow-sm p-6">

            <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-6">🕐 Aktivitas Pengguna Terbaru</h3>

            @if($recentActivities->count() > 0)

                <div class="space-y-3">
                    @foreach($recentActivities as $log)
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-gray-50 dark:bg-gray-700/40">

                            {{-- AVATAR --}}
                            <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shrink-0">
                                {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}
                            </div>

                            {{-- INFO --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                    {{ $log->user->name ?? 'Unknown' }}
                                    <span class="font-normal text-gray-500 dark:text-gray-400">— {{ $log->activity }}</span>
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">
                                    {{ $log->description }}
                                </p>
                            </div>

                            {{-- WAKTU --}}
                            <p class="text-xs text-gray-400 dark:text-gray-500 shrink-0">
                                {{ $log->created_at->diffForHumans() }}
                            </p>

                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    <a href="{{ route('reports.index', ['tab' => 'activity']) }}"
                       class="text-sm text-blue-600 dark:text-blue-400 hover:underline">
                        Lihat semua aktivitas →
                    </a>
                </div>

            @else
                <div class="bg-gray-50 dark:bg-gray-700/30 text-gray-500 rounded-2xl p-4 text-sm">
                    Belum ada aktivitas tercatat
                </div>
            @endif

        </div>

    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        const isDark    = document.documentElement.classList.contains('dark');
        const textColor = isDark ? '#d1d5db' : '#374151';
        const gridColor = isDark ? '#374151' : '#e5e7eb';

        // Grafik Stok Barang
        new Chart(document.getElementById('stockChart'), {
            type: 'bar',
            data: {
                labels: @json($productNames),
                datasets: [{
                    label: 'Stok Tersedia',
                    data: @json($productStocks),
                    backgroundColor: '#3b82f6',
                    borderRadius: 8,
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: textColor } } },
                scales: {
                    x: { ticks: { color: textColor }, grid: { color: gridColor } },
                    y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } },
                }
            }
        });

        // Grafik Transaksi Per Bulan
        new Chart(document.getElementById('transactionChart'), {
            type: 'line',
            data: {
                labels: @json($chartMonths),
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: @json($chartIn),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16,185,129,0.1)',
                        fill: true, tension: 0.4,
                    },
                    {
                        label: 'Barang Keluar',
                        data: @json($chartOut),
                        borderColor: '#ef4444',
                        backgroundColor: 'rgba(239,68,68,0.1)',
                        fill: true, tension: 0.4,
                    },
                ]
            },
            options: {
                maintainAspectRatio: false,
                plugins: { legend: { labels: { color: textColor } } },
                scales: {
                    x: { ticks: { color: textColor }, grid: { color: gridColor } },
                    y: { beginAtZero: true, ticks: { color: textColor }, grid: { color: gridColor } },
                }
            }
        });

    });
    </script>

</x-app-layout>