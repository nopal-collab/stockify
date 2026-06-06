<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-white leading-tight transition duration-300">
            👤 Profile
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900 min-h-screen transition duration-300">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- PROFILE INFORMATION --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl transition duration-300">

                <div class="mb-4">

                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                        👤 Informasi Akun
                    </h3>

                    <p class="text-gray-500 dark:text-gray-400 mt-1">
                        Kelola informasi profile akun Anda.
                    </p>

                </div>

                {{-- ROLE --}}
                <div class="mb-6">

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        Role
                    </label>

                    <div class="inline-flex items-center px-4 py-2 rounded-lg
                                bg-blue-100 dark:bg-blue-900
                                text-blue-700 dark:text-blue-300
                                font-bold">

                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}

                    </div>

                </div>

                @include('profile.partials.update-profile-information-form')

            </div>

            {{-- UPDATE PASSWORD --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl transition duration-300">

                <div class="mb-4">

                    <h3 class="text-xl font-bold text-gray-800 dark:text-white">
                        🔒 Update Password
                    </h3>

                    <p class="text-gray-500 dark:text-gray-400 mt-1">
                        Gunakan password yang aman agar akun tetap terlindungi.
                    </p>

                </div>

                @include('profile.partials.update-password-form')

            </div>

            {{-- DELETE ACCOUNT --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow-xl sm:rounded-xl transition duration-300">

                <div class="mb-4">

                    <h3 class="text-xl font-bold text-red-600 dark:text-red-400">
                        🗑 Hapus Akun
                    </h3>

                    <p class="text-gray-500 dark:text-gray-400 mt-1">
                        Setelah akun dihapus, semua data akan hilang permanen.
                    </p>

                </div>

                @include('profile.partials.delete-user-form')

            </div>

        </div>

    </div>

</x-app-layout>