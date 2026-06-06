<x-guest-layout>

    <div class="min-h-screen flex items-center justify-center
                bg-gray-100 dark:bg-gray-900
                transition duration-300 px-4">

        <div class="w-full max-w-md">

            {{-- CARD --}}
            <div class="bg-white dark:bg-gray-800
                        shadow-2xl rounded-2xl p-8
                        transition duration-300">

                {{-- LOGO --}}
                <div class="flex justify-center mb-6">

                    <img src="{{ asset('images/logo.png') }}"
                         alt="Logo"
                         class="w-24 h-24 object-contain">

                </div>

                {{-- TITLE --}}
                <div class="text-center mb-6">

                    <h1 class="text-3xl font-extrabold
                               text-gray-800 dark:text-white">

                        🔑 Forgot Password

                    </h1>

                    <p class="text-gray-500 dark:text-gray-400 mt-2 text-sm leading-relaxed">

                        Lupa password? Tidak masalah.
                        Masukkan email Anda dan kami akan mengirimkan
                        link reset password.

                    </p>

                </div>

                {{-- SESSION STATUS --}}
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')" />

                {{-- FORM --}}
                <form method="POST"
                      action="{{ route('password.email') }}">

                    @csrf

                    {{-- EMAIL --}}
                    <div class="mb-6">

                        <label class="block mb-2 font-semibold
                                     text-gray-700 dark:text-gray-300">

                            Email

                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus

                               class="w-full rounded-xl border
                                      border-gray-300 dark:border-gray-700
                                      bg-white dark:bg-gray-900
                                      text-gray-800 dark:text-white
                                      px-4 py-3
                                      focus:ring-2 focus:ring-blue-500
                                      focus:border-blue-500">

                        @error('email')

                            <p class="text-red-500 text-sm mt-2">

                                {{ $message }}

                            </p>

                        @enderror

                    </div>

                    {{-- BUTTON --}}
                    <button type="submit"
                            class="w-full bg-blue-500 hover:bg-blue-600
                                   text-white font-bold py-3 rounded-xl
                                   shadow-lg transition duration-300
                                   hover:scale-[1.02]">

                        📩 Kirim Link Reset Password

                    </button>

                    {{-- BACK TO LOGIN --}}
                    <div class="mt-6 text-center">

                        <a href="{{ route('login') }}"
                           class="text-blue-500 hover:text-blue-700 font-semibold">

                            ← Kembali ke Login

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-guest-layout>