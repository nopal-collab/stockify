<x-app-layout>

    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 dark:text-white leading-tight">
            📝 Activity Logs
        </h2>
    </x-slot>

    <div class="py-10 bg-gray-100 dark:bg-gray-900 min-h-screen transition duration-300">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6 transition duration-300">

                {{-- HEADER --}}
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">

                    <h3 class="text-2xl font-bold text-gray-800 dark:text-white">
                        Riwayat Aktivitas User
                    </h3>

                    {{-- SEARCH --}}
                    <form method="GET"
                          action="{{ route('activity-logs.index') }}"
                          class="flex flex-col md:flex-row gap-3">

                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari user atau aktivitas..."
                               class="border border-gray-300 dark:border-gray-600
                                      bg-white dark:bg-gray-700
                                      text-gray-800 dark:text-white
                                      rounded-xl px-4 py-3
                                      w-full md:w-80
                                      focus:ring-2 focus:ring-blue-500
                                      focus:outline-none">

                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-semibold transition">

                            🔍 Search

                        </button>

                    </form>

                </div>

                {{-- SUCCESS --}}
                @if(session('success'))

                    <div class="mb-5 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-xl">

                        {{ session('success') }}

                    </div>

                @endif

                {{-- TABLE --}}
                <div class="overflow-x-auto rounded-xl">

                    <table class="table-auto w-full border-collapse border border-gray-300 dark:border-gray-700">

                        <thead>

                            <tr class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">

                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">
                                    No
                                </th>

                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">
                                    User
                                </th>

                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">
                                    Activity
                                </th>

                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">
                                    Description
                                </th>

                                <th class="border border-gray-300 dark:border-gray-700 px-4 py-3">
                                    Date
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($logs as $log)

                                <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300 text-gray-800 dark:text-gray-200">

                                    {{-- NUMBER --}}
                                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-3 text-center">

                                        {{ $logs->firstItem() + $loop->index }}

                                    </td>

                                    {{-- USER --}}
                                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-3 font-semibold">

                                        {{ $log->user->name ?? 'Unknown User' }}

                                    </td>

                                    {{-- ACTIVITY --}}
                                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-3">

                                        @if($log->activity == 'create')

                                            <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-bold">

                                                ➕ CREATE

                                            </span>

                                        @elseif($log->activity == 'update')

                                            <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-sm font-bold">

                                                ✏ UPDATE

                                            </span>

                                        @elseif($log->activity == 'delete')

                                            <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">

                                                🗑 DELETE

                                            </span>

                                        @else

                                            <span class="bg-blue-500 text-white px-3 py-1 rounded-full text-sm font-bold">

                                                ℹ {{ strtoupper($log->activity) }}

                                            </span>

                                        @endif

                                    </td>

                                    {{-- DESCRIPTION --}}
                                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-3">

                                        {{ $log->description }}

                                    </td>

                                    {{-- DATE --}}
                                    <td class="border border-gray-300 dark:border-gray-700 px-4 py-3 text-center">

                                        {{ $log->created_at->format('d M Y H:i') }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5"
                                        class="border border-gray-300 dark:border-gray-700 px-4 py-6 text-center text-gray-500 dark:text-gray-400">

                                        Belum ada activity log

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="mt-6">

                    {{ $logs->links() }}

                </div>

            </div>

        </div>

    </div>

</x-app-layout>