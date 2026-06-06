<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Atribut Produk
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola definisi atribut produk (ukuran, warna, berat, dll.)
                </p>
            </div>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- SUCCESS ALERT --}}
            @if(session('success'))

                <div class="mb-6 flex items-center gap-3 rounded-2xl border border-green-200 dark:border-green-800 bg-green-50 dark:bg-green-900/30 p-4">

                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 dark:bg-green-800">

                        <svg class="w-5 h-5 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>

                    </div>

                    <div>
                        <h4 class="font-semibold text-green-700 dark:text-green-300">Berhasil</h4>
                        <p class="text-sm text-green-600 dark:text-green-400">{{ session('success') }}</p>
                    </div>

                </div>

            @endif

            {{-- MAIN CARD --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm overflow-hidden">

                {{-- TOP BAR --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                        {{-- BUTTON TAMBAH --}}
                        <a href="{{ route('product-attributes.create') }}"
                           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold transition duration-300 shadow-lg shadow-blue-500/20">

                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>

                            Tambah Atribut

                        </a>

                        {{-- FILTER FORM --}}
                        <form action="{{ route('product-attributes.index') }}"
                              method="GET"
                              class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                            {{-- SEARCH --}}
                            <div class="relative">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>

                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Cari atribut..."
                                       class="w-full sm:w-64 pl-12 pr-4 py-3 rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-500 outline-none transition">

                            </div>

                            {{-- FILTER TIPE --}}
                            <select name="type"
                                    class="px-4 py-3 rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-500 outline-none transition">

                                <option value="">Semua Tipe</option>
                                <option value="text"   {{ request('type') === 'text'   ? 'selected' : '' }}>Teks</option>
                                <option value="number" {{ request('type') === 'number' ? 'selected' : '' }}>Angka</option>
                                <option value="color"  {{ request('type') === 'color'  ? 'selected' : '' }}>Warna</option>
                                <option value="select" {{ request('type') === 'select' ? 'selected' : '' }}>Pilihan</option>

                            </select>

                            <button type="submit"
                                    class="bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold transition">
                                Filter
                            </button>

                            @if(request('search') || request('type'))
                                <a href="{{ route('product-attributes.index') }}"
                                   class="inline-flex items-center justify-center px-4 py-3 rounded-2xl border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition font-semibold">
                                    Reset
                                </a>
                            @endif

                        </form>

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">

                        <thead class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">ID</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Nama Atribut</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Tipe</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Pilihan (Opsi)</th>
                                <th class="px-6 py-4 font-semibold whitespace-nowrap">Deskripsi</th>
                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($attributes as $attribute)

                                <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition duration-200">

                                    {{-- ID --}}
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        #{{ $attribute->id }}
                                    </td>

                                    {{-- NAMA --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                            </div>

                                            <div class="font-semibold text-gray-900 dark:text-white">
                                                {{ $attribute->name }}
                                            </div>

                                        </div>
                                    </td>

                                    {{-- TIPE --}}
                                    <td class="px-6 py-4">

                                        @php
                                            $typeColor = match($attribute->type) {
                                                'text'   => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300',
                                                'number' => 'bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300',
                                                'color'  => 'bg-pink-100 text-pink-700 dark:bg-pink-900 dark:text-pink-300',
                                                'select' => 'bg-amber-100 text-amber-700 dark:bg-amber-900 dark:text-amber-300',
                                                default  => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp

                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $typeColor }}">
                                            {{ $attribute->type_label }}
                                        </span>

                                    </td>

                                    {{-- PILIHAN (OPSI) --}}
                                    <td class="px-6 py-4">
                                        @if($attribute->type === 'select' && !empty($attribute->options))
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($attribute->options as $opt)
                                                    <span class="inline-block px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs rounded-lg">
                                                        {{ $opt }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>

                                    {{-- DESKRIPSI --}}
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                                        {{ $attribute->description ?? '—' }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">

                                            <a href="{{ route('product-attributes.edit', $attribute->id) }}"
                                               class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                                                ✏ Edit
                                            </a>

                                            <form action="{{ route('product-attributes.destroy', $attribute->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus atribut \'{{ $attribute->name }}\'? Semua nilai atribut pada produk juga akan terhapus.')"
                                                        class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">
                                                    🗑 Hapus
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-6 py-14 text-center">
                                        <div class="flex flex-col items-center">

                                            <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                            </div>

                                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                                                Belum ada atribut produk
                                            </h3>

                                            <p class="text-gray-500 dark:text-gray-400 mt-1">
                                                Tambahkan atribut seperti ukuran, warna, atau berat untuk melengkapi data produk.
                                            </p>

                                            <a href="{{ route('product-attributes.create') }}"
                                               class="mt-5 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold transition">
                                                + Tambah Atribut Pertama
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">
                    {{ $attributes->links() }}
                </div>

            </div>

        </div>

    </div>

</x-app-layout>