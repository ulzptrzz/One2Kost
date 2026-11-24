<div class="space-y-6">
    <!-- Top Header & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">Penghuni Aktif & Masa Sewa</h2>
            <p class="text-xs text-[#8F6547] mt-0.5">Total {{ $activeBookings->total() }} penghuni aktif terdaftar</p>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari penghuni atau no. kamar..."
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
    <div class="bg-[#FAF6EE] rounded-xl border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-6 py-3.5">Penyewa</th>
                        <th class="px-6 py-3.5">Kamar</th>
                        <th class="px-6 py-3.5">Masa Sewa</th>
                        <th class="px-6 py-3.5">Pembayaran</th>
                        <th class="px-6 py-3.5">Status Perpanjangan</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse ($activeBookings as $b)
                        <tr class="hover:bg-[#F3ECE0]/50 transition">
                            <!-- Penyewa -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <span class="font-bold text-[#5C402C] block text-xs sm:text-[13px]">{{ $b->user->name ?? '-' }}</span>
                                        <span class="text-[11px] text-[#8F6547] block">{{ $b->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kamar -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $b->room->room_number ?? '-' }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $b->room->room_type ?? '-' }} • Lt. {{ $b->room->floor ?? '-' }}</span>
                            </td>

                            <!-- Masa Sewa -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ optional($b->start_date)->format('d M Y') }} – {{ optional($b->end_date)->format('d M Y') }}</span>
                                <span class="text-[11px] text-[#8F6547] block">Durasi: {{ $b->duration_months }} Bulan</span>
                            </td>

                            <!-- Pembayaran -->
                            <td class="px-6 py-4">
                                @if (in_array($b->status, ['active', 'paid', 'confirmed', 'approved']) && $b->payment_scheme !== 'dp')
                                    <span class="font-bold text-[#5C402C] block">Lunas</span>
                                    <span class="text-[11px] text-[#8F6547] block">{{ $b->formatted_total_price ?? '-' }}</span>
                                @else
                                    <span class="font-bold text-[#5C402C] block">DP 50%</span>
                                    <span class="text-[11px] text-[#8F6547] block">Sisa: {{ $b->formatted_remaining_amount ?? '-' }}</span>
                                @endif
                            </td>

                            <!-- Status Perpanjangan -->
                            <td class="px-6 py-4">
                                @if ($b->renewal_status === 'renewing')
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                        Perpanjang
                                    </span>
                                @elseif ($b->renewal_status === 'moving_out')
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC]">
                                        Pindah
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]">
                                        Menunggu
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <button type="button" wire:click="updateRenewalStatus({{ $b->id }}, 'renewing')"
                                        class="p-1.5 rounded-lg text-[#5B8552] hover:bg-[#EBF2E6] transition cursor-pointer"
                                        title="Tandai Akan Perpanjang">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </button>
                                    <button type="button" wire:click="updateRenewalStatus({{ $b->id }}, 'moving_out')"
                                        class="p-1.5 rounded-lg text-[#9E4735] hover:bg-[#F9E6E2] transition cursor-pointer"
                                        title="Tandai Pindah / Checkout">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-[#9C785C] text-xs">
                                Belum ada penghuni aktif yang menempati kamar.
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
                <span>data dari <strong class="text-[#5C402C]">{{ $activeBookings->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($activeBookings->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $activeBookings->lastPage()); $page++)
                    @if ($page == $activeBookings->currentPage())
                        <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($activeBookings->hasMorePages())
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