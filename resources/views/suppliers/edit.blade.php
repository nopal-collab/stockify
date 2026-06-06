<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Edit Supplier
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Update supplier information
            </p>

        </div>

    </x-slot>

    <div class="space-y-6">

        <div class="max-w-3xl">

            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">

                {{-- ERROR --}}
                @if($errors->any())

                    <div class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400">

                        <ul class="list-disc pl-5 space-y-1">

                            @foreach($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                @endif

                <form action="{{ route('suppliers.update', $supplier->id) }}"
                      method="POST"
                      class="space-y-6">

                    @csrf
                    @method('PUT')

                    {{-- NAME --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                            Supplier Name

                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $supplier->name) }}"
                            placeholder="Enter supplier name"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900
                                   dark:text-white
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500"
                            required>

                    </div>

                    {{-- PHONE --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                            Phone

                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $supplier->phone) }}"
                            placeholder="Enter phone number"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900
                                   dark:text-white
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500"
                            required>

                    </div>

                    {{-- ADDRESS --}}
                    <div>

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">

                            Address

                        </label>

                        <textarea
                            name="address"
                            rows="5"
                            placeholder="Enter supplier address"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700
                                   bg-gray-50 dark:bg-gray-900
                                   dark:text-white
                                   px-4 py-3
                                   focus:ring-2 focus:ring-blue-500
                                   focus:border-blue-500"
                            required>{{ old('address', $supplier->address) }}</textarea>

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-wrap gap-3 pt-2">

                        <button
                            type="submit"
                            class="inline-flex items-center px-5 py-3 rounded-2xl bg-yellow-500 hover:bg-yellow-600 text-white font-medium transition">

                            Update Supplier

                        </button>

                        <a
                            href="{{ route('suppliers.index') }}"
                            class="inline-flex items-center px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-medium transition">

                            Back

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>