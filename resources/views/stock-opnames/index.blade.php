<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Stock Opname
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kelola sesi stock opname & penyesuaian stok fisik
            </p>

        </div>

    </x-slot>

    <div class="space-y-6">

        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- ACTION ROW --}}
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">

                {{-- TOMBOL BUAT (admin & manajer) --}}
                @if(in_array(auth()->user()->role, ['admin', 'manajer_gudang']))
                    <a href="{{ route('stock-opnames.create') }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Opname Baru
                    </a>
                @endif

                {{-- FILTER FORM --}}
                <form method="GET" action="{{ route('stock-opnames.index') }}"
                      class="flex flex-wrap gap-3">

                    <input type="text"
                           name="search"
                           value="{{ $filters['search'] ?? '' }}"
                           placeholder="Cari judul opname..."
                           class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                    <select name="status"
                            class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="in_progress" {{ ($filters['status'] ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed"   {{ ($filters['status'] ?? '') === 'completed'   ? 'selected' : '' }}>Completed</option>
                    </select>

                    <button type="submit"
                            class="px-4 py-2 rounded-2xl bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm hover:bg-gray-200 transition">
                        Filter
                    </button>

                </form>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full">

                    <thead class="bg-gray-50 dark:bg-gray-700/50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Judul</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Dibuat Oleh</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Selesai Pada</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                        @forelse($opnames as $opname)

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">

                                <td class="px-6 py-4 text-sm text-gray-500">{{ $opname->id }}</td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-800 dark:text-white">{{ $opname->title }}</div>
                                    @if($opname->notes)
                                        <div class="text-xs text-gray-400 mt-0.5 truncate max-w-xs">{{ $opname->notes }}</div>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @php
                                        $color = $opname->status_color;
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        bg-{{ $color }}-100 text-{{ $color }}-700 dark:bg-{{ $color }}-900/30 dark:text-{{ $color }}-400">
                                        {{ $opname->status_label }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    {{ $opname->creator->name ?? '-' }}
                                    <div class="text-xs text-gray-400">{{ $opname->created_at->format('d M Y, H:i') }}</div>
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                                    @if($opname->completed_at)
                                        {{ $opname->completed_at->format('d M Y, H:i') }}
                                        <div class="text-xs text-gray-400">oleh {{ $opname->completer->name ?? '-' }}</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">

                                        {{-- LIHAT DETAIL --}}
                                        <a href="{{ route('stock-opnames.show', $opname->id) }}"
                                           class="px-3 py-1.5 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium transition">
                                            Detail
                                        </a>

                                        {{-- HAPUS (hanya jika belum completed) --}}
                                        @if($opname->status !== 'completed' && in_array(auth()->user()->role, ['admin', 'manajer_gudang']))
                                            <form method="POST" action="{{ route('stock-opnames.destroy', $opname->id) }}"
                                                  onsubmit="return confirm('Yakin hapus sesi opname ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-3 py-1.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                                    Belum ada sesi stock opname.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-6">
                {{ $opnames->withQueryString()->links() }}
            </div>

        </div>

    </div>

</x-app-layout>