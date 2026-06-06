<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Tambah Produk
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Tambahkan produk baru ke inventaris
            </p>

        </div>

    </x-slot>

    <div class="max-w-4xl mx-auto">

        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-8">

            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-6 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 p-4">

                    <ul class="space-y-1 text-sm">

                        @foreach ($errors->all() as $error)

                            <li>• {{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('products.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">

                @csrf

                {{-- GRID: KATEGORI & SUPPLIER --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- CATEGORY --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Kategori <span class="text-red-500">*</span>
                        </label>

                        <select
                            name="category_id"
                            required
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            <option value="">Pilih Kategori</option>

                            @foreach($categories as $category)

                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                    {{ $category->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- SUPPLIER --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Supplier
                        </label>

                        <select
                            name="supplier_id"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                            <option value="">Pilih Supplier (opsional)</option>

                            @foreach($suppliers as $supplier)

                                <option value="{{ $supplier->id }}"
                                    {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>

                                    {{ $supplier->name }}

                                </option>

                            @endforeach

                        </select>

                    </div>

                </div>

                {{-- NAMA PRODUK --}}
                <div>

                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        placeholder="Masukkan nama produk"
                        class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                </div>

                {{-- GRID: STOK & STOK MINIMUM --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- STOK --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Stok Awal <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', 0) }}"
                            required
                            min="0"
                            placeholder="0"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    {{-- STOK MINIMUM --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Stok Minimum <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            name="min_stock"
                            value="{{ old('min_stock', 5) }}"
                            required
                            min="0"
                            placeholder="5"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                        <p class="mt-1 text-xs text-gray-400">
                            Sistem akan memberi peringatan jika stok ≤ angka ini.
                        </p>

                    </div>

                </div>

                {{-- GRID: HARGA BELI & HARGA JUAL --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- HARGA BELI --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Harga Beli (Rp) <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            name="harga_beli"
                            value="{{ old('harga_beli', 0) }}"
                            required
                            min="0"
                            placeholder="0"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                    {{-- HARGA JUAL --}}
                    <div>

                        <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                            Harga Jual (Rp) <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="number"
                            name="harga_jual"
                            value="{{ old('harga_jual', 0) }}"
                            required
                            min="0"
                            placeholder="0"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                    </div>

                </div>

                {{-- DESKRIPSI --}}
                <div>

                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        required
                        placeholder="Tulis deskripsi produk..."
                        class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>

                </div>

                {{-- GAMBAR --}}
                <div>

                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Foto Produk
                    </label>

                    <input
                        type="file"
                        name="image"
                        accept="image/jpg,image/jpeg,image/png"
                        class="w-full rounded-2xl border border-dashed border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-4">

                    <p class="mt-1 text-xs text-gray-400">Format: JPG, JPEG, PNG. Maks 2MB.</p>

                </div>

                {{-- ============================================================ --}}
                {{-- ATRIBUT PRODUK --}}
                {{-- Field: attributes[{id}] — nilai dikirim sebagai array asosiatif --}}
                {{-- Service akan membaca $data['attributes'] dan memanggil         --}}
                {{-- syncAttributeValues($product->id, $attributeValues)            --}}
                {{-- ============================================================ --}}
                @if($attributes->isNotEmpty())

                    <div class="border-t border-gray-100 dark:border-gray-700 pt-6">

                        <h3 class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-4">
                            Atribut Produk
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            @foreach($attributes as $attribute)

                                <div>

                                    <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        {{ $attribute->name }}
                                        @if($attribute->description)
                                            <span class="text-xs text-gray-400 font-normal ml-1">({{ $attribute->description }})</span>
                                        @endif
                                    </label>

                                    {{-- TYPE: select — tampilkan dropdown dari $attribute->options --}}
                                    @if($attribute->type === 'select' && is_array($attribute->options) && count($attribute->options))

                                        <select
                                            name="attributes[{{ $attribute->id }}]"
                                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                            <option value="">— Pilih {{ $attribute->name }} —</option>

                                            @foreach($attribute->options as $option)

                                                <option value="{{ $option }}"
                                                    {{ old('attributes.' . $attribute->id) === $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>

                                            @endforeach

                                        </select>

                                    {{-- TYPE: color — tampilkan color picker --}}
                                    @elseif($attribute->type === 'color')

                                        <div class="flex items-center gap-3">

                                            <input
                                                type="color"
                                                name="attributes[{{ $attribute->id }}]"
                                                value="{{ old('attributes.' . $attribute->id, '#000000') }}"
                                                class="h-11 w-16 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 cursor-pointer p-1">

                                            <span class="text-xs text-gray-400">Pilih warna untuk produk ini</span>

                                        </div>

                                    {{-- TYPE: number — input angka --}}
                                    @elseif($attribute->type === 'number')

                                        <input
                                            type="number"
                                            name="attributes[{{ $attribute->id }}]"
                                            value="{{ old('attributes.' . $attribute->id) }}"
                                            placeholder="Masukkan nilai {{ $attribute->name }}"
                                            step="any"
                                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    {{-- TYPE: text (default) --}}
                                    @else

                                        <input
                                            type="text"
                                            name="attributes[{{ $attribute->id }}]"
                                            value="{{ old('attributes.' . $attribute->id) }}"
                                            placeholder="Masukkan {{ $attribute->name }}"
                                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                    @endif

                                </div>

                            @endforeach

                        </div>

                        <p class="mt-3 text-xs text-gray-400">
                            Atribut bersifat opsional. Kosongkan jika tidak berlaku untuk produk ini.
                        </p>

                    </div>

                @endif
                {{-- END ATRIBUT PRODUK --}}

                {{-- TOMBOL --}}
                <div class="flex flex-wrap items-center gap-3 pt-4">

                    <button
                        type="submit"
                        class="inline-flex items-center px-6 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">
                        Simpan Produk
                    </button>

                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center px-6 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-medium transition">
                        Kembali
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>