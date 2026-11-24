<div class="space-y-5">

    @if(session()->has('success'))
        <div class="p-3.5 rounded-lg bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- HEADER BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-[#5C402C] tracking-tight">Kelola Tipe Kamar</h2>
            <p class="text-xs text-[#8F6547]">Kategori tipe kamar yang terhubung ke form kamar</p>
        </div>

        <div class="flex items-center gap-2.5 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <svg class="w-4 h-4 text-[#8F6547] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari tipe kamar..."
                       class="w-full pl-9 pr-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
            </div>

            <button wire:click="openCreateModal" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] transition cursor-pointer shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Tipe
            </button>
        </div>
    </div>

    <!-- TABEL TIPE KAMAR -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-5 py-3">Tipe Kamar</th>
                        <th class="px-5 py-3">Ukuran Default</th>
                        <th class="px-5 py-3">Harga Dasar / Bulan</th>
                        <th class="px-5 py-3">Jumlah Unit</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse($roomTypes as $type)
                        <tr class="hover:bg-[#F3ECE0]/60 transition">
                            <td class="px-5 py-3.5">
                                <span class="font-bold text-[#5C402C] block">{{ $type->name }}</span>
                                <span class="text-[11px] text-[#8F6547] line-clamp-1 max-w-[240px]">{{ $type->description ?: '-' }}</span>
                            </td>
                            <td class="px-5 py-3.5 font-semibold">{{ $type->default_size ?: '-' }}</td>
                            <td class="px-5 py-3.5 font-extrabold">
                                {{ $type->base_monthly_price ? 'Rp ' . number_format((float) $type->base_monthly_price, 0, ',', '.') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 text-[#8F6547] font-semibold">{{ $roomCounts[$type->name] ?? 0 }} Kamar</td>
                            <td class="px-5 py-3.5">
                                @if($type->is_active)
                                    <span class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">Aktif</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EFE4D4] text-[#8F6547] border border-[#DDD0BC]">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="inline-flex items-center gap-1 -ml-1.5">
                                    <button wire:click="openEditModal({{ $type->id }})" class="p-1.5 text-[#8F6547] hover:text-[#5C402C] hover:bg-[#EFE4D4] rounded-md transition cursor-pointer" title="Edit Tipe">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button wire:click="confirmDelete({{ $type->id }})" class="p-1.5 text-[#9E4735] hover:bg-[#F9E6E2] rounded-md transition cursor-pointer" title="Hapus Tipe">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[#9C785C] text-xs">Belum ada data tipe kamar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- FOOTER TABEL -->
        <div class="px-5 py-3 border-t border-[#E8DEC9] bg-[#F3ECE0]/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2 text-[#7A563C]">
                <span>Tampilkan</span>
                <select wire:model.live="perPage" class="px-2.5 py-1 rounded-md border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] font-bold text-xs outline-none cursor-pointer">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span>data dari <strong class="text-[#5C402C]">{{ $roomTypes->total() }}</strong> tipe</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($roomTypes->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center">‹</span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center cursor-pointer">‹</button>
                @endif

                <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $roomTypes->currentPage() }}</span>

                @if ($roomTypes->hasMorePages())
                    <button wire:click="nextPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center cursor-pointer">›</button>
                @else
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center">›</span>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL CREATE / EDIT -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity" wire:click="$set('showModal', false)"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl transition-all sm:w-full sm:max-w-md">
                    <div class="px-5 py-3.5 bg-gradient-to-r from-[#A67B5B] to-[#C29A78] text-[#FAF6EE] flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-[#FAF6EE]/85 uppercase">Master Tipe Kamar</span>
                            <h3 class="text-sm font-bold text-[#FAF6EE]">{{ $isEdit ? 'Edit Tipe Kamar' : 'Tambah Tipe Kamar Baru' }}</h3>
                        </div>
                        <button wire:click="$set('showModal', false)" class="text-[#FAF6EE]/80 hover:text-[#FAF6EE] cursor-pointer">✕</button>
                    </div>

                    <form wire:submit.prevent="saveRoomType" class="p-5 space-y-4 text-xs">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Nama Tipe Kamar <span class="text-[#9E4735]">*</span></label>
                            <input type="text" wire:model="name" placeholder="Contoh: Standard, Deluxe, VIP..." class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                            @error('name') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Ukuran Default</label>
                                <input type="text" wire:model="default_size" placeholder="3 x 4 m" class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Harga Dasar / Bln (Opsional)</label>
                                <input type="text" inputmode="numeric" wire:model="base_monthly_price"
                                       x-on:input="let raw = $el.value.replace(/\D/g, ''); $el.value = raw ? Number(raw).toLocaleString('id-ID') : '';"
                                       placeholder="1.500.000"
                                       class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] font-semibold text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Keterangan</label>
                            <textarea wire:model="description" rows="2" class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]"></textarea>
                        </div>

                        <label class="flex items-center gap-2 text-xs text-[#5C402C] cursor-pointer">
                            <input type="checkbox" wire:model="is_active" class="w-3.5 h-3.5 rounded accent-[#A67B5B] border-[#DDD0BC]">
                            <span>Aktifkan di dropdown form kamar</span>
                        </label>

                        <div class="pt-3.5 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
                            <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] cursor-pointer">Batal</button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] cursor-pointer">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL HAPUS -->
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity" wire:click="$set('showDeleteModal', false)"></div>
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="relative transform overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl sm:w-full sm:max-w-md p-6">
                    <h3 class="text-sm font-extrabold text-[#5C402C]">Hapus Tipe Kamar?</h3>
                    <p class="text-xs text-[#8F6547] mt-1">Tipe <strong class="text-[#5C402C]">{{ $deleteLabel }}</strong> akan dihapus dari daftar pilihan.</p>
                    <div class="mt-5 pt-4 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
                        <button type="button" wire:click="$set('showDeleteModal', false)" class="px-4 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-xs cursor-pointer">Batal</button>
                        <button type="button" wire:click="deleteRoomType" class="px-4 py-2 rounded-lg bg-[#9E4735] text-[#FAF6EE] font-bold text-xs cursor-pointer">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>