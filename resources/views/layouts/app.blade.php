<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="
            if (darkMode) {
                document.documentElement.classList.add('dark')
            }

            $watch('darkMode', value => {
                localStorage.setItem('darkMode', value)

                if (value) {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
                }
            })
      "
>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $appName ?? config('app.name', 'Stockify') }}</title>

    {{-- FONT --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap"
          rel="stylesheet" />

    {{-- DARK MODE (cegah flash) --}}
    <script>
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark')
        }
    </script>

    {{-- ALPINE --}}
    <script defer
            src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>

    {{-- VITE --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 transition duration-300">

@php
    $role         = Auth::user()->role ?? null;
    $currentRoute = request()->route()->getName();
@endphp

<div class="flex min-h-screen">

    {{-- ===================== SIDEBAR ===================== --}}
    <aside class="w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-sm flex flex-col">

        {{-- LOGO --}}
        <div class="h-20 flex items-center px-6 border-b border-gray-100 dark:border-gray-700 gap-3">

            {{-- Logo gambar jika ada --}}
            @if(!empty($appLogo))
                <img src="{{ Storage::url($appLogo) }}"
                     alt="{{ $appName ?? 'Stockify' }}"
                     class="h-10 w-auto object-contain shrink-0">
            @endif

            <div>

                <h1 class="text-2xl font-bold text-blue-600">
                    {{ $appName ?? 'Stockify' }}
                </h1>

                <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">
                    {{ str_replace('_', ' ', $role) }}
                </p>

            </div>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 p-5 space-y-1 overflow-y-auto">

            @php
                $linkBase   = 'flex items-center gap-3 px-4 py-3 rounded-2xl font-medium transition';
                $linkActive = 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300';
                $linkIdle   = 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700';
            @endphp

            {{-- DASHBOARD --}}
            <a href="{{ route('dashboard') }}"
               class="{{ $linkBase }} {{ request()->routeIs('dashboard') ? $linkActive : $linkIdle }}">

                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 10l9-7 9 7v11a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v8a2 2 0 01-2 2H3z" />
                </svg>

                Dashboard

            </a>

            {{-- CATEGORIES — admin only --}}
            @if($role === 'admin')

                <a href="{{ route('categories.index') }}"
                   class="{{ $linkBase }} {{ request()->routeIs('categories.*') ? $linkActive : $linkIdle }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h7" />
                    </svg>

                    Categories

                </a>

            @endif

            {{-- ATRIBUT PRODUK — admin only --}}
            @if($role === 'admin')

                <a href="{{ route('product-attributes.index') }}"
                   class="{{ $linkBase }} {{ request()->routeIs('product-attributes.*') ? $linkActive : $linkIdle }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>
                    </svg>

                    Atribut Produk

                </a>

            @endif

            {{-- PRODUCTS — admin & manajer_gudang --}}
            @if(in_array($role, ['admin', 'manajer_gudang']))

                <a href="{{ route('products.index') }}"
                   class="{{ $linkBase }} {{ request()->routeIs('products.*') ? $linkActive : $linkIdle }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4m16 0H4" />
                    </svg>

                    Products

                </a>

            @endif

            {{-- SUPPLIERS — admin & manajer_gudang --}}
            @if(in_array($role, ['admin', 'manajer_gudang']))

                <a href="{{ route('suppliers.index') }}"
                   class="{{ $linkBase }} {{ request()->routeIs('suppliers.*') ? $linkActive : $linkIdle }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6m10 0H7" />
                    </svg>

                    Suppliers

                </a>

            @endif

            {{-- STOCK TRANSACTIONS — semua role --}}
            <a href="{{ route('stock-transactions.index') }}"
               class="{{ $linkBase }} {{ request()->routeIs('stock-transactions.*') ? $linkActive : $linkIdle }}">

                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8L10 18l-5-5" />
                </svg>

                Transactions

            </a>

            {{-- STOCK OPNAME — semua role --}}
            <a href="{{ route('stock-opnames.index') }}"
               class="{{ $linkBase }} {{ request()->routeIs('stock-opnames.*') ? $linkActive : $linkIdle }}">

                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>

                Stock Opname

            </a>

            {{-- USERS — admin only --}}
            @if($role === 'admin')

                <a href="{{ route('users.index') }}"
                   class="{{ $linkBase }} {{ request()->routeIs('users.*') ? $linkActive : $linkIdle }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-1a4 4 0 00-4-4h-1M9 20H4v-1a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8z" />
                    </svg>

                    Users

                </a>

            @endif

            {{-- ACTIVITY LOG — admin only --}}
                        {{-- LAPORAN — admin & manajer_gudang --}}
            @if(in_array($role, ['admin', 'manajer_gudang']))

                <a href="{{ route('reports.index') }}"
                   class="{{ $linkBase }} {{ request()->routeIs('reports.*') ? $linkActive : $linkIdle }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0120 9.414V19a2 2 0 01-2 2z" />
                    </svg>

                    Laporan

                </a>

            @endif

            {{-- STOK MINIMUM — admin only --}}
            @if($role === 'admin')

                <a href="{{ route('stock.min-stock') }}"
                   class="{{ $linkBase }} {{ request()->routeIs('stock.min-stock*') ? $linkActive : $linkIdle }}">

                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    Stok Minimum

                </a>

            @endif

        </nav>

        {{-- ============================================================ --}}
        {{-- BOTTOM BAR — dark mode toggle + settings (admin only) --}}
        {{-- ============================================================ --}}
        <div class="p-4 border-t border-gray-100 dark:border-gray-700">

            <div class="flex items-center gap-2">

                {{-- DARK MODE TOGGLE — icon only --}}
                <button @click="darkMode = !darkMode"
                        x-tooltip="darkMode ? 'Light Mode' : 'Dark Mode'"
                        class="flex items-center justify-center w-10 h-10 rounded-xl
                               bg-gray-100 dark:bg-gray-700
                               hover:bg-gray-200 dark:hover:bg-gray-600
                               text-gray-600 dark:text-gray-300
                               transition shrink-0"
                        :title="darkMode ? 'Light Mode' : 'Dark Mode'">

                    {{-- Moon (tampil saat light mode aktif) --}}
                    <svg x-show="!darkMode"
                         class="w-5 h-5"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>

                    {{-- Sun (tampil saat dark mode aktif) --}}
                    <svg x-show="darkMode"
                         class="w-5 h-5"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>

                </button>

                {{-- SETTINGS — admin only, icon + label --}}
                @if($role === 'admin')

                    <a href="{{ route('settings.index') }}"
                       title="Pengaturan"
                       class="flex-1 flex items-center gap-2.5 px-4 py-2.5 rounded-xl
                              {{ request()->routeIs('settings.*')
                                  ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300'
                                  : 'bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300' }}
                              transition text-sm font-medium">

                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
                        </svg>

                        Pengaturan

                    </a>

                @else

                    {{-- Non-admin: dark mode tombol melebar penuh --}}
                    <div class="flex-1"></div>

                @endif

            </div>

        </div>

    </aside>

    {{-- ===================== MAIN CONTENT ===================== --}}
    <div class="flex-1 flex flex-col min-w-0">

        {{-- TOPBAR --}}
        <header class="h-20 bg-white dark:bg-gray-800
                       border-b border-gray-200 dark:border-gray-700
                       px-8 flex items-center justify-between shadow-sm">

            <div>
                {{ $header ?? '' }}
            </div>

            {{-- USER DROPDOWN --}}
            <div class="relative" x-data="{ open: false }">

                <button @click="open = !open"
                        @keydown.escape="open = false"
                        class="flex items-center gap-3 px-3 py-2 rounded-2xl
                               hover:bg-gray-100 dark:hover:bg-gray-700
                               transition cursor-pointer select-none">

                    {{-- AVATAR --}}
                    <div class="w-10 h-10 rounded-full
                                bg-blue-600 text-white
                                flex items-center justify-center
                                font-bold shadow text-base shrink-0">

                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                    </div>

                    {{-- NAME & ROLE --}}
                    <div class="text-left hidden sm:block">

                        <p class="font-semibold text-gray-800 dark:text-white text-sm leading-tight">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                            {{ str_replace('_', ' ', $role) }}
                        </p>

                    </div>

                    {{-- CHEVRON --}}
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 transition-transform duration-200"
                         :class="open ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>

                </button>

                {{-- DROPDOWN MENU --}}
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     @click.outside="open = false"
                     class="absolute right-0 mt-2 w-52
                            bg-white dark:bg-gray-800
                            border border-gray-200 dark:border-gray-700
                            rounded-2xl shadow-xl z-50 overflow-hidden"
                     style="display: none;">

                    {{-- USER INFO --}}
                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700">

                        <p class="font-semibold text-gray-800 dark:text-white text-sm truncate">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ Auth::user()->email }}
                        </p>

                    </div>

                    {{-- MENU ITEMS --}}
                    <div class="py-2">

                        {{-- PROFILE --}}
                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-3 px-4 py-2.5
                                  text-sm text-gray-700 dark:text-gray-300
                                  hover:bg-gray-100 dark:hover:bg-gray-700
                                  transition">

                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>

                            Profile

                        </a>

                        <div class="my-1 border-t border-gray-100 dark:border-gray-700"></div>

                        {{-- LOGOUT --}}
                        <form method="POST" action="{{ route('logout') }}">

                            @csrf

                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-2.5
                                           text-sm text-red-600 dark:text-red-400
                                           hover:bg-red-50 dark:hover:bg-red-900/20
                                           transition">

                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h6a2 2 0 012 2v1"/>
                                </svg>

                                Logout

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </header>

        {{-- CONTENT --}}
        <main class="flex-1 p-8">

            {{ $slot }}

        </main>

    </div>

</div>

</body>

</html>