<div class="space-y-6">
    <!-- Top Header & Search (Persis Style Kelola Kamar) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">Semua Akun Terdaftar</h2>
            <p class="text-xs text-[#8F6547] mt-0.5">Total {{ $allTenants->total() }} akun penyewa terdaftar</p>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari nama, email, atau no. HP..."
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
                        <th class="px-6 py-3.5">Kontak & Identitas</th>
                        <th class="px-6 py-3.5">Kamar Saat Ini</th>
                        <th class="px-6 py-3.5">Terdaftar</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse($allTenants as $t)
                        @php
                            $currentBooking = $t->bookings->first();
                        @endphp
                        <tr class="hover:bg-[#F3ECE0]/50 transition">
                            <!-- Penyewa -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <span class="font-bold text-[#5C402C] block text-xs sm:text-[13px]">{{ $t->name }}</span>
                                        <span class="text-[11px] text-[#8F6547] block">{{ $t->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kontak & Identitas -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $t->phone ?: 'Belum diisi' }}</span>
                                <span class="text-[11px] text-[#8F6547] block">NIK: {{ $t->id_card_number ?: '-' }}</span>
                            </td>

                            <!-- Kamar Saat Ini -->
                            <td class="px-6 py-4">
                                @if($currentBooking && $currentBooking->room)
                                    <span class="font-bold text-[#5C402C] block">{{ $currentBooking->room->room_number }}</span>
                                    <span class="text-[11px] text-[#8F6547] block">{{ $currentBooking->room->room_type }} • Lt. {{ $currentBooking->room->floor }}</span>
                                @else
                                    <span class="font-semibold text-[#8F6547] block">-</span>
                                    <span class="text-[11px] text-[#9C785C] block">Belum menempati kamar</span>
                                @endif
                            </td>

                            <!-- Terdaftar -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $t->created_at->format('d M Y') }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $t->created_at->diffForHumans() }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if($currentBooking && $currentBooking->room)
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                        Menyewa
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EFE4D4] text-[#7A563C] border border-[#DDD0BC]">
                                        Terdaftar
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi Ikon -->
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    <button type="button" wire:click="openDetailModal({{ $t->id }})"
                                        class="p-1.5 rounded-lg text-[#8F6547] hover:bg-[#EFE4D4] transition cursor-pointer"
                                        title="Lihat Detail Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>

                                    <button type="button" wire:click="openEditModal({{ $t->id }})"
                                        class="p-1.5 rounded-lg text-[#8F6547] hover:bg-[#EFE4D4] transition cursor-pointer"
                                        title="Edit Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    <button type="button" wire:click="deleteAccount({{ $t->id }})"
                                        wire:confirm="Yakin ingin menghapus akun {{ $t->name }}?"
                                        class="p-1.5 rounded-lg text-[#9E4735] hover:bg-[#F9E6E2] transition cursor-pointer"
                                        title="Hapus Akun">
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
                                Belum ada akun penyewa yang terdaftar.
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
                <span>data dari <strong class="text-[#5C402C]">{{ $allTenants->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($allTenants->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $allTenants->lastPage()); $page++)
                    @if ($page == $allTenants->currentPage())
                        <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($allTenants->hasMorePages())
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

    <!-- MODAL DETAIL AKUN -->
    @if($showDetailModal && $detailUser)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#2D231C]/50 backdrop-blur-xs" wire:click="closeDetailModal"></div>
            <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-md rounded-2xl bg-[#FAF6EE] border border-[#E2D6C3] shadow-2xl overflow-hidden text-xs">
                    <div class="px-6 py-4 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
                        <h3 class="text-sm font-extrabold text-[#5C402C]">Detail Akun Penyewa</h3>
                        <button type="button" wire:click="closeDetailModal" class="text-[#8F6547] hover:text-[#5C402C] cursor-pointer">✕</button>
                    </div>
                    <div class="p-6 space-y-3">
                        <div class="flex justify-between py-1.5 border-b border-[#EFE4D4]"><span class="text-[#8F6547]">Nama</span><strong class="text-[#5C402C]">{{ $detailUser->name }}</strong></div>
                        <div class="flex justify-between py-1.5 border-b border-[#EFE4D4]"><span class="text-[#8F6547]">Email</span><strong class="text-[#5C402C]">{{ $detailUser->email }}</strong></div>
                        <div class="flex justify-between py-1.5 border-b border-[#EFE4D4]"><span class="text-[#8F6547]">No. HP / WA</span><strong class="text-[#5C402C]">{{ $detailUser->phone ?: '-' }}</strong></div>
                        <div class="flex justify-between py-1.5 border-b border-[#EFE4D4]"><span class="text-[#8F6547]">NIK / KTP</span><strong class="text-[#5C402C]">{{ $detailUser->id_card_number ?: '-' }}</strong></div>
                        <div class="flex justify-between py-1.5"><span class="text-[#8F6547]">Tanggal Daftar</span><strong class="text-[#5C402C]">{{ $detailUser->created_at->format('d M Y, H:i') }}</strong></div>
                    </div>
                    <div class="px-6 py-3 bg-[#F3ECE0]/60 border-t border-[#E2D6C3] flex justify-end">
                        <button type="button" wire:click="closeDetailModal" class="px-4 py-1.5 rounded-full bg-[#EFE4D4] text-[#5C402C] font-semibold cursor-pointer">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL EDIT AKUN -->
    @if($showEditModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#2D231C]/50 backdrop-blur-xs" wire:click="closeEditModal"></div>
            <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-md rounded-2xl bg-[#FAF6EE] border border-[#E2D6C3] shadow-2xl overflow-hidden text-xs">
                    <div class="px-6 py-4 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
                        <h3 class="text-sm font-extrabold text-[#5C402C]">Edit Akun Penyewa</h3>
                        <button type="button" wire:click="closeEditModal" class="text-[#8F6547] hover:text-[#5C402C] cursor-pointer">✕</button>
                    </div>

                    <form wire:submit="updateAccount" class="p-6 space-y-3.5">
                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Nama Lengkap</label>
                            <input type="text" wire:model="name" class="w-full px-3.5 py-2 rounded-xl bg-[#F3ECE0] border border-[#DDD0BC] text-[#5C402C] focus:outline-none">
                            @error('name') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Email</label>
                            <input type="email" wire:model="email" class="w-full px-3.5 py-2 rounded-xl bg-[#F3ECE0] border border-[#DDD0BC] text-[#5C402C] focus:outline-none">
                            @error('email') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-[#5C402C] mb-1">No. Telepon</label>
                                <input type="text" wire:model="phone" class="w-full px-3.5 py-2 rounded-xl bg-[#F3ECE0] border border-[#DDD0BC] text-[#5C402C] focus:outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-[#5C402C] mb-1">NIK / No. KTP</label>
                                <input type="text" wire:model="id_card_number" class="w-full px-3.5 py-2 rounded-xl bg-[#F3ECE0] border border-[#DDD0BC] text-[#5C402C] focus:outline-none">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Password Baru <span class="font-normal text-[#8F6547]">(opsional)</span></label>
                            <input type="password" wire:model="password" placeholder="Kosongkan jika tetap" class="w-full px-3.5 py-2 rounded-xl bg-[#F3ECE0] border border-[#DDD0BC] text-[#5C402C] focus:outline-none">
                            @error('password') <span class="text-rose-600 text-[11px]">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-3 flex items-center justify-end gap-2 border-t border-[#E8DEC9]">
                            <button type="button" wire:click="closeEditModal" class="px-4 py-1.5 rounded-full bg-[#EFE4D4] text-[#5C402C] font-semibold cursor-pointer">Batal</button>
                            <button type="submit" class="px-5 py-1.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold hover:bg-[#8F6547] cursor-pointer">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>