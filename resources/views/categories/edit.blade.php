<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-3xl text-gray-800 dark:text-white leading-tight">
            ✏ Edit Category
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen transition duration-300">

        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-2xl p-8 transition duration-300">

                {{-- ERROR MESSAGE --}}
                @if ($errors->any())

                    <div class="mb-6 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-200 px-4 py-3 rounded-xl">

                        <ul class="list-disc pl-5">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('categories.update', $category->id) }}"
                      method="POST">

                    @csrf
                    @method('PUT')

                    {{-- CATEGORY NAME --}}
                    <div class="mb-6">

                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">

                            Nama Category

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            required
                            class="w-full border border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-white
                                   rounded-xl px-4 py-3
                                   focus:ring-2 focus:ring-orange-400
                                   focus:outline-none transition">

                    </div>

                    {{-- DESCRIPTION --}}
                    <div class="mb-8">

                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">

                            Description

                        </label>

                        <textarea
                            name="description"
                            rows="5"
                            required
                            class="w-full border border-gray-300 dark:border-gray-700
                                   dark:bg-gray-900 dark:text-white
                                   rounded-xl px-4 py-3
                                   focus:ring-2 focus:ring-orange-400
                                   focus:outline-none transition">{{ old('description', $category->description) }}</textarea>

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-wrap gap-3">

                        <button
                            type="submit"
                            class="bg-orange-500 hover:bg-orange-600
                                   text-white font-bold
                                   px-6 py-3 rounded-xl
                                   shadow-lg transition duration-300">

                            💾 Update Category

                        </button>

                        <a
                            href="{{ route('categories.index') }}"
                            class="bg-gray-500 hover:bg-gray-600
                                   text-white font-bold
                                   px-6 py-3 rounded-xl
                                   shadow-lg transition duration-300">

                            🔙 Kembali

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>