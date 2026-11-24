<div class="space-y-6">
    <!-- Top Header & Search (Selaras dengan Manage guest$guests) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">Guest Visit Log</h2>
            <p class="text-xs text-[#8F6547] mt-0.5">Total {{ $guests->total() }} laporan kunjungan tamu tercatat</p>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari tamu, penyewa, atau kamar..."
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

    <!-- Card Tabel Kunjungan Tamu -->
    <div class="bg-[#FAF6EE] rounded-2xl border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-6 py-3.5">Tamu</th>
                        <th class="px-6 py-3.5">Kamar & Penyewa</th>
                        <th class="px-6 py-3.5">Waktu Kunjungan</th>
                        <th class="px-6 py-3.5">Durasi & Keperluan</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse ($guests as $g)
                        <tr class="hover:bg-[#F3ECE0]/50 transition">
                            <!-- Tamu & Hubungan / Kontak -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <span class="font-bold text-[#5C402C] block text-xs sm:text-[13px]">{{ $g->guest_name }}</span>
                                        <span class="text-[11px] text-[#8F6547] block">
                                            {{ $g->relationship }}{{ $g->guest_phone ? ' • ' . $g->guest_phone : '' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kamar & Penyewa -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">Kamar {{ $g->room->room_number ?? '-' }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $g->user->name ?? '-' }}</span>
                            </td>

                            <!-- Waktu Kunjungan -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-bold text-[#5C402C] block">{{ $g->visit_date ? $g->visit_date->format('d M Y') : '-' }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $g->visit_time ?: '-' }}</span>
                            </td>

                            <!-- Durasi & Keperluan -->
                            <td class="px-6 py-4 max-w-xs">
                                <span class="font-bold text-[#5C402C] block">{{ $g->duration }}</span>
                                <p class="text-[11px] text-[#8F6547] line-clamp-1 mt-0.5">{{ $g->purpose }}</p>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if ($g->status === 'acknowledged')
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA] whitespace-nowrap">
                                        Dikonfirmasi
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898] whitespace-nowrap">
                                        Tercatat
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right">
                                @if ($g->status !== 'acknowledged')
                                    <button type="button" wire:click="acknowledge({{ $g->id }})"
                                        class="px-3 py-1 rounded-lg bg-[#A67B5B] text-[#FAF6EE] hover:bg-[#8F6547] font-bold text-[11px] transition cursor-pointer whitespace-nowrap">
                                        Konfirmasi
                                    </button>
                                @else
                                    <span class="inline-flex items-center justify-center p-1.5 text-[#5B8552]" title="Sudah Dikonfirmasi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-[#9C785C] text-xs">
                                Belum ada laporan kunjungan tamu yang tercatat.
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
                <span>data dari <strong class="text-[#5C402C]">{{ $guests->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($guests->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $guests->lastPage()); $page++)
                    @if ($page == $guests->currentPage())
                        <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($guests->hasMorePages())
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