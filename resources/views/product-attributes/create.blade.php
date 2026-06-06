<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Tambah Atribut Produk
            </h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Definisikan atribut baru seperti ukuran, warna, atau berat
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

                        <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                            <svg class="w-7 h-7 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Form Atribut Produk</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Isi informasi atribut dengan lengkap</p>
                        </div>

                    </div>

                </div>

                {{-- FORM --}}
                <form action="{{ route('product-attributes.store') }}"
                      method="POST"
                      class="p-8 space-y-6">

                    @csrf

                    {{-- NAMA ATRIBUT --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Nama Atribut <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Contoh: Ukuran, Warna, Berat..."
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
                            <option value="text"   {{ old('type') === 'text'   ? 'selected' : '' }}>Teks — nilai bebas (contoh: "Merah", "XL")</option>
                            <option value="number" {{ old('type') === 'number' ? 'selected' : '' }}>Angka — nilai numerik (contoh: "1.5", "500")</option>
                            <option value="color"  {{ old('type') === 'color'  ? 'selected' : '' }}>Warna — input color picker</option>
                            <option value="select" {{ old('type') === 'select' ? 'selected' : '' }}>Pilihan — pilih dari daftar opsi</option>
                        </select>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Tipe menentukan bagaimana nilai atribut ini diisi pada setiap produk.
                        </p>
                    </div>

                    {{-- OPSI (muncul hanya jika tipe = select) --}}
                    <div id="options-field" class="{{ old('type') === 'select' ? '' : 'hidden' }}">

                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Daftar Pilihan <span class="text-red-500">*</span>
                        </label>

                        <textarea name="options"
                                  rows="5"
                                  placeholder="Tulis satu pilihan per baris. Contoh:&#10;S&#10;M&#10;L&#10;XL&#10;XXL"
                                  class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition resize-none font-mono text-sm">{{ old('options') }}</textarea>

                        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                            Tulis satu opsi per baris. Opsi ini akan muncul sebagai dropdown saat mengisi nilai atribut pada produk.
                        </p>

                    </div>

                    {{-- DESKRIPSI --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                        </label>
                        <input type="text"
                               name="description"
                               value="{{ old('description') }}"
                               placeholder="Contoh: Ukuran pakaian dalam satuan internasional"
                               class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">

                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-2xl transition duration-300 shadow-lg shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Atribut
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

    {{-- SCRIPT: toggle field opsi berdasarkan tipe --}}
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
        toggleOptions(); // jalankan saat halaman pertama dimuat
    </script>

</x-app-layout>