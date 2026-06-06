<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Category Management
                </h2>

                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola semua category product inventory
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

                        <svg class="w-5 h-5 text-green-600 dark:text-green-300"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                    </div>

                    <div>

                        <h4 class="font-semibold text-green-700 dark:text-green-300">
                            Success
                        </h4>

                        <p class="text-sm text-green-600 dark:text-green-400">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif

            {{-- MAIN CARD --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm overflow-hidden">

                {{-- TOP BAR --}}
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                        {{-- BUTTON --}}
                        <a href="{{ route('categories.create') }}"
                           class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold transition duration-300 shadow-lg shadow-blue-500/20">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 4v16m8-8H4"/>

                            </svg>

                            Tambah Category

                        </a>

                        {{-- SEARCH --}}
                        <form action="{{ route('categories.index') }}"
                              method="GET"
                              class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto">

                            <div class="relative">

                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">

                                    <svg class="w-5 h-5 text-gray-400"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="m21 21-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"/>

                                    </svg>

                                </div>

                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Cari category..."
                                       class="w-full sm:w-80 pl-12 pr-4 py-3 rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 focus:border-blue-500 outline-none transition">

                            </div>

                            <button type="submit"
                                    class="bg-gray-900 dark:bg-blue-600 hover:bg-black dark:hover:bg-blue-700 text-white px-5 py-3 rounded-2xl font-semibold transition">

                                Search

                            </button>

                        </form>

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left text-gray-600 dark:text-gray-300">

                        <thead class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">

                            <tr>

                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    ID
                                </th>

                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    Name
                                </th>

                                <th class="px-6 py-4 font-semibold whitespace-nowrap">
                                    Description
                                </th>

                                <th class="px-6 py-4 font-semibold text-center whitespace-nowrap">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($categories as $category)

                                <tr class="border-b border-gray-100 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/40 transition duration-200">

                                    {{-- ID --}}
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">

                                        #{{ $category->id }}

                                    </td>

                                    {{-- NAME --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center">

                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-300"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M3 7l9 6 9-6-9-4-9 4zm0 6l9 6 9-6"/>

                                                </svg>

                                            </div>

                                            <div>

                                                <div class="font-semibold text-gray-900 dark:text-white">

                                                    {{ $category->name }}

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    {{-- DESCRIPTION --}}
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">

                                        {{ $category->description ?? '-' }}

                                    </td>

                                    {{-- ACTION --}}
                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-center gap-2">

                                            {{-- EDIT --}}
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                               class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">

                                                ✏ Edit

                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('categories.destroy', $category->id) }}"
                                                  method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        onclick="return confirm('Yakin ingin menghapus category ini?')"
                                                        class="inline-flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition">

                                                    🗑 Delete

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4"
                                        class="px-6 py-14 text-center">

                                        <div class="flex flex-col items-center">

                                            <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center mb-4">

                                                <svg class="w-10 h-10 text-gray-400"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M20 13V7a2 2 0 00-2-2h-5l-2-2H6a2 2 0 00-2 2v8"/>

                                                </svg>

                                            </div>

                                            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">

                                                Belum ada category

                                            </h3>

                                            <p class="text-gray-500 dark:text-gray-400 mt-1">

                                                Tambahkan category baru untuk memulai

                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="p-6 border-t border-gray-200 dark:border-gray-700">

                    {{ $categories->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>