<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F5EFE6]" style="color-scheme: light;">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Admin Dashboard' }} - Kost2Kost TMS</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body
    class="h-full flex overflow-hidden bg-[#F5EFE6] text-[#5C402C] antialiased selection:bg-[#A67B5B] selection:text-[#FAF6EE]"
    x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-[#5C402C]/40 backdrop-blur-xs lg:hidden"></div>

    <!-- Sidebar Navigation (Nuansa Cream & Coklat Muda) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-72 bg-[#FAF6EE] text-[#5C402C] flex flex-col transition-transform duration-200 ease-in-out lg:translate-x-0 lg:static lg:inset-0 border-r border-[#E2D6C3]">
        <!-- Brand Header -->
        <div class="h-20 px-6 flex items-center justify-between border-b border-[#E8DEC9] bg-[#F3ECE0]/60">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                <div>
                    <span class="text-lg font-extrabold text-[#5C402C] tracking-tight">Kost<span
                            class="text-[#A67B5B]">2Kost</span></span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden text-[#8F6547] hover:text-[#5C402C]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav
            class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto [scrollbar-width:thin] [scrollbar-color:rgba(166,123,91,0.35)_transparent] [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-[#A67B5B]/35 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-[#A67B5B]/65 [&::-webkit-scrollbar-button]:hidden">
            <div class="text-[11px] font-bold uppercase tracking-wider text-[#9C785C] px-3 mb-2">Menu Utama</div>

            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#A67B5B] text-[#FAF6EE] shadow-xs' : 'text-[#5C402C] hover:bg-[#EFE4D4] hover:text-[#5C402C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#FAF6EE]' : 'text-[#A67B5B]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Dashboard
            </a>

            <!-- Kamar -->
            @php
                $isRoomsRoute = request()->routeIs('admin.rooms*');
            @endphp
            <div x-data="{ openRooms: {{ $isRoomsRoute ? 'true' : 'false' }} }" class="space-y-1">
                <button type="button"
                    @click="openRooms = !openRooms"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition cursor-pointer {{ $isRoomsRoute ? 'bg-[#A67B5B] text-[#FAF6EE] shadow-xs' : 'text-[#5C402C] hover:bg-[#EFE4D4] hover:text-[#5C402C]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $isRoomsRoute ? 'text-[#FAF6EE]' : 'text-[#A67B5B]' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Manage Rooms</span>
                    </div>
                    <span class="w-5 h-5 flex items-center justify-center transition-transform duration-200 {{ $isRoomsRoute ? 'text-[#FAF6EE]' : 'text-[#8F6547]' }}"
                        :class="openRooms ? 'rotate-180' : ''">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div x-show="openRooms"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="pl-4 pt-1 pb-1 space-y-1">
                    
                    <a href="{{ route('admin.rooms') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('admin.rooms') ? 'font-bold text-[#8F6547] bg-[#EFE4D4]' : 'font-medium text-[#6E5F53] hover:text-[#5C402C] hover:bg-[#EFE4D4]/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('admin.rooms') ? 'bg-[#A67B5B]' : 'bg-[#B8A594]' }}"></span>
                        <span>Rooms</span>
                    </a>

                    <a href="{{ route('admin.rooms.facilities') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('admin.rooms.facilities') ? 'font-bold text-[#8F6547] bg-[#EFE4D4]' : 'font-medium text-[#6E5F53] hover:text-[#5C402C] hover:bg-[#EFE4D4]/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('admin.rooms.facilities') ? 'bg-[#A67B5B]' : 'bg-[#B8A594]' }}"></span>
                        <span>Fasilitas</span>
                    </a>

                    <a href="{{ route('admin.rooms.types') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('admin.rooms.types') ? 'font-bold text-[#8F6547] bg-[#EFE4D4]' : 'font-medium text-[#6E5F53] hover:text-[#5C402C] hover:bg-[#EFE4D4]/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('admin.rooms.types') ? 'bg-[#A67B5B]' : 'bg-[#B8A594]' }}"></span>
                        <span>Tipe Kamar</span>
                    </a>
                </div>
            </div>

            <!-- Penyewa, Masa Sewa & Antrian -->
            @php
                $isTenantsRoute = request()->routeIs('admin.tenants*');
            @endphp
            <div x-data="{ openTenants: {{ $isTenantsRoute ? 'true' : 'false' }} }" class="space-y-1">
                <button type="button"
                    @click="openTenants = !openTenants"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition cursor-pointer {{ $isTenantsRoute ? 'bg-[#A67B5B] text-[#FAF6EE] shadow-xs' : 'text-[#5C402C] hover:bg-[#EFE4D4] hover:text-[#5C402C]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $isTenantsRoute ? 'text-[#FAF6EE]' : 'text-[#A67B5B]' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span>Tenants Period</span>
                    </div>
                    <span class="w-5 h-5 flex items-center justify-center transition-transform duration-200 {{ $isTenantsRoute ? ' text-[#FAF6EE]' : ' text-[#8F6547]' }}"
                        :class="openTenants ? 'rotate-180' : ''">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div x-show="openTenants"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="pl-4 pt-1 pb-1 space-y-1">
                    
                    <a href="{{ route('admin.tenants.active') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('admin.tenants.active') || request()->routeIs('admin.tenants') ? 'font-bold text-[#8F6547] bg-[#EFE4D4]' : 'font-medium text-[#6E5F53] hover:text-[#5C402C] hover:bg-[#EFE4D4]/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('admin.tenants.active') || request()->routeIs('admin.tenants') ? 'bg-[#A67B5B]' : 'bg-[#B8A594]' }}"></span>
                        <span>Active Tenant</span>
                    </a>

                    <a href="{{ route('admin.tenants.accounts') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('admin.tenants.accounts') ? 'font-bold text-[#8F6547] bg-[#EFE4D4]' : 'font-medium text-[#6E5F53] hover:text-[#5C402C] hover:bg-[#EFE4D4]/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('admin.tenants.accounts') ? 'bg-[#A67B5B]' : 'bg-[#B8A594]' }}"></span>
                        <span>Akun Tenants</span>
                    </a>
                </div>
            </div>

            <!-- Verifikasi Pembayaran & Rekap Keuangan -->
            <a href="{{ route('admin.payments') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.payments') ? 'bg-[#A67B5B] text-[#FAF6EE] shadow-xs' : 'text-[#5C402C] hover:bg-[#EFE4D4] hover:text-[#5C402C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.payments') ? 'text-[#FAF6EE]' : 'text-[#A67B5B]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Invoices
            </a>

            <div class="text-[11px] font-bold uppercase tracking-wider text-[#9C785C] px-3 pt-4 mb-2">Operasional & Tamu
            </div>

            <!-- Laporan Kerusakan -->
            <a href="{{ route('admin.damages') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.damages') ? 'bg-[#A67B5B] text-[#FAF6EE] shadow-xs' : 'text-[#5C402C] hover:bg-[#EFE4D4] hover:text-[#5C402C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.damages') ? 'text-[#FAF6EE]' : 'text-[#A67B5B]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Maintenance Request
            </a>

            <!-- Laporan Kunjungan Tamu -->
            <a href="{{ route('admin.guests') }}"
                class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-semibold transition {{ request()->routeIs('admin.guests') ? 'bg-[#A67B5B] text-[#FAF6EE] shadow-xs' : 'text-[#5C402C] hover:bg-[#EFE4D4] hover:text-[#5C402C]' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.guests') ? 'text-[#FAF6EE]' : 'text-[#A67B5B]' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                </svg>
                Guest Visit Log
            </a>

            <div class="text-[11px] font-bold uppercase tracking-wider text-[#9C785C] px-3 pt-4 mb-2">Sistem & Konten
            </div>

            <!-- Settings (Dropdown Sub-bab: Banner Slider & Bank Account) -->
            @php
                $isSettingsRoute = request()->routeIs('admin.settings*');
            @endphp
            <div x-data="{ openSettings: {{ $isSettingsRoute ? 'true' : 'false' }} }" class="space-y-1">
                <button type="button"
                    @click="openSettings = !openSettings"
                    class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-semibold transition cursor-pointer {{ $isSettingsRoute ? 'bg-[#A67B5B] text-[#FAF6EE] shadow-xs' : 'text-[#5C402C] hover:bg-[#EFE4D4] hover:text-[#5C402C]' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ $isSettingsRoute ? 'text-[#FAF6EE]' : 'text-[#A67B5B]' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span>Settings</span>
                    </div>
                    <span class="w-5 h-5 flex items-center justify-center transition-transform duration-200 {{ $isSettingsRoute ? 'text-[#FAF6EE]' : 'text-[#8F6547]' }}"
                        :class="openSettings ? 'rotate-180' : ''">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>

                <div x-show="openSettings"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="pl-4 pt-1 pb-1 space-y-1">
                    
                    <a href="{{ route('admin.settings.banners') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('admin.settings.banners') || request()->routeIs('admin.settings') ? 'font-bold text-[#8F6547] bg-[#EFE4D4]' : 'font-medium text-[#6E5F53] hover:text-[#5C402C] hover:bg-[#EFE4D4]/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('admin.settings.banners') || request()->routeIs('admin.settings') ? 'bg-[#A67B5B]' : 'bg-[#B8A594]' }}"></span>
                        <span>Banner Slider</span>
                    </a>

                    <a href="{{ route('admin.settings.banks') }}"
                        class="flex items-center gap-3 px-3 py-2 rounded-lg text-xs transition {{ request()->routeIs('admin.settings.banks') ? 'font-bold text-[#8F6547] bg-[#EFE4D4]' : 'font-medium text-[#6E5F53] hover:text-[#5C402C] hover:bg-[#EFE4D4]/50' }}">
                        <span class="w-1.5 h-1.5 rounded-full shrink-0 {{ request()->routeIs('admin.settings.banks') ? 'bg-[#A67B5B]' : 'bg-[#B8A594]' }}"></span>
                        <span>Bank Account</span>
                    </a>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- Top Navigation Bar -->
        <header class="h-20 bg-[#FAF6EE] border-b border-[#E2D6C3] flex items-center justify-between px-6 z-20">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true"
                    class="lg:hidden p-2 text-[#8F6547] hover:bg-[#EFE4D4] rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!--  Notification Bell, Interactive Calendar & Account Avatar -->
            <div class="flex items-center gap-3">
                @livewire('admin.notification-bell')

                <!-- Interactive Calendar Dropdown -->
                <div class="relative" x-data="miniCalendar()" @click.outside="openCal = false">
                    <button type="button" @click="openCal = !openCal"
                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-full bg-[#F3ECE0] hover:bg-[#EFE4D4] border border-[#E2D6C3] text-xs font-semibold text-[#5C402C] transition cursor-pointer">
                        <svg class="w-4 h-4 text-[#A67B5B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span x-text="selectedLabel"></span>
                    </button>

                    <!-- Popup Kalender -->
                    <div x-show="openCal" x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 mt-2 w-72 rounded-2xl bg-[#FAF6EE] border border-[#E2D6C3] shadow-xl p-4 z-50 text-xs">
                        
                        <!-- Header Bulan & Navigasi -->
                        <div class="flex items-center justify-between mb-3">
                            <button type="button" @click="prevMonth()"
                                class="w-7 h-7 rounded-full border border-[#E2D6C3] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center cursor-pointer">
                                ‹
                            </button>
                            <span class="font-extrabold text-[#5C402C]" x-text="monthYearLabel"></span>
                            <button type="button" @click="nextMonth()"
                                class="w-7 h-7 rounded-full border border-[#E2D6C3] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center cursor-pointer">
                                ›
                            </button>
                        </div>

                        <!-- Nama Hari -->
                        <div class="grid grid-cols-7 gap-1 text-center text-[10px] font-bold text-[#9C785C] mb-1.5">
                            <span>Min</span>
                            <span>Sen</span>
                            <span>Sel</span>
                            <span>Rab</span>
                            <span>Kam</span>
                            <span>Jum</span>
                            <span>Sab</span>
                        </div>

                        <!-- Grid Tanggal -->
                        <div class="grid grid-cols-7 gap-1 text-center">
                            <template x-for="blank in blanks" :key="'b-' + blank">
                                <div class="h-7"></div>
                            </template>

                            <template x-for="day in daysInMonth" :key="day">
                                <button type="button" @click="selectDate(day)"
                                    class="h-7 w-7 mx-auto rounded-full flex items-center justify-center text-[11px] font-semibold transition cursor-pointer"
                                    :class="{
                                        'bg-[#A67B5B] text-[#FAF6EE] font-bold': isSelected(day),
                                        'border border-[#A67B5B] text-[#A67B5B] font-bold': !isSelected(day) && isToday(day),
                                        'text-[#5C402C] hover:bg-[#EFE4D4]': !isSelected(day) && !isToday(day)
                                    }"
                                    x-text="day">
                                </button>
                            </template>
                        </div>

                        <!-- Tombol Hari Ini -->
                        <div class="mt-3 pt-2.5 border-t border-[#E8DEC9] flex items-center justify-between">
                            <span class="text-[11px] text-[#8F6547]" x-text="fullSelectedLabel"></span>
                            <button type="button" @click="goToday()"
                                class="text-[11px] font-bold text-[#A67B5B] hover:text-[#5C402C] cursor-pointer">
                                Hari Ini
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Account Avatar (Huruf 'A' saja di sebelah kanan kalender) -->
                <div class="relative" x-data="{ openAccount: false }" @click.outside="openAccount = false">
                    <button type="button" @click="openAccount = !openAccount"
                        class="w-9 h-9 rounded-full bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] font-extrabold flex items-center justify-center text-sm shadow-xs transition cursor-pointer">
                        A
                    </button>

                    <!-- Dropdown Keluar -->
                    <div x-show="openAccount" x-cloak
                        x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                        class="absolute right-0 mt-2 w-36 rounded-xl bg-[#FAF6EE] border border-[#E2D6C3] shadow-lg p-1.5 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-bold text-[#9E4735] hover:bg-[#F9E6E2] transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body Content -->
        <main
            class="flex-1 overflow-y-auto p-6 md:p-8 bg-[#F5EFE6] [scrollbar-width:thin] [scrollbar-color:rgba(166,123,91,0.35)_transparent] [&::-webkit-scrollbar]:w-1.5 [&::-webkit-scrollbar-track]:bg-transparent [&::-webkit-scrollbar-thumb]:bg-[#A67B5B]/35 [&::-webkit-scrollbar-thumb]:rounded-full hover:[&::-webkit-scrollbar-thumb]:bg-[#A67B5B]/65 [&::-webkit-scrollbar-button]:hidden">
            {{ $slot }}
        </main>
    </div>

    <script>
        function miniCalendar() {
            const now = new Date();
            const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            const fullMonthNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            return {
                openCal: false,
                today: now,
                viewYear: now.getFullYear(),
                viewMonth: now.getMonth(),
                selectedDate: new Date(now.getFullYear(), now.getMonth(), now.getDate()),

                get monthYearLabel() {
                    return `${fullMonthNames[this.viewMonth]} ${this.viewYear}`;
                },
                get selectedLabel() {
                    const d = String(this.selectedDate.getDate()).padStart(2, '0');
                    const m = monthNames[this.selectedDate.getMonth()];
                    const y = this.selectedDate.getFullYear();
                    return `${d} ${m} ${y}`;
                },
                get fullSelectedLabel() {
                    const d = this.selectedDate.getDate();
                    const m = fullMonthNames[this.selectedDate.getMonth()];
                    const y = this.selectedDate.getFullYear();
                    return `${d} ${m} ${y}`;
                },
                get blanks() {
                    const firstDay = new Date(this.viewYear, this.viewMonth, 1).getDay();
                    return Array.from({ length: firstDay }, (_, i) => i + 1);
                },
                get daysInMonth() {
                    const total = new Date(this.viewYear, this.viewMonth + 1, 0).getDate();
                    return Array.from({ length: total }, (_, i) => i + 1);
                },
                prevMonth() {
                    if (this.viewMonth === 0) {
                        this.viewMonth = 11;
                        this.viewYear--;
                    } else {
                        this.viewMonth--;
                    }
                },
                nextMonth() {
                    if (this.viewMonth === 11) {
                        this.viewMonth = 0;
                        this.viewYear++;
                    } else {
                        this.viewMonth++;
                    }
                },
                selectDate(day) {
                    this.selectedDate = new Date(this.viewYear, this.viewMonth, day);
                },
                goToday() {
                    const t = new Date();
                    this.viewYear = t.getFullYear();
                    this.viewMonth = t.getMonth();
                    this.selectedDate = new Date(t.getFullYear(), t.getMonth(), t.getDate());
                },
                isToday(day) {
                    return this.today.getDate() === day &&
                        this.today.getMonth() === this.viewMonth &&
                        this.today.getFullYear() === this.viewYear;
                },
                isSelected(day) {
                    return this.selectedDate.getDate() === day &&
                        this.selectedDate.getMonth() === this.viewMonth &&
                        this.selectedDate.getFullYear() === this.viewYear;
                }
            }
        }
    </script>

    @livewireScripts
</body>

</html>