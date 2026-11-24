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
    <title>Akses Terkunci - Kost2Kost TMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col items-center justify-center bg-[#F5EFE6] text-[#5C402C] px-4 pb-28 antialiased selection:bg-[#A67B5B] selection:text-[#FAF6EE]">

    <div class="w-full max-w-md bg-[#FAF6EE] rounded-3xl border border-[#E2D6C3] p-8 sm:p-10 text-center shadow-sm">
        
        <!-- Ilustrasi Gembok & Kunci -->
        <div class="relative w-24 h-24 mx-auto mb-6">
            <div class="w-24 h-24 rounded-full bg-[#EFE2D0] border border-[#DFD2BE] flex items-center justify-center text-[#8F6547]">
                <!-- Ikon Gembok Utama -->
                <svg class="w-11 h-11" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <!-- Badge Ikon Kunci Kecil -->
            <div class="absolute -bottom-1 -right-1 w-9 h-9 rounded-full bg-[#A67B5B] text-[#FAF6EE] border-2 border-[#FAF6EE] flex items-center justify-center shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>
        </div>

        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#EFE4D4] text-[#8F6547] mb-3">
            Fitur Khusus Penyewa
        </span>

        <h1 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">
            Silakan Login Terlebih Dahulu
        </h1>

        <p class="text-xs sm:text-sm text-[#8F6547] mt-2.5 leading-relaxed">
            Silakan Anda login terlebih dahulu untuk menggunakan fitur <strong class="text-[#5C402C]">{{ $featureTitle }}</strong> serta mengelola data hunian Anda di Kost2Kost.
        </p>

        <div class="mt-7 flex flex-col sm:flex-row items-center justify-center gap-3">
            <a href="{{ route('login') }}"
               class="w-full sm:w-auto px-6 py-2.5 rounded-full bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] text-xs sm:text-sm font-bold shadow-xs transition">
                Masuk ke Akun
            </a>
            <a href="{{ route('home') }}"
               class="w-full sm:w-auto px-5 py-2.5 rounded-full border border-[#DDD0BC] bg-[#F3ECE0] hover:bg-[#EFE4D4] text-[#5C402C] text-xs sm:text-sm font-semibold transition">
                Kembali ke Beranda
            </a>
        </div>

        <p class="text-xs text-[#9C785C] mt-6">
            Belum punya akun penyewa?
            <a href="{{ route('register') }}" class="font-bold text-[#5C402C] hover:text-[#A67B5B] underline underline-offset-2">
                Daftar sekarang
            </a>
        </p>
    </div>

    <!-- Bottom Navigator Tetap Muncul di Bawah -->
    <x-bottom-nav />

</body>
</html>