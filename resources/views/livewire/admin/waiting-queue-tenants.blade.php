<div class="space-y-6">
    <!-- Top Header & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">Antrian Calon Penyewa</h2>
            <p class="text-xs text-[#8F6547] mt-0.5">Total {{ $waitingBookings->total() }} antrian calon penghuni terdaftar</p>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari kode, nama, atau kamar..."
                class="w-full pl-9 pr-4 py-2 rounded-full bg-[#FAF6EE] border border-[#E2D6C3] text-xs text-[#5C402C] placeholder-[#9C785C] focus:outline-none focus:border-[#A67B5B]">
            <svg class="w-4 h-4 text-[#9C785C] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="px-4 py-3 rounded-xl bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Card Tabel -->
    <div class="bg-[#FAF6EE] rounded-2xl border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-6 py-3.5">Calon Penyewa</th>
                        <th class="px-6 py-3.5">Kamar & Kode</th>
                        <th class="px-6 py-3.5">Rencana Masuk</th>
                        <th class="px-6 py-3.5">Total Biaya</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse($waitingBookings as $wb)
                        @php
                            $initials = collect(explode(' ', $wb->user->name ?? 'C'))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('');
                        @endphp
                        <tr class="hover:bg-[#F3ECE0]/50 transition">
                            <!-- Calon Penyewa -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#EFE4D4] border border-[#E2D6C3] text-[#8F6547] font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-[#5C402C] block text-xs sm:text-[13px]">{{ $wb->user->name }}</span>
                                        <span class="text-[11px] text-[#8F6547] block">{{ $wb->user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kamar & Kode -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $wb->room->room_number }} • {{ $wb->room->room_type }}</span>
                                <span class="text-[11px] font-mono text-[#8F6547] block">{{ $wb->booking_code }}</span>
                            </td>

                            <!-- Rencana Masuk -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $wb->start_date->format('d M Y') }}</span>
                                <span class="text-[11px] text-[#8F6547] block">Durasi: {{ $wb->duration_months }} Bulan</span>
                            </td>

                            <!-- Total Biaya -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $wb->formatted_total_price }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $wb->payment_scheme === 'dp' ? 'Skema DP 50%' : 'Bayar Lunas' }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]">
                                    Antrian
                                </span>
                            </td>

                            <!-- Aksi Ikon Minimalis -->
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <button type="button" wire:click="approveQueueBooking({{ $wb->id }})"
                                        class="p-1.5 rounded-lg text-[#5B8552] hover:bg-[#EBF2E6] transition cursor-pointer"
                                        title="Setujui & Buka Pembayaran">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                    <button type="button" wire:click="cancelBooking({{ $wb->id }})"
                                        wire:confirm="Batalkan pengajuan antrian ini?"
                                        class="p-1.5 rounded-lg text-[#9E4735] hover:bg-[#F9E6E2] transition cursor-pointer"
                                        title="Batalkan Antrian">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-[#9C785C] text-xs">
                                Tidak ada antrian calon penyewa yang menunggu saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer Pagination -->
         <div class="px-5 py-3 border-t border-[#E8DEC9] bg-[#F3ECE0]/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2 text-[#7A563C]">
                <span>Tampilkan</span>
                <select wire:model.live="perPage" class="px-2.5 py-1 rounded-md border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] font-bold text-xs outline-none focus:ring-2 focus:ring-[#A67B5B] cursor-pointer">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>data dari <strong class="text-[#5C402C]">{{ $waitingBookings->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($waitingBookings->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $waitingBookings->lastPage()); $page++)
                    @if ($page == $waitingBookings->currentPage())
                        <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($waitingBookings->hasMorePages())
                    <button wire:click="nextPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                @else
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>