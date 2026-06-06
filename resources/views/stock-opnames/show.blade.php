<x-app-layout>

    <x-slot name="header">

        <div class="flex items-start justify-between">

            <div>
                <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                    {{ $opname->title }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Dibuat oleh {{ $opname->creator->name ?? '-' }} · {{ $opname->created_at->format('d M Y, H:i') }}
                </p>
            </div>

            {{-- STATUS BADGE --}}
            @php $color = $opname->status_color; @endphp
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                bg-{{ $color }}-100 text-{{ $color }}-700 dark:bg-{{ $color }}-900/30 dark:text-{{ $color }}-400">
                {{ $opname->status_label }}
            </span>

        </div>

    </x-slot>

    <div class="space-y-6">

        {{-- ALERT --}}
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- INFO CARD --}}
        @if($opname->notes)
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-2xl p-4 text-sm text-blue-700 dark:text-blue-300">
                <span class="font-semibold">Catatan:</span> {{ $opname->notes }}
            </div>
        @endif

        {{-- SUMMARY (hanya jika completed) --}}
        @if($opname->status === 'completed')
            @php
                $totalItems    = $opname->items->count();
                $itemsMatch    = $opname->items->filter(fn($i) => $i->difference === 0)->count();
                $itemsPlus     = $opname->items->filter(fn($i) => $i->difference > 0)->count();
                $itemsMinus    = $opname->items->filter(fn($i) => $i->difference < 0)->count();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center">
                    <div class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalItems }}</div>
                    <div class="text-xs text-gray-500 mt-1">Total Produk</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $itemsMatch }}</div>
                    <div class="text-xs text-gray-500 mt-1">Stok Sesuai</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $itemsPlus }}</div>
                    <div class="text-xs text-gray-500 mt-1">Stok Lebih</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $itemsMinus }}</div>
                    <div class="text-xs text-gray-500 mt-1">Stok Kurang</div>
                </div>
            </div>
        @endif

        {{-- TABEL ITEMS --}}
        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">

            @if($opname->status === 'in_progress')

                {{-- ============================================================ --}}
                {{-- FORM INPUT STOK FISIK (hanya saat in_progress) --}}
                {{-- ============================================================ --}}

                <form action="{{ route('stock-opnames.update-items', $opname->id) }}" method="POST">

                    @csrf
                    @method('PATCH')

                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                            Input Stok Fisik
                        </h3>
                        <div class="flex gap-3">
                            <button type="submit"
                                    class="px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                                Simpan Draft
                            </button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">Produk</th>
                                    <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">Kategori</th>
                                    <th class="px-5 py-4 text-right text-xs font-semibold uppercase text-gray-500">Stok Sistem</th>
                                    <th class="px-5 py-4 text-right text-xs font-semibold uppercase text-gray-500">Stok Fisik <span class="text-red-500">*</span></th>
                                    <th class="px-5 py-4 text-right text-xs font-semibold uppercase text-gray-500">Selisih</th>
                                    <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                                @foreach($opname->items as $item)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition" id="row-{{ $item->id }}">

                                        <td class="px-5 py-4">
                                            <div class="font-medium text-gray-800 dark:text-white text-sm">{{ $item->product->name }}</div>
                                        </td>

                                        <td class="px-5 py-4 text-sm text-gray-500">
                                            {{ $item->product->category->name ?? '-' }}
                                        </td>

                                        <td class="px-5 py-4 text-right font-semibold text-sm text-gray-800 dark:text-white">
                                            {{ $item->system_stock }}
                                        </td>

                                        <td class="px-5 py-4 text-right">
                                            <input type="number"
                                                   name="items[{{ $item->id }}][physical_stock]"
                                                   value="{{ old('items.' . $item->id . '.physical_stock', $item->physical_stock) }}"
                                                   min="0"
                                                   required
                                                   data-item-id="{{ $item->id }}"
                                                   data-system-stock="{{ $item->system_stock }}"
                                                   oninput="calcDiff(this)"
                                                   class="opname-input w-24 text-right rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                        </td>

                                        <td class="px-5 py-4 text-right">
                                            <span id="diff-{{ $item->id }}" class="font-semibold text-sm
                                                {{ $item->difference === null ? 'text-gray-400' : ($item->difference > 0 ? 'text-blue-600' : ($item->difference < 0 ? 'text-red-600' : 'text-green-600')) }}">
                                                {{ $item->difference !== null ? ($item->difference > 0 ? '+' : '') . $item->difference : '-' }}
                                            </span>
                                        </td>

                                        <td class="px-5 py-4">
                                            <input type="text"
                                                   name="items[{{ $item->id }}][notes]"
                                                   value="{{ old('items.' . $item->id . '.notes', $item->notes) }}"
                                                   placeholder="Catatan..."
                                                   class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                    {{-- TOMBOL SELESAIKAN --}}
                    @if(in_array(auth()->user()->role, ['admin', 'manajer_gudang']))
                        <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 flex items-center gap-4">

                            <form action="{{ route('stock-opnames.complete', $opname->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin selesaikan opname? Stok semua produk akan disesuaikan dengan stok fisik.')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                        class="px-6 py-3 rounded-2xl bg-green-600 hover:bg-green-700 text-white font-medium transition">
                                    Selesaikan & Sesuaikan Stok
                                </button>
                            </form>

                            <a href="{{ route('stock-opnames.index') }}"
                               class="px-6 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium transition">
                                Kembali
                            </a>

                        </div>
                    @endif

                </form>

            @else

                {{-- ============================================================ --}}
                {{-- VIEW ONLY (completed) --}}
                {{-- ============================================================ --}}

                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                        Hasil Opname
                    </h3>
                    <a href="{{ route('stock-opnames.index') }}"
                       class="px-4 py-2 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 text-sm transition">
                        Kembali
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">Produk</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">Kategori</th>
                                <th class="px-5 py-4 text-right text-xs font-semibold uppercase text-gray-500">Stok Sistem</th>
                                <th class="px-5 py-4 text-right text-xs font-semibold uppercase text-gray-500">Stok Fisik</th>
                                <th class="px-5 py-4 text-right text-xs font-semibold uppercase text-gray-500">Selisih</th>
                                <th class="px-5 py-4 text-left text-xs font-semibold uppercase text-gray-500">Catatan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                            @foreach($opname->items as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">

                                    <td class="px-5 py-4 font-medium text-gray-800 dark:text-white text-sm">
                                        {{ $item->product->name }}
                                    </td>

                                    <td class="px-5 py-4 text-sm text-gray-500">
                                        {{ $item->product->category->name ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-right text-sm text-gray-800 dark:text-white">
                                        {{ $item->system_stock }}
                                    </td>

                                    <td class="px-5 py-4 text-right font-semibold text-sm text-gray-800 dark:text-white">
                                        {{ $item->physical_stock ?? '-' }}
                                    </td>

                                    <td class="px-5 py-4 text-right">
                                        @if($item->difference !== null)
                                            <span class="font-semibold text-sm
                                                {{ $item->difference > 0 ? 'text-blue-600' : ($item->difference < 0 ? 'text-red-600' : 'text-green-600') }}">
                                                {{ $item->difference > 0 ? '+' : '' }}{{ $item->difference }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 text-sm text-gray-500">
                                        {{ $item->notes ?? '-' }}
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            @endif

        </div>

    </div>

    <script>
        // Hitung selisih real-time saat user mengisi stok fisik
        function calcDiff(itemId, systemStock, physicalValue) {
            const itemId      = input.dataset.itemId;
            const systemStock = input.dataset.systemStock;
            const el          = document.getElementById('diff-' + itemId);

            if (input.value === '') {
                el.textContent = '-';
                el.className   = 'font-semibold text-sm text-gray-400';
                return;
            }

            const diff = parseInt(input.value) - parseInt(systemStock);
            el.textContent = (diff > 0 ? '+' : '') + diff;
            el.className   = 'font-semibold text-sm ' + (
                diff > 0 ? 'text-blue-600' :
                diff < 0 ? 'text-red-600'  :
                            'text-green-600'
            );
        }
    </script>

</x-app-layout>