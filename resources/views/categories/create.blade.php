<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                Tambah Category
            </h2>

            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Tambahkan category baru untuk product inventory
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

                            <svg class="w-5 h-5 text-red-600 dark:text-red-300"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>

                            </svg>

                        </div>

                        <div>

                            <h4 class="font-semibold text-red-700 dark:text-red-300">
                                Terjadi Kesalahan
                            </h4>

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

                {{-- HEADER --}}
                <div class="border-b border-gray-200 dark:border-gray-700 px-8 py-6">

                    <div class="flex items-center gap-4">

                        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center">

                            <svg class="w-7 h-7 text-blue-600 dark:text-blue-300"
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

                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">
                                Form Category
                            </h3>

                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Isi informasi category dengan lengkap
                            </p>

                        </div>

                    </div>

                </div>

                {{-- FORM --}}
                <form action="{{ route('categories.store') }}"
                      method="POST"
                      class="p-8 space-y-6">

                    @csrf

                    {{-- CATEGORY NAME --}}
                    <div>

                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                            Nama Category

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Masukkan nama category..."
                            required
                            class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">

                    </div>

                    {{-- DESCRIPTION --}}
                    <div>

                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            placeholder="Masukkan description category..."
                            required
                            class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition resize-none">{{ old('description') }}</textarea>

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">

                        {{-- SAVE --}}
                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-2xl transition duration-300 shadow-lg shadow-blue-500/20">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5 13l4 4L19 7"/>

                            </svg>

                            Simpan Category

                        </button>

                        {{-- BACK --}}
                        <a href="{{ route('categories.index') }}"
                           class="inline-flex items-center justify-center gap-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-semibold px-6 py-3 rounded-2xl transition duration-300">

                            <svg class="w-5 h-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M15 19l-7-7 7-7"/>

                            </svg>

                            Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>