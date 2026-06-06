<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Create Transaction
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Add new stock transaction
            </p>

        </div>

    </x-slot>

    <div class="space-y-6">

        <div class="max-w-4xl">

            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">

                {{-- ERROR SESSION --}}
                @if(session('error'))

                    <div class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">

                        {{ session('error') }}

                    </div>

                @endif

                {{-- VALIDATION ERROR --}}
                @if($errors->any())

                    <div class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">

                        <ul class="list-disc pl-5 space-y-1">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('stock-transactions.store') }}"
                      method="POST"
                      class="space-y-6">

                    @csrf

                    {{-- PRODUCT --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                            Product

                        </label>

                        <select
                            name="product_id"
                            required
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900
                                   dark:text-white
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500">

                            <option value="">
                                Select Product
                            </option>

                            @foreach ($products as $product)

                                <option value="{{ $product->id }}">

                                    {{ $product->name }}
                                    (Stock: {{ $product->stock }})

                                </option>

                            @endforeach

                        </select>

                    </div>

                    {{-- TYPE --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                            Transaction Type

                        </label>

                        <select
                            name="type"
                            required
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900
                                   dark:text-white
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500">

                            <option value="in">
                                Stock In
                            </option>

                            <option value="out">
                                Stock Out
                            </option>

                        </select>

                    </div>

                    {{-- QTY --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                            Quantity

                        </label>

                        <input
                            type="number"
                            name="qty"
                            min="1"
                            required
                            placeholder="Enter quantity"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900
                                   dark:text-white
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500">

                    </div>

                    {{-- NOTE --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                            Note

                        </label>

                        <textarea
                            name="note"
                            rows="5"
                            placeholder="Enter transaction note..."
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900
                                   dark:text-white
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500"></textarea>

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-wrap gap-3 pt-2">

                        <button
                            type="submit"
                            class="inline-flex items-center px-5 py-3 rounded-2xl bg-green-600 hover:bg-green-700 text-white font-medium transition">

                            Save Transaction

                        </button>

                        <a
                            href="{{ route('stock-transactions.index') }}"
                            class="inline-flex items-center px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-medium transition">

                            Back

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>