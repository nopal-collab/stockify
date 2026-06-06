<nav class="h-full flex flex-col">

    {{-- MENU --}}
    <div class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">

        {{-- DASHBOARD --}}
        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
           {{ request()->routeIs('dashboard')
                ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
           }}">

            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 10l9-7 9 7v11a2 2 0 01-2 2h-4a2 2 0 01-2-2V13H9v8a2 2 0 01-2 2H3z"/>
            </svg>

            <span>Dashboard</span>

        </a>

        {{-- ====================== --}}
        {{-- ADMIN --}}
        {{-- ====================== --}}
        @if(auth()->user()->role == 'admin')

            {{-- USERS --}}
            <a href="{{ route('users.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('users.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6"/>
                </svg>

                <span>Users</span>

            </a>

            {{-- PRODUCTS --}}
            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('products.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4"/>
                </svg>

                <span>Products</span>

            </a>

            {{-- CATEGORIES --}}
            <a href="{{ route('categories.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('categories.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

                <span>Categories</span>

            </a>

            {{-- SUPPLIERS --}}
            <a href="{{ route('suppliers.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('suppliers.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                </svg>

                <span>Suppliers</span>

            </a>

            {{-- TRANSACTIONS --}}
            <a href="{{ route('stock-transactions.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('stock-transactions.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8L10 18l-5-5"/>
                </svg>

                <span>Transactions</span>

            </a>

            {{-- STOCK OPNAME --}}
            <a href="{{ route('stock-opnames.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('stock-opnames.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>

                <span>Stock Opname</span>

            </a>

            {{-- LAPORAN --}}
            <a href="{{ route('reports.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('reports.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0120 9.414V19a2 2 0 01-2 2z"/>
                </svg>

                <span>Laporan</span>

            </a>

        @endif

        {{-- ====================== --}}
        {{-- MANAJER GUDANG --}}
        {{-- ====================== --}}
        @if(auth()->user()->role == 'manajer_gudang')

            {{-- PRODUCTS --}}
            <a href="{{ route('products.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('products.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4"/>
                </svg>

                <span>Products</span>

            </a>

            {{-- SUPPLIERS --}}
            <a href="{{ route('suppliers.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('suppliers.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                </svg>

                <span>Suppliers</span>

            </a>

            {{-- TRANSACTIONS --}}
            <a href="{{ route('stock-transactions.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('stock-transactions.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8L10 18l-5-5"/>
                </svg>

                <span>Transactions</span>

            </a>

            {{-- STOCK OPNAME --}}
            <a href="{{ route('stock-opnames.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('stock-opnames.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>

                <span>Stock Opname</span>

            </a>

            {{-- LAPORAN --}}
            <a href="{{ route('reports.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('reports.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0120 9.414V19a2 2 0 01-2 2z"/>
                </svg>

                <span>Laporan</span>

            </a>

        @endif

        {{-- ====================== --}}
        {{-- STAFF GUDANG --}}
        {{-- ====================== --}}
        @if(auth()->user()->role == 'staff_gudang')

            {{-- TRANSACTIONS --}}
            <a href="{{ route('stock-transactions.index') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-2xl transition
               {{ request()->routeIs('stock-transactions.*')
                    ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 font-semibold'
                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700'
               }}">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M13 7h8m0 0v8m0-8L10 18l-5-5"/>
                </svg>

                <span>Transactions</span>

            </a>

        @endif

    </div>

    {{-- USER PROFILE --}}
    <div class="p-4 border-t border-gray-100 dark:border-gray-700">

        <div class="flex items-center gap-3 mb-4">

            <div class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div>
                <h4 class="font-semibold text-gray-800 dark:text-white">
                    {{ auth()->user()->name }}
                </h4>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                </p>
            </div>

        </div>

        {{-- LOGOUT --}}
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit"
                    class="w-full px-4 py-3 rounded-2xl
                           bg-red-50 dark:bg-red-900/20
                           text-red-600 dark:text-red-400
                           hover:bg-red-100 dark:hover:bg-red-900/40
                           transition font-medium">
                Logout
            </button>

        </form>

    </div>

</nav>