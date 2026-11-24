<div class="space-y-5">

    @if (session()->has('success'))
        <div
            class="p-3.5 rounded-lg bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- HEADER BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-[#5C402C] tracking-tight">Kelola Kamar</h2>
            <p class="text-xs text-[#8F6547]">Unit kamar terdaftar</p>
        </div>

        <div class="flex items-center gap-2.5 w-full sm:w-auto">
            <div class="relative flex-1 sm:w-64">
                <svg class="w-4 h-4 text-[#8F6547] absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari kamar atau tipe..."
                    class="w-full pl-9 pr-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
            </div>

            <button wire:click="openCreateModal"
                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] transition cursor-pointer shrink-0">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kamar
            </button>
        </div>
    </div>

    <!-- TABEL DAFTAR KAMAR -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr
                        class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-5 py-3">Kamar</th>
                        <th class="px-5 py-3">Tipe & Lantai</th>
                        <th class="px-5 py-3">Harga Bulanan</th>
                        <th class="px-5 py-3">Fasilitas</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse($rooms as $room)
                        @php $photoCount = count($room->all_images_urls); @endphp
                        <tr class="hover:bg-[#F3ECE0]/60 transition">
                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="relative shrink-0">
                                        <img src="{{ $room->main_image_url }}" alt="Kamar {{ $room->room_number }}"
                                            class="w-11 h-11 rounded-lg object-cover border border-[#E2D6C3]">
                                        @if ($photoCount > 1)
                                            <span
                                                class="absolute -bottom-1 -right-1 px-1.5 py-0.2 rounded-full bg-[#5C402C] text-[#FAF6EE] text-[9px] font-bold">
                                                +{{ $photoCount - 1 }}
                                            </span>
                                        @endif
                                    </div>
                                    <div>
                                        <span
                                            class="font-mono font-bold text-xs text-[#5C402C]">{{ $room->room_number }}</span>
                                        <p class="text-[11px] text-[#8F6547] line-clamp-1 max-w-[200px]">
                                            {{ $room->name }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <span class="font-bold text-[#5C402C]">{{ $room->room_type }}</span>
                                <span class="block text-[11px] text-[#9C785C]">Lantai {{ $room->floor }} •
                                    {{ $room->size }}</span>
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <span class="font-extrabold text-[#5C402C]">{{ $room->formatted_monthly_price }}</span>
                                @if ($room->annual_price)
                                    <span class="block text-[11px] text-[#9C785C]">Tahunan:
                                        {{ $room->formatted_annual_price }}</span>
                                @endif
                            </td>

                            <td class="px-5 py-3.5">
                                <span
                                    class="font-semibold text-[#5C402C]">{{ is_array($room->facilities) ? count($room->facilities) : 0 }}
                                    Fasilitas</span>
                                <div class="text-[11px] text-[#8F6547] mt-0.5 line-clamp-1 max-w-[210px]">
                                    {{ is_array($room->facilities) && count($room->facilities) > 0 ? implode(', ', array_slice($room->facilities, 0, 3)) . (count($room->facilities) > 3 ? '...' : '') : '-' }}
                                </div>
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                @if ($room->status === 'available')
                                    <span
                                        class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">Tersedia</span>
                                @elseif($room->status === 'occupied')
                                    <span
                                        class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC]">Terisi</span>
                                @else
                                    <span
                                        class="px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]">Menunggu
                                        Konfirmasi</span>
                                @endif
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <div class="inline-flex items-center gap-1 -ml-1.5">
                                    <button wire:click="openDetailModal({{ $room->id }})"
                                        class="p-1.5 text-[#8F6547] hover:text-[#5C402C] hover:bg-[#EFE4D4] rounded-md transition cursor-pointer"
                                        title="Lihat Detail Kamar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </button>

                                    <button wire:click="openEditModal({{ $room->id }})"
                                        class="p-1.5 text-[#8F6547] hover:text-[#5C402C] hover:bg-[#EFE4D4] rounded-md transition cursor-pointer"
                                        title="Edit Kamar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <button wire:click="confirmDelete({{ $room->id }})"
                                        class="p-1.5 text-[#9E4735] hover:bg-[#F9E6E2] rounded-md transition cursor-pointer"
                                        title="Hapus Kamar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-[#9C785C] text-xs">
                                Tidak ada data kamar yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- FOOTER TABEL -->
        <div
            class="px-5 py-3 border-t border-[#E8DEC9] bg-[#F3ECE0]/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs">
            <div class="flex items-center gap-2 text-[#7A563C]">
                <span>Tampilkan</span>
                <select wire:model.live="perPage"
                    class="px-2.5 py-1 rounded-md border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] font-bold text-xs outline-none focus:ring-2 focus:ring-[#A67B5B] cursor-pointer">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span>data dari <strong class="text-[#5C402C]">{{ $rooms->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($rooms->onFirstPage())
                    <span
                        class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                @else
                    <button wire:click="previousPage"
                        class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $rooms->lastPage()); $page++)
                    @if ($page == $rooms->currentPage())
                        <span
                            class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})"
                            class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($rooms->hasMorePages())
                    <button wire:click="nextPage"
                        class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                @else
                    <span
                        class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- MODAL 1: LIHAT DETAIL KAMAR -->
    @if ($showDetailModal && $detailRoom)
        @php $detailImages = $detailRoom->all_images_urls; @endphp
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity"
                wire:click="$set('showDetailModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg">

                    <div
                        class="px-5 py-3.5 bg-gradient-to-r from-[#A67B5B] to-[#C29A78] text-[#FAF6EE] flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-[#FAF6EE]/85 uppercase">Detail Unit Kamar</span>
                            <h3 class="text-sm font-bold text-[#FAF6EE]">{{ $detailRoom->room_number }} —
                                {{ $detailRoom->name }}</h3>
                        </div>
                        <button wire:click="$set('showDetailModal', false)"
                            class="text-[#FAF6EE]/80 hover:text-[#FAF6EE] cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="p-5 space-y-4 text-xs max-h-[80vh] overflow-y-auto">

                        <div x-data="{
                            active: 0,
                            images: @js($detailImages),
                            touchStartX: 0,
                            next() { this.active = (this.active + 1) % this.images.length },
                            prev() { this.active = (this.active - 1 + this.images.length) % this.images.length }
                        }" x-on:touchstart="touchStartX = $event.changedTouches[0].screenX"
                            x-on:touchend="let diff = touchStartX - $event.changedTouches[0].screenX; if (Math.abs(diff) > 40) { diff > 0 ? next() : prev() }"
                            class="relative rounded-lg overflow-hidden h-52 bg-[#EFE4D4] select-none">

                            <template x-for="(img, idx) in images" :key="idx">
                                <img x-show="active === idx" :src="img" alt="Foto Kamar"
                                    class="w-full h-full object-cover transition-opacity duration-300">
                            </template>

                            <div class="absolute top-3 right-3 z-10">
                                @if ($detailRoom->status === 'available')
                                    <span
                                        class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#EBF2E6]/90 backdrop-blur-md text-[#3F5E30]">Tersedia</span>
                                @elseif($detailRoom->status === 'occupied')
                                    <span
                                        class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#F9E6E2]/90 backdrop-blur-md text-[#9E4735]">Terisi</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#F7ECD9]/90 backdrop-blur-md text-[#8A5A19]">Menunggu
                                        Konfirmasi</span>
                                @endif
                            </div>

                            <div x-show="images.length > 1"
                                class="absolute top-3 left-3 z-10 px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-white text-[10px] font-bold drop-shadow-xs">
                                <span x-text="active + 1"></span> / <span x-text="images.length"></span>
                            </div>

                            <!-- Navigation Buttons -->
                            <button type="button" x-show="images.length > 1" x-on:click="prev()"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-[#2D231C]/35 backdrop-blur-md text-[#FAF6EE] hover:bg-[#2D231C]/55 flex items-center justify-center cursor-pointer transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button type="button" x-show="images.length > 1" x-on:click="next()"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-[#2D231C]/35 backdrop-blur-md text-[#FAF6EE] hover:bg-[#2D231C]/55 flex items-center justify-center cursor-pointer transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <div x-show="images.length > 1"
                                class="absolute bottom-2.5 inset-x-0 flex items-center justify-center gap-1.5 z-10">
                                <template x-for="(img, idx) in images" :key="idx">
                                    <button type="button" x-on:click="active = idx"
                                        :class="active === idx ? 'w-5 bg-white' : 'w-1.5 bg-white/60'"
                                        class="h-1.5 rounded-full transition-all cursor-pointer"></button>
                                </template>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-2.5 bg-[#F3ECE0] p-3.5 rounded-lg">
                            <div>
                                <span class="text-[10px] font-bold uppercase text-[#8F6547] block">Tipe Unit</span>
                                <span
                                    class="font-bold text-[#5C402C] text-xs mt-0.5 block">{{ $detailRoom->room_type }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase text-[#8F6547] block">Lokasi Lantai</span>
                                <span class="font-bold text-[#5C402C] text-xs mt-0.5 block">Lantai
                                    {{ $detailRoom->floor }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase text-[#8F6547] block">Luas Ukuran</span>
                                <span
                                    class="font-bold text-[#5C402C] text-xs mt-0.5 block">{{ $detailRoom->size }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 bg-[#F3ECE0] p-3.5 rounded-lg">
                            <div>
                                <span class="text-[10px] font-bold uppercase text-[#8F6547] block">Tarif Sewa
                                    Bulanan</span>
                                <span
                                    class="font-extrabold text-[#5C402C] text-sm mt-0.5 block">{{ $detailRoom->formatted_monthly_price }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold uppercase text-[#8F6547] block">Tarif Sewa
                                    Tahunan</span>
                                <span
                                    class="font-bold text-[#5C402C] text-sm mt-0.5 block">{{ $detailRoom->annual_price ? $detailRoom->formatted_annual_price : '-' }}</span>
                            </div>
                        </div>

                        @if ($detailRoom->description)
                            <div>
                                <span class="text-[11px] font-bold uppercase text-[#8F6547] block mb-1">Deskripsi
                                    Kamar</span>
                                <p class="text-[#5C402C] leading-relaxed bg-[#F3ECE0]/70 p-3 rounded-lg">
                                    {{ $detailRoom->description }}</p>
                            </div>
                        @endif

                        <div>
                            <span class="text-[11px] font-bold uppercase text-[#8F6547] block mb-1.5">Fasilitas
                                Tersedia
                                ({{ is_array($detailRoom->facilities) ? count($detailRoom->facilities) : 0 }})</span>
                            @if (is_array($detailRoom->facilities) && count($detailRoom->facilities) > 0)
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($detailRoom->facilities as $fac)
                                        <span
                                            class="px-2.5 py-1 rounded-md bg-[#EFE4D4] text-[#5C402C] font-semibold text-[11px]">
                                            {{ $fac }}
                                        </span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-[#9C785C]">Belum ada fasilitas yang dicentang.</p>
                            @endif
                        </div>

                        <div class="pt-3.5 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
                            <button type="button" wire:click="$set('showDetailModal', false)"
                                class="px-4 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] cursor-pointer">
                                Tutup
                            </button>
                            <button type="button" wire:click="openEditModal({{ $detailRoom->id }})"
                                class="px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] cursor-pointer">
                                Edit Kamar Ini
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL 2: CREATE / EDIT KAMAR -->
    @if ($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity"
                wire:click="$set('showModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl">

                    <div class="px-5 py-3.5 bg-[#C29A78] text-[#FAF6EE] flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-[#FAF6EE]/85 uppercase">Kamar & Fasilitas</span>
                            <h3 class="text-sm font-bold text-[#FAF6EE]">
                                {{ $isEdit ? 'Edit Kamar ' . $room_number : 'Tambah Unit Kamar Baru' }}</h3>
                        </div>
                        <button wire:click="$set('showModal', false)"
                            class="text-[#FAF6EE]/80 hover:text-[#FAF6EE] cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="saveRoom" class="p-5 space-y-4 text-xs max-h-[80vh] overflow-y-auto">

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Nomor Kamar
                                    <span class="text-[#9E4735]">*</span></label>
                                <input type="text" wire:model="room_number" placeholder="Contoh: A101"
                                    class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @error('room_number')
                                    <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Nama Tampilan
                                    Kamar <span class="text-[#9E4735]">*</span></label>
                                <input type="text" wire:model="name" placeholder="Contoh: Kamar Deluxe Lantai 1"
                                    class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @error('name')
                                    <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <select wire:model.live="room_type"
                                class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @foreach ($availableRoomTypes as $typeOption)
                                    <option value="{{ $typeOption }}">{{ $typeOption }}</option>
                                @endforeach
                                @if ($room_type && !in_array($room_type, $availableRoomTypes))
                                    <option value="{{ $room_type }}">{{ $room_type }}</option>
                                @endif
                            </select>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Lantai <span
                                        class="text-[#9E4735]">*</span></label>
                                <input type="number" wire:model="floor" min="1"
                                    class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @error('floor')
                                    <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Ukuran Kamar
                                    <span class="text-[#9E4735]">*</span></label>
                                <input type="text" wire:model="size" placeholder="Contoh: 3 x 4 m"
                                    class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @error('size')
                                    <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Harga Bulanan
                                    (Rp) <span class="text-[#9E4735]">*</span></label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-[#8F6547] pointer-events-none">Rp</span>
                                    <input type="text" inputmode="numeric" wire:model="monthly_price"
                                        x-on:input="let raw = $el.value.replace(/\D/g, ''); $el.value = raw ? Number(raw).toLocaleString('id-ID') : '';"
                                        placeholder="1.500.000"
                                        class="w-full pl-9 pr-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] font-semibold text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                </div>
                                @error('monthly_price')
                                    <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Harga Tahunan
                                    (Rp, Opsional)</label>
                                <div class="relative">
                                    <span
                                        class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-[#8F6547] pointer-events-none">Rp</span>
                                    <input type="text" inputmode="numeric" wire:model="annual_price"
                                        x-on:input="let raw = $el.value.replace(/\D/g, ''); $el.value = raw ? Number(raw).toLocaleString('id-ID') : '';"
                                        placeholder="16.500.000"
                                        class="w-full pl-9 pr-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] font-semibold text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                </div>
                                @error('annual_price')
                                    <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Status
                                Ketersediaan <span class="text-[#9E4735]">*</span></label>
                            <select wire:model="status"
                                class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                <option value="available">Tersedia</option>
                                <option value="occupied">Terisi</option>
                                <option value="pending_renewal">Menunggu Konfirmasi Perpanjangan</option>
                            </select>
                            @error('status')
                                <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Deskripsi Lengkap
                                Kamar</label>
                            <textarea wire:model="description" rows="2"
                                class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]"></textarea>
                        </div>

                        <!-- CHECKLIST FASILITAS + INPUT KECIL TEPAT DI BAWAH FASILITAS TERAKHIR -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C]">Checklist Fasilitas
                                    Kamar</label>
                                <span class="text-[11px] text-[#8F6547] font-medium">{{ count($facilities) }}
                                    dipilih</span>
                            </div>

                            <div
                                class="grid grid-cols-2 sm:grid-cols-3 gap-2 p-3 bg-[#F3ECE0] rounded-lg items-center">
                                @foreach ($allFacilities as $fac)
                                    <label
                                        class="flex items-center gap-2 text-xs text-[#5C402C] cursor-pointer select-none">
                                        <input type="checkbox" wire:model.live="facilities"
                                            value="{{ $fac }}"
                                            class="w-3.5 h-3.5 rounded accent-[#A67B5B] border-[#DDD0BC] text-[#A67B5B] focus:ring-[#A67B5B] cursor-pointer">
                                        <span>{{ $fac }}</span>
                                    </label>
                                @endforeach

                                <!-- Input kecil langsung di urutan setelah fasilitas terakhir + tombol ikon (+) -->
                                <div class="flex items-center gap-1">
                                    <input type="text" wire:model="newFacility"
                                        wire:keydown.enter.prevent="addCustomFacility" placeholder="Lainnya..."
                                        class="w-full min-w-0 px-2 py-1 rounded-md border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] placeholder-[#9C785C] text-[11px] outline-none focus:ring-1 focus:ring-[#A67B5B]">
                                    <button type="button" wire:click="addCustomFacility"
                                        class="w-6 h-6 rounded-md bg-[#A67B5B] text-[#FAF6EE] hover:bg-[#8F6547] flex items-center justify-center transition cursor-pointer shrink-0"
                                        title="Tambah fasilitas">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- UPLOAD MULTIPLE FOTO KAMAR -->
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Upload Foto Kamar
                                (Bisa Pilih Lebih dari 1 Foto)</label>
                            <input type="file" wire:model="imageFiles" accept="image/*" multiple
                                class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-xs text-[#7A563C] file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#EFE4D4] file:text-[#5C402C] hover:file:bg-[#E2D6C3]">
                            <span wire:loading wire:target="imageFiles"
                                class="text-xs text-[#A67B5B] mt-1 block">Mengunggah foto...</span>
                            @error('imageFiles.*')
                                <span class="text-xs text-[#9E4735]">{{ $message }}</span>
                            @enderror

                            @if (!empty($imageFiles))
                                <div class="mt-2.5">
                                    <span class="text-[11px] font-semibold text-[#8F6547] block mb-1.5">Foto baru yang
                                        akan ditambahkan ({{ count($imageFiles) }}):</span>
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach ($imageFiles as $file)
                                            <img src="{{ $file->temporaryUrl() }}" alt="Preview"
                                                class="h-20 w-full rounded-lg object-cover border border-[#E2D6C3]">
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if (!empty($existingImages))
                                <div class="mt-2.5">
                                    <span class="text-[11px] font-semibold text-[#8F6547] block mb-1.5">Foto tersimpan
                                        saat ini ({{ count($existingImages) }}):</span>
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach ($existingImages as $idx => $img)
                                            <div class="relative rounded-lg overflow-hidden border border-[#E2D6C3]">
                                                <img src="{{ str_starts_with($img, 'http') ? $img : asset($img) }}"
                                                    alt="Foto Kamar" class="h-20 w-full object-cover">
                                                @if ($idx === 0)
                                                    <span
                                                        class="absolute bottom-1.5 left-1.5 px-1.5 py-0.5 rounded bg-white/25 backdrop-blur-md text-white text-[9px] font-bold drop-shadow-xs">Utama</span>
                                                @endif
                                                <!-- Tombol Silang -->
                                                <button type="button"
                                                    wire:click="removeExistingImage({{ $idx }})"
                                                    class="absolute top-1.5 right-1.5 w-6 h-6 rounded-full bg-[#2D231C]/45 backdrop-blur-md text-[#FAF6EE] hover:bg-[#9E4735] flex items-center justify-center transition cursor-pointer"
                                                    title="Hapus foto ini">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="pt-3.5 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
                            <button type="button" wire:click="$set('showModal', false)"
                                class="px-4 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] cursor-pointer">
                                {{ $isEdit ? 'Simpan Perubahan' : 'Tambahkan Kamar' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- MODAL 3: KONFIRMASI HAPUS KAMAR -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity"
                wire:click="$set('showDeleteModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div
                    class="relative transform overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md p-6">
                    <div class="flex items-start gap-3.5">
                        <div
                            class="w-10 h-10 rounded-lg bg-[#F9E6E2] text-[#9E4735] flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-extrabold text-[#5C402C]">Hapus Unit Kamar?</h3>
                            <p class="text-xs text-[#8F6547] mt-1 leading-relaxed">
                                Anda akan menghapus kamar <strong
                                    class="text-[#5C402C]">{{ $deleteRoomLabel }}</strong>. Data yang sudah dihapus
                                tidak dapat dikembalikan.
                            </p>
                        </div>
                    </div>

                    <div class="mt-5 pt-4 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
                        <button type="button" wire:click="$set('showDeleteModal', false)"
                            class="px-4 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] transition cursor-pointer">
                            Batal
                        </button>
                        <button type="button" wire:click="deleteRoom"
                            class="px-4 py-2 rounded-lg bg-[#9E4735] text-[#FAF6EE] font-bold text-xs hover:bg-[#823829] transition cursor-pointer">
                            Ya, Hapus Kamar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
