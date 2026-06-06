<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Edit Atribut Produk
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Perbarui definisi atribut: <span class="font-semibold text-gray-700 dark:text-gray-200">{{ $productAttribute->name }}</span>
            </p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ERROR ALERT --}}
            @if ($errors->any())

                <div class="mb-6 rounded-2xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-5">

                    <div class="flex items-start gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-800">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                            </svg>
                        </div>

                        <div>
                            <h4 class="font-semibold text-red-700 dark:text-red-300">Terjadi Kesalahan</h4>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                </div>

            @endif

            {{-- FORM CARD --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="border-b border-gray-200 dark:border-gray-700 px-8 py-6">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl bg-amber-100 dark:bg-amber-900 flex items-center justify-center">
                            <svg class="w-7 h-7 text-amber-600 dark:text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Edit Atribut</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Perbarui informasi atribut produk</p>
                        </div>

                    </div>

                </div>

                {{-- FORM --}}
                <form action="{{ route('product-attributes.update', $productAttribute->id) }}"
                      method="POST"
                      class="p-8 space-y-6">

                    @csrf
                    @method('PUT')

                    {{-- NAMA ATRIBUT --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Nama Atribut <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $productAttribute->name) }}"
                               required
                               class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                    </div>

                    {{-- TIPE --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Tipe Atribut <span class="text-red-500">*</span>
                        </label>

                        <select name="type"
                                id="type-select"
                                required
                                class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                            <option value="text"   {{ old('type', $productAttribute->type) === 'text'   ? 'selected' : '' }}>Teks — nilai bebas</option>
                            <option value="number" {{ old('type', $productAttribute->type) === 'number' ? 'selected' : '' }}>Angka — nilai numerik</option>
                            <option value="color"  {{ old('type', $productAttribute->type) === 'color'  ? 'selected' : '' }}>Warna — color picker</option>
                            <option value="select" {{ old('type', $productAttribute->type) === 'select' ? 'selected' : '' }}>Pilihan — pilih dari daftar opsi</option>
                        </select>

                        @if($productAttribute->attributeValues()->exists())
                            <p class="mt-2 text-xs text-amber-600 dark:text-amber-400">
                                ⚠ Atribut ini sudah digunakan oleh beberapa produk. Mengubah tipe dapat mempengaruhi tampilan nilai yang sudah ada.
                            </p>
                        @endif
                    </div>

                    {{-- OPSI --}}
                    <div id="options-field" class="{{ old('type', $productAttribute->type) === 'select' ? '' : 'hidden' }}">

                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Daftar Pilihan <span class="text-red-500">*</span>
                        </label>

                        <textarea name="options"
                                  rows="5"
                                  placeholder="Tulis satu pilihan per baris."
                                  class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition resize-none font-mono text-sm">{{ old('options', is_array($productAttribute->options) ? implode("\n", $productAttribute->options) : '') }}</textarea>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Tulis satu opsi per baris.
                        </p>

                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <input type="text"
                               name="description"
                               value="{{ old('description', $productAttribute->description) }}"
                               class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-6 py-3 rounded-2xl transition duration-300 shadow-lg shadow-amber-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Atribut
                        </button>

                        <a href="{{ route('product-attributes.index') }}"
                           class="inline-flex items-center justify-center gap-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-semibold px-6 py-3 rounded-2xl transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Kembali
                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <script>
        const typeSelect   = document.getElementById('type-select');
        const optionsField = document.getElementById('options-field');

        function toggleOptions() {
            if (typeSelect.value === 'select') {
                optionsField.classList.remove('hidden');
            } else {
                optionsField.classList.add('hidden');
            }
        }

        typeSelect.addEventListener('change', toggleOptions);
    </script>

</x-app-layout>