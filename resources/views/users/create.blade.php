<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Tambah User</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Buat akun pengguna baru beserta hak aksesnya</p>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ERROR ALERT --}}
            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-5">
                    <div class="flex items-start gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-100 dark:bg-red-800">
                            <svg class="w-5 h-5 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-semibold text-red-700 dark:text-red-300">Terjadi Kesalahan</h4>
                            <ul class="mt-2 list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- FORM CARD --}}
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="border-b border-gray-200 dark:border-gray-700 px-8 py-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                            <svg class="w-7 h-7 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Form Tambah User</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Isi informasi pengguna dengan lengkap</p>
                        </div>
                    </div>
                </div>

                {{-- FORM --}}
                <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        {{-- NAMA --}}
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                   placeholder="Masukkan nama lengkap..."
                                   class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                        </div>

                        {{-- EMAIL --}}
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   placeholder="contoh@email.com"
                                   class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                        </div>

                        {{-- PASSWORD --}}
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" required
                                   placeholder="Minimal 6 karakter"
                                   class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" required
                                   placeholder="Ulangi password"
                                   class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                        </div>

                    </div>

                    {{-- ROLE --}}
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-300">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select name="role" required
                                class="w-full rounded-2xl border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-900 px-4 py-3 text-gray-900 dark:text-white focus:border-blue-500 focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-800 outline-none transition">
                            <option value="">-- Pilih Role --</option>
                            <option value="admin"          {{ old('role') == 'admin'          ? 'selected' : '' }}>Admin</option>
                            <option value="manajer_gudang" {{ old('role') == 'manajer_gudang' ? 'selected' : '' }}>Manajer Gudang</option>
                            <option value="staff_gudang"   {{ old('role') == 'staff_gudang'   ? 'selected' : '' }}>Staff Gudang</option>
                        </select>
                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-4">
                        <button type="submit"
                                class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-2xl transition duration-300 shadow-lg shadow-blue-500/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan User
                        </button>
                        <a href="{{ route('users.index') }}"
                           class="inline-flex items-center justify-center gap-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-white font-semibold px-6 py-3 rounded-2xl transition duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                            Kembali
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

</x-app-layout>