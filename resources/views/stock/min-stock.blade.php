<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Pengaturan Stok Minimum
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Atur batas stok minimum per produk — sistem akan memberi peringatan jika stok di bawah batas ini
            </p>

        </div>

    </x-slot>

    <div class="space-y-6">

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- INFO BANNER --}}
        <div class="flex items-start gap-3 p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 text-sm text-blue-700 dark:text-blue-300">
            <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z"/>
            </svg>
            <span>
                Produk dengan stok <strong>di bawah atau sama dengan</strong> stok minimum akan ditampilkan sebagai peringatan
                di dashboard Manajer Gudang dan Admin. Atur nilai <strong>0</strong> untuk menonaktifkan peringatan pada produk tertentu.
            </span>
        </div>

        {{-- FORM --}}
        <form action="{{ route('stock.min-stock.update') }}" method="POST">

            @csrf
            @method('PATCH')

            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">

                {{-- HEADER TABLE --}}
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">

                    <div class="flex items-center gap-3">

                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Total: {{ $products->count() }} produk
                        </span>

                        {{-- BADGE stok menipis --}}
                        @php
                            $lowCount = $products->filter(fn($p) => $p->stock <= $p->min_stock)->count();
                        @endphp

                        @if($lowCount > 0)
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse inline-block"></span>
                                {{ $lowCount }} produk stok menipis
                            </span>
                        @endif

                    </div>

                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Perubahan
                    </button>

                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">
                    <table class="w-full">

                        <thead class="bg-gray-50 dark:bg-gray-700/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Produk</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">Kategori</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Stok Saat Ini</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Stok Minimum</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                            @forelse($products as $index => $product)

                                @php
                                    $isLow = $product->stock <= $product->min_stock;
                                @endphp

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition
                                           {{ $isLow ? 'bg-red-50/40 dark:bg-red-900/10' : '' }}">

                                    {{-- NO --}}
                                    <td class="px-6 py-4 text-sm text-gray-400">
                                        {{ $index + 1 }}
                                    </td>

                                    {{-- NAMA PRODUK --}}
                                    <td class="px-6 py-4">
                                        <span class="font-medium text-gray-800 dark:text-white text-sm">
                                            {{ $product->name }}
                                        </span>
                                    </td>

                                    {{-- KATEGORI --}}
                                    <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                        {{ $product->category->name ?? '-' }}
                                    </td>

                                    {{-- STOK SAAT INI --}}
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-bold text-sm {{ $isLow ? 'text-red-600 dark:text-red-400' : 'text-gray-800 dark:text-white' }}">
                                            {{ $product->stock }}
                                        </span>
                                    </td>

                                    {{-- INPUT STOK MINIMUM --}}
                                    <td class="px-6 py-4 text-right">
                                        <input type="number"
                                               name="min_stocks[{{ $product->id }}]"
                                               value="{{ old('min_stocks.' . $product->id, $product->min_stock) }}"
                                               min="0"
                                               required
                                               class="w-24 text-right rounded-xl border
                                                      {{ $isLow
                                                          ? 'border-red-300 dark:border-red-700 focus:ring-red-500'
                                                          : 'border-gray-200 dark:border-gray-700 focus:ring-blue-500' }}
                                                      bg-white dark:bg-gray-900 dark:text-white
                                                      px-3 py-2 text-sm focus:ring-2 transition">
                                    </td>

                                    {{-- STATUS BADGE --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($isLow)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse inline-block"></span>
                                                Menipis
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                                                Aman
                                            </span>
                                        @endif
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center text-gray-400">
                                        Belum ada produk yang terdaftar.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

                {{-- FOOTER BUTTON --}}
                @if($products->count() > 0)
                    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Semua Perubahan
                        </button>
                    </div>
                @endif

            </div>

        </form>

    </div>

</x-app-layout>