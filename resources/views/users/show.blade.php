<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Detail User</h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Informasi akun pengguna</p>
            </div>
            <a href="{{ route('users.index') }}"
               class="inline-flex items-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-white px-5 py-2.5 rounded-2xl font-semibold transition text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl shadow-sm overflow-hidden">

                {{-- HERO --}}
                <div class="p-8 flex flex-col sm:flex-row items-center sm:items-start gap-6">

                    {{-- AVATAR --}}
                    <div class="w-24 h-24 rounded-3xl bg-blue-100 dark:bg-blue-900 flex items-center justify-center flex-shrink-0">
                        <span class="text-4xl font-bold text-blue-600 dark:text-blue-300">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>

                    {{-- INFO --}}
                    <div class="flex-1 text-center sm:text-left">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $user->name }}
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-3">{{ $user->email }}</p>

                        {{-- ROLE BADGE --}}
                        @if($user->role === 'admin')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Admin
                            </span>
                        @elseif($user->role === 'manajer_gudang')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                Manajer Gudang
                            </span>
                        @elseif($user->role === 'staff_gudang')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-semibold bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                Staff Gudang
                            </span>
                        @endif

                        {{-- TOMBOL EDIT --}}
                        <div class="mt-5">
                            <a href="{{ route('users.edit', $user->id) }}"
                               class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-5 py-2.5 rounded-2xl font-semibold transition text-sm shadow-lg shadow-amber-500/20">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit User
                            </a>
                        </div>
                    </div>

                </div>

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                {{-- INFO DETAIL --}}
                <div class="p-8">
                    <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                        Informasi Akun
                    </h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Nama Lengkap</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->name }}</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Email</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->email }}</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Role</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white capitalize">
                                {{ str_replace('_', ' ', $user->role) }}
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <p class="text-xs text-gray-400 mb-1 font-medium">Bergabung Sejak</p>
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $user->created_at->format('d M Y') }}
                            </p>
                        </div>

                    </div>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700"></div>

                {{-- AKTIVITAS TERAKHIR --}}
                <div class="p-8">
                    <h4 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">
                        Aktivitas Terakhir
                    </h4>
                    @php
                        $activities = $user->activityLogs()->latest()->take(5)->get();
                    @endphp

                    @if($activities->isEmpty())
                        <p class="text-sm text-gray-400">Belum ada aktivitas tercatat.</p>
                    @else
                        <div class="space-y-2">
                            @foreach($activities as $log)
                                <div class="flex items-start justify-between py-3 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $log->activity }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $log->description }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400 whitespace-nowrap ml-4">
                                        {{ $log->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

</x-app-layout>