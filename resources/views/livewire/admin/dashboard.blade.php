<div class="space-y-6">

    <!-- BARIS 1: 4 TOP KPI CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Card 1: Total Kamar -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <div class="text-xl font-extrabold text-[#5C402C] leading-tight">
                        {{ $occupiedRooms }} <span class="text-sm font-semibold text-[#8F6547]">/ {{ $totalRooms }}</span>
                    </div>
                    <p class="text-xs font-medium text-[#8F6547] mt-0.5">Kamar Terisi</p>
                </div>
                <div class="w-8 h-8 rounded-md bg-[#EFE4D4] text-[#8F6547] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#E8DEC9] flex items-center justify-between text-[11px]">
                <span class="font-semibold text-[#3F5E30]">{{ $availableRooms }} kamar tersedia</span>
                <a href="{{ route('admin.rooms') }}" class="text-[#A67B5B] hover:underline font-semibold">Detail</a>
            </div>
        </div>

        <!-- Card 2: Pendapatan Bulan Ini -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div class="min-w-0">
                    <div class="text-xl font-extrabold text-[#5C402C] leading-tight truncate">
                        Rp {{ number_format($currentMonthRevenue, 0, ',', '.') }}
                    </div>
                    <p class="text-xs font-medium text-[#8F6547] mt-0.5">Pendapatan Bulan Ini</p>
                </div>
                <div class="w-8 h-8 rounded-md bg-[#EBF2E6] text-[#3F5E30] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#E8DEC9] flex items-center justify-between text-[11px]">
                <span class="text-[#8F6547]">Total kas: <strong class="text-[#5C402C]">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</strong></span>
            </div>
        </div>

        <!-- Card 3: Verifikasi & Sisa DP -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <div class="text-xl font-extrabold text-[#C2812E] leading-tight">
                        {{ $pendingPaymentsCount }}
                    </div>
                    <p class="text-xs font-medium text-[#8F6547] mt-0.5">Menunggu Verifikasi</p>
                </div>
                <div class="w-8 h-8 rounded-md bg-[#F7ECD9] text-[#8A5A19] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#E8DEC9] flex items-center justify-between text-[11px]">
                <span class="text-[#8F6547]">{{ $unpaidDpBookings->count() }} penyewa belum lunas DP</span>
                <a href="{{ route('admin.payments') }}" class="text-[#A67B5B] hover:underline font-semibold">Cek</a>
            </div>
        </div>

        <!-- Card 4: Masa Sewa Hampir Habis & Kerusakan -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] p-4 flex flex-col justify-between">
            <div class="flex items-start justify-between gap-2">
                <div>
                    <div class="text-xl font-extrabold text-[#9E4735] leading-tight">
                        {{ $expiringBookings->count() }}
                    </div>
                    <p class="text-xs font-medium text-[#8F6547] mt-0.5">Sewa Segera Berakhir</p>
                </div>
                <div class="w-8 h-8 rounded-md bg-[#F9E6E2] text-[#9E4735] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="mt-3 pt-2.5 border-t border-[#E8DEC9] flex items-center justify-between text-[11px]">
                <span class="text-[#9E4735] font-medium">{{ $pendingDamagesCount }} laporan kerusakan aktif</span>
                <a href="{{ route('admin.damages') }}" class="text-[#A67B5B] hover:underline font-semibold">Lihat</a>
            </div>
        </div>

    </div>

    <!-- BARIS 2: BELUM MELUNASI SISA DP & MASA SEWA SEGERA BERAKHIR (Seragam & Rapi) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Kiri: Belum Melunasi Sisa DP -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden flex flex-col">
            <div class="px-5 py-3.5 border-b border-[#E8DEC9] flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-bold text-[#5C402C]">Belum Melunasi Sisa DP</h3>
                        @if($unpaidDpBookings->count() > 0)
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-[#9E4735] text-[#FAF6EE]">
                                {{ $unpaidDpBookings->count() }}
                            </span>
                        @endif
                    </div>
                    <p class="text-[11px] text-[#8F6547] mt-0.5">Penyewa skema DP yang masih memiliki sisa tagihan</p>
                </div>
                <a href="{{ route('admin.payments') }}" class="text-xs font-semibold text-[#8F6547] hover:text-[#5C402C] underline shrink-0">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-[#E8DEC9] flex-1">
                @forelse($unpaidDpBookings as $dp)
                    <div class="px-5 py-3.5 flex items-center justify-between gap-4 hover:bg-[#F3ECE0]/50 transition">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-xs text-[#5C402C] truncate">{{ $dp->user->name ?? '-' }}</span>
                                <span class="px-1.5 py-0.5 rounded bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC] font-mono font-bold text-[10px] shrink-0">
                                    {{ $dp->room->room_number ?? '-' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-[#8F6547] mt-1 truncate">
                                <span class="font-mono text-[#7A563C]">{{ $dp->booking_code }}</span>
                                <span class="mx-1">•</span>
                                Mulai {{ $dp->start_date ? $dp->start_date->format('d M Y') : '-' }}
                            </p>
                        </div>

                        <div class="text-right shrink-0">
                            <span class="font-extrabold text-xs text-[#9E4735] block whitespace-nowrap">
                                Rp {{ number_format($dp->remaining_amount, 0, ',', '.') }}
                            </span>
                            <span class="inline-block mt-1 px-2 py-0.5 rounded text-[10px] font-bold bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC] whitespace-nowrap">
                                Belum Lunas
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-10 px-5 text-center text-[#9C785C] text-xs">
                        Tidak ada penyewa dengan tunggakan pelunasan DP.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Kanan: Masa Sewa Segera Berakhir -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden flex flex-col">
            <div class="px-5 py-3.5 border-b border-[#E8DEC9] flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-2">
                        <h3 class="text-sm font-bold text-[#5C402C]">Masa Sewa Segera Berakhir</h3>
                        @if($expiringBookings->count() > 0)
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-bold bg-[#C2812E] text-[#FAF6EE]">
                                {{ $expiringBookings->count() }}
                            </span>
                        @endif
                    </div>
                    <p class="text-[11px] text-[#8F6547] mt-0.5">Kontrak kamar berakhir dalam 30 hari ke depan</p>
                </div>
                <a href="{{ route('admin.tenants') }}" class="text-xs font-semibold text-[#8F6547] hover:text-[#5C402C] underline shrink-0">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-[#E8DEC9] flex-1">
                @forelse($expiringBookings as $exp)
                    @php
                        $daysLeft = (int) now()->startOfDay()->diffInDays($exp->end_date->startOfDay(), false);
                    @endphp
                    <div class="px-5 py-3.5 flex items-center justify-between gap-4 hover:bg-[#F3ECE0]/50 transition">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-bold text-xs text-[#5C402C] truncate">{{ $exp->user->name ?? '-' }}</span>
                                <span class="px-1.5 py-0.5 rounded bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC] font-mono font-bold text-[10px] shrink-0">
                                    {{ $exp->room->room_number ?? '-' }}
                                </span>
                            </div>
                            <p class="text-[11px] text-[#8F6547] mt-1">
                                Berakhir: <strong class="text-[#5C402C]">{{ $exp->end_date->format('d M Y') }}</strong>
                                <span class="mx-1">•</span>
                                @if($exp->renewal_status === 'renewing')
                                    <span class="text-[#3F5E30] font-semibold">Akan Perpanjang</span>
                                @elseif($exp->renewal_status === 'moving_out')
                                    <span class="text-[#9E4735] font-semibold">Akan Pindah</span>
                                @else
                                    <span class="text-[#8A5A19]">Belum Konfirmasi</span>
                                @endif
                            </p>
                        </div>

                        <div class="text-right shrink-0">
                            @if($daysLeft < 0)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#9E4735] text-[#FAF6EE] whitespace-nowrap">
                                    Lewat {{ abs($daysLeft) }} hari
                                </span>
                            @elseif($daysLeft === 0)
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#9E4735] text-[#FAF6EE] whitespace-nowrap">
                                    Berakhir Hari Ini
                                </span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898] whitespace-nowrap">
                                    {{ $daysLeft }} hari lagi
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-10 px-5 text-center text-[#9C785C] text-xs">
                        Tidak ada masa sewa yang berakhir dalam 30 hari ke depan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- BARIS 3: PEMBAYARAN TERBARU & LAPORAN KERUSAKAN -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Pembayaran Masuk Terbaru -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden flex flex-col">
            <div class="px-5 py-3.5 border-b border-[#E8DEC9] flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#5C402C]">Pembayaran Masuk Terbaru</h3>
                    <p class="text-[11px] text-[#8F6547] mt-0.5">Bukti transfer yang baru diunggah penyewa</p>
                </div>
                <a href="{{ route('admin.payments') }}" class="text-xs font-semibold text-[#8F6547] hover:text-[#5C402C] underline shrink-0">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-[#E8DEC9] flex-1">
                @forelse($recentPayments as $p)
                    <div class="px-5 py-3.5 flex items-center justify-between gap-4 hover:bg-[#F3ECE0]/50 transition">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-xs text-[#5C402C] whitespace-nowrap">{{ $p->formatted_amount }}</span>
                                <span class="text-[11px] text-[#8F6547] truncate">({{ $p->payment_type_label }})</span>
                            </div>
                            <p class="text-[11px] text-[#8F6547] mt-0.5 truncate">
                                {{ $p->user->name ?? 'Penyewa' }} • Kamar {{ $p->booking->room->room_number ?? '-' }}
                            </p>
                        </div>

                        <div class="shrink-0">
                            @if($p->status === 'approved')
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA] whitespace-nowrap">Diterima</span>
                            @elseif($p->status === 'pending')
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898] whitespace-nowrap">Perlu Verifikasi</span>
                            @else
                                <span class="px-2 py-0.5 rounded text-[11px] font-bold bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC] whitespace-nowrap">Ditolak</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-10 px-5 text-center text-[#9C785C] text-xs">
                        Belum ada transaksi pembayaran masuk.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Laporan Kerusakan Fasilitas -->
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden flex flex-col">
            <div class="px-5 py-3.5 border-b border-[#E8DEC9] flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#5C402C]">Laporan Kerusakan Fasilitas</h3>
                    <p class="text-[11px] text-[#8F6547] mt-0.5">Komplain fasilitas aktif yang perlu ditangani</p>
                </div>
                <a href="{{ route('admin.damages') }}" class="text-xs font-semibold text-[#8F6547] hover:text-[#5C402C] underline shrink-0">
                    Lihat Semua
                </a>
            </div>

            <div class="divide-y divide-[#E8DEC9] flex-1">
                @forelse($recentDamages as $d)
                    <div class="px-5 py-3.5 flex items-center justify-between gap-4 hover:bg-[#F3ECE0]/50 transition">
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-xs text-[#5C402C] truncate">{{ $d->facility_name }}</span>
                                <span class="text-[11px] text-[#8F6547] shrink-0">• Kamar {{ $d->room->room_number ?? '-' }}</span>
                            </div>
                            <p class="text-[11px] text-[#7A563C] mt-0.5 truncate">{{ $d->description }}</p>
                        </div>

                        <div class="shrink-0">
                            <span class="px-2 py-0.5 rounded text-[11px] font-bold whitespace-nowrap {{ $d->status === 'in_progress' ? 'bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]' : 'bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC]' }}">
                                {{ $d->status_label }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="py-10 px-5 text-center text-[#9C785C] text-xs">
                        Tidak ada laporan kerusakan aktif.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

</div>