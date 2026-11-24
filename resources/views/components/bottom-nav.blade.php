<nav aria-label="Navigasi Utama Kost2Kost"
    class="fixed bottom-4 left-1/2 -translate-x-1/2 z-50 w-[94%] max-w-lg bg-[#FAF6EE]/95 backdrop-blur-md border border-[#DFD2BE] rounded-full px-2.5 py-1.5 shadow-lg shadow-[#2D231C]/15">
    <div class="grid grid-cols-6 gap-1 items-center justify-items-center">

        <!-- 1. Dashboard (Ke Landing Page) -->
        <a href="{{ route('home') }}"
            class="group flex flex-col items-center justify-center w-10 h-10 sm:w-14 sm:h-14 rounded-full transition-all duration-300 text-[#8F6547]/75 hover:bg-[#EFE2D0]/70 hover:text-[#8F6547]">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none"
                stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span
                class="text-[10px] font-bold tracking-tight overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover:max-h-4 group-hover:opacity-100 group-hover:mt-0.5">
                Dashboard
            </span>
        </a>

        <!-- 2. Kamar (Ke Katalog Landing Page) -->
        <a href="{{ route('home') }}#katalog"
            class="group flex flex-col items-center justify-center w-10 h-10 sm:w-14 sm:h-14 rounded-full transition-all duration-300 text-[#8F6547]/75 hover:bg-[#EFE2D0]/70 hover:text-[#8F6547]">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0 transition-transform duration-300 group-hover:-translate-y-0.5"
                fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span
                class="hidden sm:block text-[10px] font-bold tracking-tight overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover:max-h-4 group-hover:opacity-100 group-hover:mt-0.5">
                Kamar
            </span>
        </a>

        <!-- 3. History (Informasi Kamar, Masa Sewa & Bukti Pembayaran) -->
        <a href="{{ auth()->check() ? route('tenant.history') : route('tenant.locked', ['feature' => 'history']) }}"
            class="group flex flex-col items-center justify-center w-14 h-14 rounded-full transition-all duration-300 {{ request()->routeIs('tenant.history') || request()->routeIs('tenant.payments') || request()->routeIs('tenant.dashboard') || (request()->routeIs('tenant.locked') && request('feature') === 'history') ? 'bg-[#EFE2D0] text-[#8F6547]' : 'text-[#8F6547]/75 hover:bg-[#EFE2D0]/70 hover:text-[#8F6547]' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none"
                stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span
                class="text-[10px] font-bold tracking-tight overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover:max-h-4 group-hover:opacity-100 group-hover:mt-0.5">
                History
            </span>
        </a>

        <!-- 4. Damage (Laporan Kerusakan) -->
        <a href="{{ auth()->check() ? route('tenant.damages') : route('tenant.locked', ['feature' => 'damage']) }}"
            class="group flex flex-col items-center justify-center w-14 h-14 rounded-full transition-all duration-300 {{ request()->routeIs('tenant.damages') || (request()->routeIs('tenant.locked') && request('feature') === 'damage') ? 'bg-[#EFE2D0] text-[#8F6547]' : 'text-[#8F6547]/75 hover:bg-[#EFE2D0]/70 hover:text-[#8F6547]' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none"
                stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span
                class="text-[10px] font-bold tracking-tight overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover:max-h-4 group-hover:opacity-100 group-hover:mt-0.5">
                Damage
            </span>
        </a>

        <!-- 5. Visitor (Laporan Kunjungan Tamu) -->
        <a href="{{ auth()->check() ? route('tenant.guests') : route('tenant.locked', ['feature' => 'visitor']) }}"
            class="group flex flex-col items-center justify-center w-14 h-14 rounded-full transition-all duration-300 {{ request()->routeIs('tenant.guests') || (request()->routeIs('tenant.locked') && request('feature') === 'visitor') ? 'bg-[#EFE2D0] text-[#8F6547]' : 'text-[#8F6547]/75 hover:bg-[#EFE2D0]/70 hover:text-[#8F6547]' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none"
                stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span
                class="text-[10px] font-bold tracking-tight overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover:max-h-4 group-hover:opacity-100 group-hover:mt-0.5">
                Visitor
            </span>
        </a>

        <!-- 6. Login / Logout -->
        @auth
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit"
                    class="group flex flex-col items-center justify-center w-14 h-14 rounded-full transition-all duration-300 text-[#9E4735]/80 hover:bg-[#F7E5DF] hover:text-[#9E4735] cursor-pointer">
                    <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:-translate-y-0.5"
                        fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span
                        class="text-[10px] font-bold tracking-tight overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover:max-h-4 group-hover:opacity-100 group-hover:mt-0.5">
                        Keluar
                    </span>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}"
                class="group flex flex-col items-center justify-center w-14 h-14 rounded-full transition-all duration-300 text-[#8F6547]/75 hover:bg-[#EFE2D0]/70 hover:text-[#8F6547]">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:-translate-y-0.5" fill="none"
                    stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span
                    class="text-[10px] font-bold tracking-tight overflow-hidden transition-all duration-300 max-h-0 opacity-0 group-hover:max-h-4 group-hover:opacity-100 group-hover:mt-0.5">
                    Masuk
                </span>
            </a>
        @endauth

    </div>
</nav>
