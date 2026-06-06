<x-app-layout>

    <x-slot name="header">

        <div>

            <h2 class="text-3xl font-bold text-gray-800 dark:text-white">
                Pengaturan Aplikasi
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kelola nama dan logo aplikasi Stockify
            </p>

        </div>

    </x-slot>

    <div class="max-w-2xl space-y-6">

        {{-- SUCCESS --}}
        @if(session('success'))
            <div class="p-4 rounded-2xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- ERROR --}}
        @if($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('settings.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PATCH')

            <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm divide-y divide-gray-100 dark:divide-gray-700">

                {{-- NAMA APLIKASI --}}
                <div class="p-6 space-y-2">

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Nama Aplikasi
                    </label>

                    <input type="text"
                           name="app_name"
                           value="{{ old('app_name', $settings['app_name'] ?? 'Stockify') }}"
                           required
                           maxlength="100"
                           placeholder="Contoh: Stockify"
                           @class([
                               'w-full rounded-2xl border dark:border-gray-700',
                               'bg-gray-50 dark:bg-gray-900 dark:text-white',
                               'px-4 py-3 text-sm transition',
                               'focus:ring-2 focus:ring-blue-500 focus:border-blue-500',
                               'border-gray-200' => !$errors->has('app_name'),
                               'border-red-400'  => $errors->has('app_name'),
                           ])>

                    @error('app_name')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-gray-400 dark:text-gray-500">
                        Nama ini akan tampil di sidebar, tab browser, dan halaman login.
                    </p>

                </div>

                {{-- LOGO --}}
                <div class="p-6 space-y-4">

                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Logo Aplikasi
                    </label>

                    {{-- Preview logo saat ini --}}
                    @if(!empty($settings['logo']))

                        <div class="flex items-center gap-4">

                            <div class="w-20 h-20 rounded-2xl border border-gray-200 dark:border-gray-700
                                        bg-gray-50 dark:bg-gray-900
                                        flex items-center justify-center overflow-hidden">
                                <img src="{{ Storage::url($settings['logo']) }}"
                                     alt="Logo saat ini"
                                     class="w-full h-full object-contain p-2">
                            </div>

                            <div class="space-y-1">
                                <p class="text-sm text-gray-600 dark:text-gray-400 font-medium">Logo saat ini</p>

                                {{-- Tombol hapus logo --}}
                                <form action="{{ route('settings.logo.delete') }}"
                                      method="POST"
                                      onsubmit="return confirm('Hapus logo ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-xs text-red-500 hover:text-red-700 dark:hover:text-red-400 transition font-medium">
                                        Hapus Logo
                                    </button>
                                </form>
                            </div>

                        </div>

                    @else

                        <div class="w-20 h-20 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700
                                    flex items-center justify-center text-gray-400 bg-gray-50 dark:bg-gray-900">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>

                    @endif

                    {{-- Upload logo baru --}}
                    <div class="space-y-2">

                        <label class="text-sm text-gray-600 dark:text-gray-400">
                            {{ !empty($settings['logo']) ? 'Ganti dengan logo baru' : 'Upload logo' }}
                        </label>

                        <input type="file"
                               name="logo"
                               accept="image/png,image/jpeg,image/jpg,image/svg+xml"
                               class="block w-full text-sm text-gray-600 dark:text-gray-400
                                      file:mr-4 file:py-2.5 file:px-4
                                      file:rounded-xl file:border-0
                                      file:font-medium file:text-sm
                                      file:bg-blue-50 file:text-blue-700
                                      dark:file:bg-blue-900/30 dark:file:text-blue-300
                                      hover:file:bg-blue-100 dark:hover:file:bg-blue-900/50
                                      file:cursor-pointer file:transition
                                      @error('logo') border border-red-400 rounded-xl p-2 @enderror">

                        @error('logo')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror

                        <p class="text-xs text-gray-400 dark:text-gray-500">
                            Format: JPG, PNG, SVG. Ukuran maksimal: 2MB. Rekomendasi: 200×200px.
                        </p>

                    </div>

                </div>

                {{-- SUBMIT --}}
                <div class="p-6 flex items-center justify-between">

                    <p class="text-xs text-gray-400">
                        Perubahan akan langsung berlaku setelah disimpan.
                    </p>

                    <button type="submit"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl
                                   bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm transition">

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>

                        Simpan Pengaturan

                    </button>

                </div>

            </div>

        </form>

    </div>

</x-app-layout>