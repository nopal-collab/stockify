<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Buat Stock Opname
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Pilih produk yang akan dihitung stok fisiknya
            </p>

        </div>

    </x-slot>

    <div class="max-w-5xl mx-auto">

        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-8">

            {{-- ERROR --}}
            @if($errors->any())
                <div class="mb-6 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 p-4 text-sm">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('stock-opnames.store') }}" method="POST" class="space-y-8">

                @csrf

                {{-- INFO SESI --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- JUDUL --}}
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Judul Opname <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Contoh: Opname Bulanan Juni 2026"
                               required
                               class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    {{-- CATATAN --}}
                    <div class="md:col-span-2">
                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Catatan
                        </label>
                        <textarea name="notes"
                                  rows="2"
                                  placeholder="Catatan tambahan (opsional)"
                                  class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                    </div>

                </div>

                {{-- PILIH PRODUK --}}
                <div>

                    <div class="flex items-center justify-between mb-4">

                        <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                            Pilih Produk yang Akan Diopname
                            <span class="text-red-500">*</span>
                        </h3>

                        <div class="flex gap-2">
                            <button type="button" onclick="selectAll()"
                                    class="text-xs px-3 py-1.5 rounded-xl bg-blue-50 text-blue-600 hover:bg-blue-100 transition">
                                Pilih Semua
                            </button>
                            <button type="button" onclick="deselectAll()"
                                    class="text-xs px-3 py-1.5 rounded-xl bg-gray-100 text-gray-600 hover:bg-gray-200 transition">
                                Batal Semua
                            </button>
                        </div>

                    </div>

                    {{-- SEARCH PRODUK --}}
                    <input type="text"
                           id="productSearch"
                           placeholder="Cari nama produk..."
                           oninput="filterProducts(this.value)"
                           class="w-full mb-4 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500">

                    <div class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden">
                        <table class="w-full" id="productTable">
                            <thead class="bg-gray-50 dark:bg-gray-700/50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500 w-10"></th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Produk</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-gray-500">Kategori</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase text-gray-500">Stok Sistem</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                                @forelse($products as $product)
                                    <tr class="product-row hover:bg-gray-50 dark:hover:bg-gray-700/30 transition"
                                        data-name="{{ strtolower($product->name) }}">

                                        <td class="px-5 py-3">
                                            <input type="checkbox"
                                                   name="product_ids[]"
                                                   value="{{ $product->id }}"
                                                   {{ in_array($product->id, old('product_ids', [])) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 rounded focus:ring-blue-500">
                                        </td>

                                        <td class="px-5 py-3">
                                            <div class="font-medium text-gray-800 dark:text-white text-sm">{{ $product->name }}</div>
                                        </td>

                                        <td class="px-5 py-3 text-sm text-gray-500">
                                            {{ $product->category->name ?? '-' }}
                                        </td>

                                        <td class="px-5 py-3 text-right">
                                            <span class="font-semibold text-sm
                                                {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-800 dark:text-white' }}">
                                                {{ $product->stock }}
                                            </span>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-5 py-10 text-center text-gray-400 text-sm">
                                            Belum ada produk terdaftar.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                </div>

                {{-- BUTTONS --}}
                <div class="flex gap-4 pt-2">

                    <button type="submit"
                            class="px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                        Mulai Opname
                    </button>

                    <a href="{{ route('stock-opnames.index') }}"
                       class="px-6 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-medium transition">
                        Batal
                    </a>

                </div>

            </form>

        </div>

    </div>

    <script>
        function selectAll() {
            document.querySelectorAll('#productTable input[type="checkbox"]').forEach(cb => cb.checked = true);
        }

        function deselectAll() {
            document.querySelectorAll('#productTable input[type="checkbox"]').forEach(cb => cb.checked = false);
        }

        function filterProducts(query) {
            const q = query.toLowerCase();
            document.querySelectorAll('.product-row').forEach(row => {
                row.style.display = row.dataset.name.includes(q) ? '' : 'none';
            });
        }
    </script>

</x-app-layout>