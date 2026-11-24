<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#F5EFE6] h-full overflow-hidden">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Kost2Kost' }} — Hunian Kost Nyaman</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
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
    class="h-screen overflow-hidden flex flex-col bg-[#F5EFE6] text-[#2D231C] antialiased selection:bg-[#A67B5B] selection:text-white">

    <!-- Header Diam di Atas (Scrollbar Tidak Naik ke Sini) -->
    <header class="shrink-0 z-40 w-full bg-[#FAF6EE]/95 backdrop-blur-md border-b border-[#E6DBC9]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 group shrink-0">
                <span class="text-xl font-extrabold tracking-tight text-[#2D231C] leading-none">
                    Kost<span class="text-[#A67B5B]">2Kost</span>
                </span>
            </a>

            <!-- Search Bar di Kanan -->
            <div x-data="{ keyword: '' }" class="relative flex-1 max-w-xs sm:max-w-sm md:max-w-md">
                <span class="absolute inset-y-0 left-3.5 flex items-center text-[#8C7D70] pointer-events-none">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text"
                       x-model="keyword"
                       @input.debounce.300ms="
                           window.dispatchEvent(new CustomEvent('update-room-search', { detail: keyword }));
                           const container = document.getElementById('main-scroll');
                           if (keyword.length > 0 && container && container.scrollTop < 300) {
                               document.getElementById('katalog')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
                           }
                       "
                       placeholder="Cari kamar..."
                       class="w-full pl-9 pr-8 py-2 rounded-2xl border border-[#DDD0BC] bg-[#F3ECE0] text-xs sm:text-sm text-[#2D231C] placeholder-[#8C7D70] focus:bg-[#FAF6EE] focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B] outline-none transition">
                <button type="button"
                        x-show="keyword.length > 0"
                        x-cloak
                        @click="keyword = ''; window.dispatchEvent(new CustomEvent('update-room-search', { detail: '' }))"
                        aria-label="Hapus pencarian"
                        class="absolute inset-y-0 right-3 flex items-center text-[#8C7D70] hover:text-[#2D231C]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <!-- Area Scroll Mulai Tepat di Bawah Header -->
    <div id="main-scroll"
         x-data="{ showScrollTop: false }"
         @scroll="showScrollTop = ($el.scrollTop > 350)"
         class="flex-1 overflow-y-auto scroll-smooth flex flex-col
                [&::-webkit-scrollbar]:w-2
                [&::-webkit-scrollbar-track]:bg-[#F3ECE0]
                [&::-webkit-scrollbar-thumb]:bg-[#C9B49A]
                [&::-webkit-scrollbar-thumb]:rounded-full
                [&::-webkit-scrollbar-thumb]:border-2
                [&::-webkit-scrollbar-thumb]:border-[#F3ECE0]
                hover:[&::-webkit-scrollbar-thumb]:bg-[#A67B5B]">

        <!-- Page Body -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <!-- Footer -->
        <footer id="kontak" class="bg-[#EDE3D4] text-[#6E5F53] border-t border-[#DFD2BE] mt-10 pt-10 pb-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between gap-10">
                    <!-- Kiri: Brand & Deskripsi -->
                    <div class="space-y-3 max-w-sm">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl font-bold text-[#2D231C] tracking-tight">Kost<span class="text-[#A67B5B]">2Kost</span></span>
                        </div>
                        <p class="text-xs text-[#6E5F53] leading-relaxed">
                            Platform penyewaan kost dengan cek jadwal kamar langsung, opsi DP 50%, dan pengelolaan tagihan bulanan yang rapi.
                        </p>
                    </div>

                    <!-- Kanan: 2 Kolom Informasi Berjarak -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 sm:gap-12 lg:gap-16">
                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-[#2D231C] mb-3">Tipe Kamar Favorit</h4>
                            <ul class="space-y-2 text-xs">
                                <li><span class="text-[#2D231C] font-medium">Standard Room</span> — Mulai Rp 1,4 jt / bln</li>
                                <li><span class="text-[#2D231C] font-medium">Deluxe Room</span> — Mulai Rp 1,8 jt / bln</li>
                                <li><span class="text-[#2D231C] font-medium">VIP Room</span> — Mulai Rp 2,5 jt / bln</li>
                            </ul>
                        </div>

                        <div>
                            <h4 class="text-xs font-bold uppercase tracking-wider text-[#2D231C] mb-3">Kontak & Lokasi</h4>
                            <ul class="space-y-2 text-xs text-[#6E5F53]">
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-[#A67B5B] mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>Jl. Percetakan Negara Raya No. 45, Jakarta Pusat</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#A67B5B] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>WhatsApp: 0812-3456-7890</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#A67B5B] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span>Email: pengelola@kost2kost.com</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-[#DFD2BE] text-center text-[11px] text-[#8C7D70] flex flex-col sm:flex-row justify-between items-center gap-2">
                    <p>&copy; {{ date('Y') }} Kost2Kost. Hak cipta dilindungi.</p>
                    <p>Sistem Pengelolaan Hunian Kost</p>
                </div>
            </div>
        </footer>

        <!-- TOMBOL SCROLL KE ATAS -->
        <div class="fixed bottom-20 sm:bottom-5 right-4 sm:right-6 z-50">
            <button x-show="showScrollTop"
                    x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2 scale-90"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-2 scale-90"
                    @click="document.getElementById('main-scroll').scrollTo({ top: 0, behavior: 'smooth' })"
                    aria-label="Kembali ke atas"
                    class="w-11 h-11 rounded-full bg-[#FAF6EE]/95 border border-[#DFD2BE] text-[#8F6547] hover:bg-[#A67B5B] hover:text-[#FAF6EE] hover:border-[#A67B5B] shadow-md shadow-[#2D231C]/10 flex items-center justify-center transition-colors duration-200 cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 15l7-7 7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <x-bottom-nav />

    @livewireScripts
</body>

</html>