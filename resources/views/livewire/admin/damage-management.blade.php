<div class="space-y-6">
    <!-- Top Header & Search -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">Maintenance Request</h2>
            <p class="text-xs text-[#8F6547] mt-0.5">laporan kerusakan terdaftar</p>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari fasilitas, penyewa, atau kamar..."
                class="w-full pl-9 pr-4 py-2 rounded-full bg-[#FAF6EE] border border-[#E2D6C3] text-xs text-[#5C402C] placeholder-[#9C785C] focus:outline-none focus:border-[#A67B5B]">
            <svg class="w-4 h-4 text-[#9C785C] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    @if (session()->has('success'))
        <div
            class="px-4 py-3 rounded-xl bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabel Laporan Kerusakan -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr
                        class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-6 py-3.5">Fasilitas & Kendala</th>
                        <th class="px-6 py-3.5">Kamar & Penyewa</th>
                        <th class="px-6 py-3.5">Waktu Lapor</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse ($reports as $r)
                        <tr class="hover:bg-[#F3ECE0]/50 transition">
                            <!-- Fasilitas & Foto Bukti -->
                            <td class="px-6 py-4 max-w-md">
                                <div class="flex items-center gap-3">
                                    @if ($r->photo)
                                        <a href="{{ $r->photo_url }}" target="_blank"
                                            class="w-11 h-11 rounded-xl overflow-hidden border border-[#E2D6C3] shrink-0 hover:opacity-90 transition"
                                            title="Lihat Foto Bukti">
                                            <img src="{{ $r->photo_url }}" alt="Bukti"
                                                class="w-full h-full object-cover">
                                        </a>
                                    @else
                                        <div
                                            class="w-11 h-11 rounded-xl bg-[#EFE4D4] border border-[#E2D6C3] text-[#8F6547] flex items-center justify-center shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="min-w-0">
                                        <span
                                            class="font-bold text-[#5C402C] block text-xs sm:text-[13px]">{{ $r->facility_name }}</span>
                                        <p class="text-[11px] text-[#8F6547] line-clamp-1 mt-0.5">{{ $r->description }}
                                        </p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kamar & Penyewa -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">Kamar
                                    {{ $r->room->room_number ?? '-' }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $r->user->name ?? '-' }}</span>
                            </td>

                            <!-- Waktu Lapor -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="font-bold text-[#5C402C] block">{{ $r->created_at->format('d M Y') }}</span>
                                <span class="text-[11px] text-[#8F6547] block">Pukul
                                    {{ $r->created_at->format('H:i') }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if ($r->status === 'resolved')
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA] whitespace-nowrap">
                                        Selesai
                                    </span>
                                @elseif ($r->status === 'in_progress')
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898] whitespace-nowrap">
                                        Diproses
                                    </span>
                                @else
                                    <span
                                        class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC] whitespace-nowrap">
                                        Dilaporkan
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <button type="button" wire:click="openDetailModal({{ $r->id }})"
                                        class="px-3 py-1 rounded-lg text-[#8F6547] hover:bg-[#EFE4D4] font-bold text-[11px] transition cursor-pointer whitespace-nowrap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                                        </svg>

                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[#9C785C] text-xs">
                                Tidak ada laporan kerusakan yang ditemukan.
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
                <span>data dari <strong class="text-[#5C402C]">{{ $reports->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($reports->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $reports->lastPage()); $page++)
                    @if ($page == $reports->currentPage())
                        <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($reports->hasMorePages())
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

    <!-- MODAL TINDAK LANJUT -->
    @if ($showModal && $selectedReport)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-[#2D231C]/50 backdrop-blur-xs transition-opacity"
                wire:click="$set('showModal', false)"></div>

            <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                <div
                    class="w-full max-w-lg rounded-xl bg-[#FAF6EE] border border-[#E2D6C3] shadow-2xl overflow-hidden text-xs">

                    <div class="px-6 py-4 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-extrabold text-[#5C402C]">Tindak Lanjut:
                                {{ $selectedReport->facility_name }}</h3>
                            <p class="text-[11px] text-[#8F6547]">Perbarui status penanganan dan catatan teknisi untuk
                                penyewa</p>
                        </div>
                        <button type="button" wire:click="$set('showModal', false)"
                            class="text-[#8F6547] hover:text-[#5C402C] cursor-pointer">✕</button>
                    </div>

                    <form wire:submit.prevent="updateReport" class="p-6 space-y-4">
                        <div class="p-3.5 rounded-lg bg-[#F3ECE0] border border-[#E2D6C3] space-y-2">
                            <div class="flex justify-between">
                                <span class="text-[#8F6547]">Kamar</span>
                                <strong class="text-[#5C402C]">{{ $selectedReport->room->room_number ?? '-' }}
                                    ({{ $selectedReport->room->name ?? '-' }})</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-[#8F6547]">Pelapor</span>
                                <strong class="text-[#5C402C]">{{ $selectedReport->user->name ?? '-' }}
                                    ({{ $selectedReport->user->phone ?: $selectedReport->user->email }})</strong>
                            </div>
                            <div class="pt-1 border-t border-[#E2D6C3]">
                                <span class="text-[#8F6547] block">Keterangan Kerusakan</span>
                                <p class="text-[#5C402C] font-medium mt-0.5">{{ $selectedReport->description }}</p>
                            </div>
                        </div>

                        @if ($selectedReport->photo)
                            <div>
                                <span class="text-[11px] font-bold uppercase text-[#8F6547] block mb-1.5">Foto Bukti
                                    Kerusakan</span>
                                <div class="rounded-lg border border-[#E2D6C3] overflow-hidden bg-[#F3ECE0]">
                                    <img src="{{ $selectedReport->photo_url }}" alt="Bukti Kerusakan"
                                        class="max-h-48 object-contain mx-auto">
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Status Pengerjaan <span
                                    class="text-rose-600">*</span></label>
                            <select wire:model="status"
                                class="w-full px-3.5 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]">
                                <option value="reported">Diproses</option>
                                <option value="in_progress">Sedang Diperbaiki</option>
                                <option value="resolved">Selesai</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Catatan Teknisi</label>
                            <textarea wire:model="admin_response" rows="3"
                                placeholder="Contoh: Teknisi telah memeriksa AC dan menambahkan freon..."
                                class="w-full px-3.5 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]"></textarea>
                        </div>

                        <div class="pt-3 border-t border-[#E8DEC9] flex items-center justify-end gap-2">
                            <button type="button" wire:click="$set('showModal', false)"
                                class="px-4 py-1.5 rounded-full bg-[#EFE4D4] text-[#5C402C] font-semibold hover:bg-[#E2D6C3] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-5 py-1.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold hover:bg-[#8F6547] cursor-pointer">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
