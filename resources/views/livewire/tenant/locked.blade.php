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
    <header class="sticky top-0 z-40 w-full bg-[#FAF6EE]/95 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between gap-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 shrink-0">
                <span class="text-base sm:text-xl font-extrabold tracking-tight text-[#5C402C] leading-none">
                    One<span class="text-[#A67B5B]">2Kost</span>
                </span>
            </a>

            <a href="{{ route('login') }}"
               class="px-4 py-1.5 rounded-lg bg-[#A67B5B] hover:bg-[#8F6547] text-xs font-bold text-[#FAF6EE] transition">
                Login
            </a>
        </div>
    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex items-center justify-center px-4 py-8 pb-24">
        <div class="w-full max-w-sm bg-[#FAF6EE] rounded-2xl px-6 py-8 text-center space-y-4 shadow-xs">

            <svg class="w-11 h-11 mx-auto text-[#8F6547]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>

            <div class="space-y-1">
                <h1 class="text-base font-extrabold text-[#5C402C]">Silakan Login</h1>
                <p class="text-xs text-[#8F6547]">
                    Login dulu untuk membuka {{ $featureTitle }}.
                </p>
            </div>

            <div class="pt-1">
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center w-full px-5 py-2.5 rounded-lg bg-[#A67B5B] hover:bg-[#8F6547] text-xs font-bold text-[#FAF6EE] transition">
                    Login Sekarang
                </a>
            </div>

        </div>
    </main>

    <x-bottom-nav />

</body>
</html>