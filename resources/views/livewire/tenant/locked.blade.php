@php
    $featureTitle = match($feature ?? '') {
        'damage' => 'Laporan Kerusakan Fasilitas',
        'visitor' => 'Laporan Kunjungan Tamu',
        default => 'Riwayat Sewa & Bukti Pembayaran',
    };
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#F5EFE6]" style="color-scheme: light;">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Terkunci — One2Kost</title>
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#F5EFE6] text-[#5C402C] antialiased selection:bg-[#A67B5B] selection:text-[#FAF6EE]">

    <!-- HEADER PUBLIK -->
    <header class="sticky top-0 z-40 w-full bg-[#FAF6EE]/95 backdrop-blur-md border-b border-[#E2D6C3]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 shrink-0">
                <span class="text-base sm:text-xl font-extrabold tracking-tight text-[#5C402C] leading-none">
                    One<span class="text-[#A67B5B]">2Kost</span>
                </span>
            </a>

            <div class="flex items-center gap-2.5">
                <a href="{{ route('home') }}#katalog"
                   class="px-3.5 py-1.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0] hover:bg-[#EFE4D4] text-xs font-bold text-[#5C402C] transition">
                    Lihat Kamar
                </a>
                <a href="{{ route('login') }}"
                   class="px-3.5 py-1.5 rounded-lg bg-[#A67B5B] hover:bg-[#8F6547] text-xs font-bold text-[#FAF6EE] transition">
                    Masuk Akun
                </a>
            </div>
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex items-center justify-center px-4 py-8 pb-28">
        <div class="w-full max-w-md bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden shadow-xs">

            <!-- Header Card Warna Admin (#C29A78) -->
            <div class="px-5 py-3.5 bg-[#C29A78] text-[#FAF6EE] flex items-center justify-between gap-3">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#FAF6EE]/85 block">
                        Fitur Khusus Penyewa
                    </span>
                    <h1 class="text-sm sm:text-base font-extrabold text-[#FAF6EE] leading-snug mt-0.5">
                        Akses Terkunci
                    </h1>
                </div>

                <div class="w-9 h-9 rounded-lg bg-[#FAF6EE]/15 border border-[#FAF6EE]/25 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-[#FAF6EE]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>

            <!-- Body Card -->
            <div class="p-6 text-center space-y-4">
                <div class="relative w-20 h-20 mx-auto">
                    <div class="w-20 h-20 rounded-lg bg-[#EFE4D4] border border-[#DDD0BC] flex items-center justify-center text-[#8F6547]">
                        <svg class="w-9 h-9" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div class="absolute -bottom-1.5 -right-1.5 w-8 h-8 rounded-lg bg-[#A67B5B] text-[#FAF6EE] border-2 border-[#FAF6EE] flex items-center justify-center shadow-xs">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg font-extrabold text-[#5C402C] tracking-tight">
                        Silakan Login Terlebih Dahulu
                    </h2>
                    <p class="text-xs text-[#8F6547] mt-2 leading-relaxed">
                        Silakan Anda login terlebih dahulu untuk menggunakan fitur <strong class="text-[#5C402C]">{{ $featureTitle }}</strong> serta mengelola data hunian Anda di One2Kost.
                    </p>
                </div>

                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-2.5">
                    <a href="{{ route('login') }}"
                       class="w-full sm:w-auto px-5 py-2.5 rounded-lg bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] text-xs font-bold transition">
                        Masuk ke Akun
                    </a>
                    <a href="{{ route('home') }}"
                       class="w-full sm:w-auto px-4 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0] hover:bg-[#EFE4D4] text-[#5C402C] text-xs font-semibold transition">
                        Kembali ke Beranda
                    </a>
                </div>

                <div class="pt-3 border-t border-[#E8DEC9]">
                    <p class="text-xs text-[#9C785C]">
                        Belum punya akun penyewa?
                        <a href="{{ route('register') }}" class="font-bold text-[#5C402C] hover:text-[#A67B5B] underline underline-offset-2">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </main>

    <!-- Bottom Navigator Tetap Muncul di Bawah dengan Warna Seragam -->
    <x-bottom-nav />

</body>
</html>