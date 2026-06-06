<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Suppliers
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Manage your inventory suppliers
            </p>

        </div>

    </x-slot>

    <div class="space-y-6">

        <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm p-6">

            {{-- SUCCESS --}}
            @if(session('success'))

                <div class="mb-6 p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400">

                    {{ session('success') }}

                </div>

            @endif

            {{-- ACTION BUTTON --}}
            <div class="flex flex-wrap gap-3 mb-8">

                @if(auth()->user()->role == 'admin')

                    <a href="{{ route('suppliers.create') }}"
                       class="inline-flex items-center px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">

                        Add Supplier

                    </a>

                @endif

            </div>

            {{-- SEARCH --}}
            <form action="{{ route('suppliers.index') }}"
                  method="GET"
                  class="flex flex-wrap gap-3 mb-8">

                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Search suppliers..."
                       class="w-full md:w-72 rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 dark:text-white px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                <button type="submit"
                        class="px-5 py-3 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-medium transition">

                    Search

                </button>

                <a href="{{ route('suppliers.index') }}"
                   class="px-5 py-3 rounded-2xl bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-medium transition">

                    Reset

                </a>

            </form>

            {{-- TABLE --}}
            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 dark:bg-gray-700/50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                ID
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Supplier
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Phone
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Address
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Action
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">

                        @forelse($suppliers as $supplier)

                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">

                                {{-- ID --}}
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">

                                    {{ $supplier->id }}

                                </td>

                                {{-- NAME --}}
                                <td class="px-6 py-4">

                                    <div class="font-semibold text-gray-800 dark:text-white">

                                        {{ $supplier->name }}

                                    </div>

                                </td>

                                {{-- PHONE --}}
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">

                                    {{ $supplier->phone }}

                                </td>

                                {{-- ADDRESS --}}
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400">

                                    {{ $supplier->address }}

                                </td>

                                {{-- ACTION --}}
                                <td class="px-6 py-4">

                                    @if(auth()->user()->role == 'admin')

                                        <div class="flex items-center justify-center gap-2">

                                            {{-- EDIT --}}
                                            <a href="{{ route('suppliers.edit', $supplier->id) }}"
                                               class="px-4 py-2 rounded-xl bg-yellow-50 hover:bg-yellow-100 text-yellow-600 text-sm font-medium transition">

                                                Edit

                                            </a>

                                            {{-- DELETE --}}
                                            <form action="{{ route('suppliers.destroy', $supplier->id) }}"
                                                  method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        onclick="return confirm('Delete this supplier?')"
                                                        class="px-4 py-2 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium transition">

                                                    Delete

                                                </button>

                                            </form>

                                        </div>

                                    @else

                                        <div class="text-sm text-gray-400 text-center">

                                            View Only

                                        </div>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">

                                    No suppliers available

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="mt-8">

                {{ $suppliers->appends(request()->query())->links() }}

            </div>

        </div>

    </div>

</x-app-layout>