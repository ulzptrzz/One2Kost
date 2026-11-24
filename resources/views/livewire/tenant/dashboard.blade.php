<div class="space-y-8">

    <!-- WELCOME GREETING -->
    <div class="bg-gradient-to-r from-[#5C402C] via-[#7A563C] to-[#8F6547] rounded-3xl p-6 sm:p-8 text-[#FAF6EE] shadow-sm relative overflow-hidden">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="px-3.5 py-1 rounded-full text-[11px] font-bold bg-[#FAF6EE]/15 backdrop-blur-md border border-[#FAF6EE]/20 uppercase tracking-wider text-[#F3ECE0]">
                    Akun Penyewa Resmi
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight mt-2.5 text-[#FAF6EE]">
                    Halo, {{ auth()->user()->name }} 👋
                </h2>
                <p class="text-xs sm:text-sm text-[#E6DBC9] mt-1 max-w-xl leading-relaxed">
                    Selamat datang di portal hunian Kost2Kost. Kelola masa sewa, status pembayaran, laporan kerusakan fasilitas, dan perizinan tamu Anda di sini.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}#katalog" class="px-5 py-2.5 rounded-full bg-[#FAF6EE] text-[#5C402C] font-bold text-xs sm:text-sm hover:bg-[#F3ECE0] shadow-xs transition">
                    Lihat Kamar Lain
                </a>
            </div>
        </div>
        <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-[#FAF6EE]/5 pointer-events-none"></div>
    </div>

    <!-- ⚠️ NOTIFIKASI SISA PEMBAYARAN DP -->
    @if($dpBookingPendingSettlement)
        <div class="p-6 rounded-3xl bg-[#F7ECD9] border-2 border-[#D49B4B] text-[#5C402C] shadow-xs">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-5">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-[#C2812E] text-[#FAF6EE] flex items-center justify-center shrink-0 shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#C2812E]/20 text-[#7A4D12] uppercase">Penting</span>
                            <h3 class="text-base sm:text-lg font-bold text-[#5C402C]">Perhatian: Anda Memiliki Sisa Tagihan Pelunasan</h3>
                        </div>
                        <p class="text-xs sm:text-sm text-[#7A563C] mt-1 leading-relaxed">
                            Pembayaran Down Payment (DP) untuk <strong>Kamar {{ $dpBookingPendingSettlement->room->room_number }}</strong> telah diterima. Mohon lunasi sisa tagihan sebesar <strong class="text-[#9E4735] font-extrabold text-base">{{ $dpBookingPendingSettlement->formatted_remaining_amount }}</strong> sebelum tanggal check-in ({{ $dpBookingPendingSettlement->start_date->format('d M Y') }}).
                        </p>
                    </div>
                </div>

                <div class="shrink-0">
                    <a href="{{ route('tenant.payments') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] font-bold text-xs sm:text-sm shadow-xs transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Upload Bukti Pelunasan Sekarang
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('renewal_message'))
        <div class="p-4 rounded-2xl bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs sm:text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>{{ session('renewal_message') }}</div>
        </div>
    @endif

    <!-- GRID INFORMASI SEWA AKTIF & STATISTIK -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- CARD KAMAR AKTIF SAYA -->
        <div class="lg:col-span-2 bg-[#FAF6EE] rounded-3xl border border-[#E2D6C3] p-6 sm:p-7 shadow-xs">
            <div class="flex items-center justify-between pb-5 border-b border-[#E8DEC9]">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-[#EFE4D4] text-[#8F6547] flex items-center justify-center font-bold">🏠</div>
                    <h3 class="text-base font-bold text-[#5C402C]">Informasi Kamar & Masa Sewa Saya</h3>
                </div>
                @if($activeBooking)
                    <span class="px-3 py-1 rounded-full text-xs font-bold {{ $activeBooking->status === 'active' ? 'bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]' : 'bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]' }}">
                        {{ $activeBooking->status_label }}
                    </span>
                @endif
            </div>

            @if($activeBooking)
                <div class="mt-6 flex flex-col sm:flex-row gap-6">
                    <!-- Room Image Preview -->
                    <div class="w-full sm:w-48 h-36 rounded-2xl overflow-hidden bg-[#EFE4D4] shrink-0 relative border border-[#E2D6C3]">
                        <img src="{{ $activeBooking->room->main_image_url }}" alt="Kamar" class="w-full h-full object-cover">
                        <span class="absolute bottom-2 left-2 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#2D231C]/80 text-[#FAF6EE]">
                            Lantai {{ $activeBooking->room->floor }}
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="flex-1 space-y-3">
                        <div>
                            <span class="text-xs font-bold text-[#A67B5B] uppercase tracking-wide">{{ $activeBooking->room->room_type }}</span>
                            <h4 class="text-lg font-extrabold text-[#5C402C]">{{ $activeBooking->room->name }} (No. {{ $activeBooking->room->room_number }})</h4>
                        </div>

                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="p-3 rounded-2xl bg-[#F3ECE0] border border-[#E2D6C3]">
                                <span class="text-[#8F6547] block text-[10px] uppercase font-bold">Tanggal Mulai</span>
                                <span class="font-bold text-[#5C402C]">{{ $activeBooking->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="p-3 rounded-2xl bg-[#F3ECE0] border border-[#E2D6C3]">
                                <span class="text-[#8F6547] block text-[10px] uppercase font-bold">Tanggal Berakhir</span>
                                <span class="font-bold text-[#5C402C]">{{ $activeBooking->end_date->format('d M Y') }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between text-xs pt-1 text-[#7A563C]">
                            <span>Durasi Sewa: <strong class="text-[#5C402C]">{{ $activeBooking->duration_months }} Bulan</strong></span>
                            <span>Skema: <strong class="text-[#5C402C]">{{ $activeBooking->payment_scheme === 'dp' ? 'DP 50%' : 'Lunas Penuh' }}</strong></span>
                        </div>
                    </div>
                </div>

                <!-- KONFIRMASI PERPANJANGAN SEWA -->
                <div class="mt-6 pt-5 border-t border-[#E8DEC9] bg-[#F3ECE0] rounded-2xl p-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold text-[#5C402C]">Status Rencana Sewa Mendatang:</p>
                            <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                                    {{ $activeBooking->renewal_status === 'renewing' ? 'bg-[#EBF2E6] text-[#3F5E30]' : ($activeBooking->renewal_status === 'moving_out' ? 'bg-[#F9E6E2] text-[#9E4735]' : 'bg-[#E6DBC9] text-[#5C402C]') }}">
                                    {{ $activeBooking->renewal_status_label }}
                                </span>
                                <span class="text-[11px] text-[#8F6547]">
                                    (Membantu penentuan antrian calon penghuni baru)
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button wire:click="confirmRenewal({{ $activeBooking->id }}, 'renewing')" 
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition cursor-pointer {{ $activeBooking->renewal_status === 'renewing' ? 'bg-[#5B8552] text-[#FAF6EE]' : 'bg-[#FAF6EE] border border-[#B5CCA8] text-[#3F5E30] hover:bg-[#EBF2E6]' }}">
                                ✓ Ingin Perpanjang
                            </button>
                            <button wire:click="confirmRenewal({{ $activeBooking->id }}, 'moving_out')" 
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition cursor-pointer {{ $activeBooking->renewal_status === 'moving_out' ? 'bg-[#9E4735] text-[#FAF6EE]' : 'bg-[#FAF6EE] border border-[#E0B5AC] text-[#9E4735] hover:bg-[#F9E6E2]' }}">
                                ✕ Rencana Pindah
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Active Booking -->
                <div class="py-12 text-center text-[#8F6547] space-y-3">
                    <div class="w-12 h-12 rounded-full bg-[#EFE4D4] mx-auto flex items-center justify-center text-[#8F6547]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-[#5C402C]">Anda belum memiliki kamar sewa aktif saat ini.</p>
                    <p class="text-xs text-[#8F6547] max-w-sm mx-auto">Silakan lihat katalog kamar kami untuk memilih kamar dan mengajukan sewa baru.</p>
                    <div class="pt-2">
                        <a href="{{ route('home') }}#katalog" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-xs font-bold hover:bg-[#8F6547] transition">
                            Cari Kamar Tersedia ↗
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- QUICK ACTION SHORTCUTS -->
        <div class="space-y-4">
            <!-- Shortcut Laporan Kerusakan -->
            <a href="{{ route('tenant.damages') }}" wire:navigate class="block p-5 rounded-3xl bg-[#FAF6EE] border border-[#E2D6C3] hover:border-[#A67B5B] hover:shadow-sm transition group">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-2xl bg-[#F9E6E2] text-[#9E4735] flex items-center justify-center group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-[#9C785C] group-hover:text-[#5C402C]">Form Lapor →</span>
                </div>
                <h4 class="text-sm font-bold text-[#5C402C] mt-3">Lapor Kerusakan Fasilitas</h4>
                <p class="text-xs text-[#8F6547] mt-1 leading-relaxed">AC mati, keran bocor, lampu putus? Laporkan dan pantau status perbaikannya.</p>
            </a>

            <!-- Shortcut Laporan Tamu -->
            <a href="{{ route('tenant.guests') }}" wire:navigate class="block p-5 rounded-3xl bg-[#FAF6EE] border border-[#E2D6C3] hover:border-[#A67B5B] hover:shadow-sm transition group">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-2xl bg-[#EFE4D4] text-[#8F6547] flex items-center justify-center group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-[#9C785C] group-hover:text-[#5C402C]">Catat Tamu →</span>
                </div>
                <h4 class="text-sm font-bold text-[#5C402C] mt-3">Laporan Kunjungan Tamu</h4>
                <p class="text-xs text-[#8F6547] mt-1 leading-relaxed">Form pelaporan teman/keluarga yang berkunjung malam atau menginap demi ketertiban bersama.</p>
            </a>

            <!-- Histori Pembayaran -->
            <a href="{{ route('tenant.payments') }}" wire:navigate class="block p-5 rounded-3xl bg-[#FAF6EE] border border-[#E2D6C3] hover:border-[#A67B5B] hover:shadow-sm transition group">
                <div class="flex items-center justify-between">
                    <div class="w-10 h-10 rounded-2xl bg-[#EBF2E6] text-[#5B8552] flex items-center justify-center group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <span class="text-xs font-bold text-[#9C785C] group-hover:text-[#5C402C]">Lihat Rekap →</span>
                </div>
                <h4 class="text-sm font-bold text-[#5C402C] mt-3">Histori & Bukti Pembayaran</h4>
                <p class="text-xs text-[#8F6547] mt-1 leading-relaxed">Lihat seluruh riwayat kwitansi, upload bukti transfer, dan status verifikasi admin.</p>
            </a>
        </div>
    </div>

    <!-- DAFTAR PENGAJUAN LAIN & STATUS ANTRIAN -->
    @if(count($waitingBookings) > 0)
        <div class="bg-[#FAF6EE] rounded-3xl border border-[#E2D6C3] p-6 sm:p-7 shadow-xs">
            <h3 class="text-base font-bold text-[#5C402C] mb-4 flex items-center gap-2">
                <span>📋</span> Status Pengajuan Sewa & Antrian (Waiting List) Anda
            </h3>

            <div class="divide-y divide-[#E8DEC9]">
                @foreach($waitingBookings as $wb)
                    <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-xs bg-[#EFE4D4] px-2.5 py-0.5 rounded-lg text-[#5C402C]">{{ $wb->booking_code }}</span>
                                <h4 class="font-bold text-sm text-[#5C402C]">{{ $wb->room->name }} (No. {{ $wb->room->room_number }})</h4>
                            </div>
                            <p class="text-xs text-[#8F6547] mt-1">
                                Rencana sewa: <strong class="text-[#5C402C]">{{ $wb->start_date->format('d M Y') }}</strong> s.d. <strong class="text-[#5C402C]">{{ $wb->end_date->format('d M Y') }}</strong> ({{ $wb->duration_months }} Bulan) • Total: <strong class="text-[#5C402C]">{{ $wb->formatted_total_price }}</strong>
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                {{ $wb->status === 'waiting_renewal_confirmation' ? 'bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]' : 'bg-[#EFE4D4] text-[#5C402C]' }}">
                                {{ $wb->status_label }}
                            </span>

                            @if($wb->status === 'pending_payment')
                                <a href="{{ route('tenant.payments') }}" wire:navigate class="px-4 py-1.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-xs font-bold hover:bg-[#8F6547] transition">
                                    Bayar Sekarang
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>