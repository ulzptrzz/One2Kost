<div class="space-y-6">
    <!-- Top Header & Search + CTA -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">Banner Slider</h2>
            <p class="text-xs text-[#8F6547] mt-0.5">Total {{ $sliders->total() }} banner promosi halaman depan terdaftar</p>
        </div>

        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
            <div class="relative w-full sm:w-64">
                <input type="text" wire:model.live.debounce.300ms="search"
                    placeholder="Cari judul atau badge banner..."
                    class="w-full pl-9 pr-4 py-2 rounded-full bg-[#FAF6EE] border border-[#E2D6C3] text-xs text-[#5C402C] placeholder-[#9C785C] focus:outline-none focus:border-[#A67B5B]">
                <svg class="w-4 h-4 text-[#9C785C] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 10a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <button type="button" wire:click="openCreateSliderModal"
                class="px-4 py-2 rounded-full bg-[#A67B5B] text-[#FAF6EE] hover:bg-[#8F6547] font-bold text-xs transition cursor-pointer shrink-0 text-center">
                + Tambah Banner
            </button>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="px-4 py-3 rounded-xl bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Card Tabel Banner -->
    <div class="bg-[#FAF6EE] rounded-2xl border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-6 py-3.5">Banner & Judul</th>
                        <th class="px-6 py-3.5">Badge & Tombol CTA</th>
                        <th class="px-6 py-3.5">Urutan</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse ($sliders as $s)
                        <tr class="hover:bg-[#F3ECE0]/50 transition">
                            <!-- Preview & Judul -->
                            <td class="px-6 py-4 max-w-md">
                                <div class="flex items-center gap-3.5">
                                    <div class="w-20 h-12 rounded-xl overflow-hidden bg-[#F3ECE0] border border-[#E2D6C3] shrink-0">
                                        <img src="{{ $s->image_url }}" alt="Slider" class="w-full h-full object-cover">
                                    </div>
                                    <div class="min-w-0">
                                        <span class="font-bold text-[#5C402C] block text-xs sm:text-[13px] truncate">{{ $s->title }}</span>
                                        <p class="text-[11px] text-[#8F6547] line-clamp-1 mt-0.5">{{ $s->subtitle ?: '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Badge & CTA -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $s->badge_text ?: 'Tanpa Badge' }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $s->button_text ?: '-' }} ({{ $s->button_link ?: '#' }})</span>
                            </td>

                            <!-- Urutan -->
                            <td class="px-6 py-4">
                                <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC]">
                                    #{{ $s->order }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if ($s->is_active)
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EFE4D4] text-[#8F6547] border border-[#DDD0BC]">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-1.5">
                                    <button type="button" wire:click="openEditSliderModal({{ $s->id }})"
                                        class="p-1.5 rounded-lg text-[#A67B5B] hover:bg-[#EFE4D4] transition cursor-pointer" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>
                                    <button type="button" wire:click="deleteSlider({{ $s->id }})" wire:confirm="Hapus banner slider ini?"
                                        class="p-1.5 rounded-lg text-[#9E4735] hover:bg-[#F9E6E2] transition cursor-pointer" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-[#9C785C] text-xs">
                                Belum ada banner slider yang ditambahkan.
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
                <span>data dari <strong class="text-[#5C402C]">{{ $sliders->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($sliders->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $sliders->lastPage()); $page++)
                    @if ($page == $sliders->currentPage())
                        <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($sliders->hasMorePages())
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

    <!-- MODAL SLIDER FORM -->
    @if ($showSliderModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#2D231C]/50 backdrop-blur-xs transition-opacity" wire:click="$set('showSliderModal', false)"></div>

            <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-lg rounded-2xl bg-[#FAF6EE] border border-[#E2D6C3] shadow-2xl overflow-hidden text-xs">
                    <div class="px-6 py-4 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-extrabold text-[#5C402C]">{{ $isSliderEdit ? 'Edit Banner Slider' : 'Tambah Banner Slider Baru' }}</h3>
                            <p class="text-[11px] text-[#8F6547]">Atur gambar promosi dan tombol aksi di halaman utama</p>
                        </div>
                        <button type="button" wire:click="$set('showSliderModal', false)" class="text-[#8F6547] hover:text-[#5C402C] cursor-pointer">✕</button>
                    </div>

                    <form wire:submit.prevent="saveSlider" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto">
                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Judul Banner <span class="text-rose-600">*</span></label>
                            <input type="text" wire:model="sliderTitle" placeholder="Contoh: Hunian Kost Modern, Nyaman & Strategis"
                                class="w-full px-3.5 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]">
                            @error('sliderTitle') <span class="text-[11px] text-rose-600">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Subjudul / Deskripsi Banner</label>
                            <textarea wire:model="sliderSubtitle" rows="2"
                                class="w-full px-3.5 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]"></textarea>
                            @error('sliderSubtitle') <span class="text-[11px] text-rose-600">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-[#5C402C] mb-1">Badge Teks</label>
                                <input type="text" wire:model="sliderBadge" placeholder="Promo Spesial Bulan Ini"
                                    class="w-full px-3.5 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]">
                            </div>

                            <div>
                                <label class="block font-bold text-[#5C402C] mb-1">Urutan Tampil <span class="text-rose-600">*</span></label>
                                <input type="number" wire:model="sliderOrder" min="0"
                                    class="w-full px-3.5 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-[#5C402C] mb-1">Teks Tombol CTA</label>
                                <input type="text" wire:model="sliderButtonText" placeholder="Lihat Katalog Kamar"
                                    class="w-full px-3.5 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]">
                            </div>

                            <div>
                                <label class="block font-bold text-[#5C402C] mb-1">Link Tombol CTA</label>
                                <input type="text" wire:model="sliderButtonLink" placeholder="#katalog"
                                    class="w-full px-3.5 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] focus:outline-none focus:border-[#A67B5B]">
                            </div>
                        </div>

                        <div>
                            <label class="block font-bold text-[#5C402C] mb-1">Upload Gambar Slider <span class="text-rose-600">*</span></label>
                            <input type="file" wire:model="sliderImageFile" accept="image/*"
                                class="w-full px-3 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-xs text-[#7A563C] file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#EFE4D4] file:text-[#5C402C] hover:file:bg-[#E2D6C3]">
                            <span wire:loading wire:target="sliderImageFile" class="text-[11px] text-[#A67B5B] mt-1 block">Mengunggah gambar...</span>
                            @error('sliderImageFile') <span class="text-[11px] text-rose-600">{{ $message }}</span> @enderror

                            @if ($sliderImageFile)
                                <div class="mt-2">
                                    <img src="{{ $sliderImageFile->temporaryUrl() }}" alt="Preview" class="h-24 rounded-xl border border-[#E2D6C3] object-cover">
                                </div>
                            @elseif ($existingSliderImage)
                                <div class="mt-2">
                                    <img src="{{ str_starts_with($existingSliderImage, 'http') ? $existingSliderImage : asset($existingSliderImage) }}" alt="Gambar Saat Ini" class="h-24 rounded-xl border border-[#E2D6C3] object-cover">
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-2">
                            <input type="checkbox" wire:model="sliderIsActive" id="slider_active" class="rounded border-[#DDD0BC] text-[#A67B5B]">
                            <label for="slider_active" class="text-xs font-semibold text-[#5C402C]">Tampilkan slider ini di halaman depan</label>
                        </div>

                        <div class="pt-3 border-t border-[#E8DEC9] flex items-center justify-end gap-2">
                            <button type="button" wire:click="$set('showSliderModal', false)"
                                class="px-4 py-1.5 rounded-full bg-[#EFE4D4] text-[#5C402C] font-semibold hover:bg-[#E2D6C3] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled"
                                class="px-5 py-1.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold hover:bg-[#8F6547] cursor-pointer">
                                Simpan Banner
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>