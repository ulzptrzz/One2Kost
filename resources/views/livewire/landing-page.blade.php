<div class="bg-[#F5EFE6] text-[#2D231C] space-y-20 pb-24 sm:pb-16">

    <!-- HERO SECTION -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6" x-data="{
        currentSlide: 0,
        totalSlides: {{ count($sliders) > 0 ? count($sliders) : 1 }},
        autoplay() {
            if (this.totalSlides > 1) {
                setInterval(() => { this.currentSlide = (this.currentSlide + 1) % this.totalSlides }, 6500)
            }
        }
    }" x-init="autoplay()">

        <div class="relative rounded-2xl overflow-hidden min-h-[470px] sm:min-h-[540px] flex items-end">
            @forelse($sliders as $index => $slider)
                <div x-show="currentSlide === {{ $index }}" x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="w-full h-full">

                    <img src="{{ $slider->image_url }}" alt="{{ $slider->title ?? 'Foto Area Kost' }}"
                        class="absolute inset-0 w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#241B15]/90 via-[#241B15]/35 to-transparent">
                    </div>

                    <div class="relative z-20 px-6 sm:px-12 lg:px-14 pt-32 pb-16 sm:pb-20 max-w-2xl space-y-3.5">
                        <span
                            class="inline-block px-4 py-1.5 rounded-full text-[11px] font-semibold uppercase tracking-widest bg-[#FAF6EE]/15 text-[#FAF6EE] backdrop-blur-md">
                            {{ trim(preg_replace('/[\x{1F300}-\x{1F9FF}]/u', '', $slider->badge_text)) ?: 'HUNIAN KOST NYAMAN' }}
                        </span>

                        <h1
                            class="text-3xl sm:text-4xl lg:text-[42px] font-bold tracking-tight text-[#FAF6EE] leading-[1.15]">
                            {{ $slider->title ?: 'Kamar Nyaman, Cek Jadwal & Booking Langsung.' }}
                        </h1>

                        <p class="text-sm sm:text-base text-[#EAE0D5] leading-relaxed">
                            {{ $slider->subtitle ?: 'Lihat ketersediaan kamar secara langsung, ajukan tanggal masuk tanpa menunggu balasan chat, dan kelola pembayaran sewa dalam satu tempat.' }}
                        </p>

                        <div class="flex flex-wrap items-center gap-3 pt-2">
                            <a href="{{ $slider->button_link ?: '#katalog' }}"
                                class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-semibold text-sm hover:bg-[#8F6547] transition shadow-xs">
                                <span>{{ $slider->button_text ?: 'Pilih Kamar' }}</span>
                                <span aria-hidden="true">→</span>
                            </a>
                            <a href="#alur-sewa"
                                class="inline-flex items-center px-5 py-2.5 rounded-full bg-[#FAF6EE]/15 text-[#FAF6EE] font-medium text-sm hover:bg-[#FAF6EE]/25 backdrop-blur-xs transition">
                                Cara Booking & Antrian
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="relative z-20 px-6 sm:px-12 py-20 max-w-2xl space-y-4">
                    <span
                        class="inline-block px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#FAF6EE]/20 backdrop-blur-md text-[#FAF6EE]">
                        One2Kost
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-bold text-[#FAF6EE] leading-tight">
                        Kamar Nyaman, Cek Jadwal & Booking Langsung.
                    </h1>
                    <p class="text-sm sm:text-base text-[#EAE0D5]">
                        Lihat ketersediaan kamar secara langsung dan atur jadwal sewa Anda dengan mudah.
                    </p>
                    <div class="pt-2">
                        <a href="#katalog"
                            class="inline-flex items-center px-6 py-2.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-semibold text-sm hover:bg-[#8F6547] transition">
                            Pilih Kamar →
                        </a>
                    </div>
                </div>
            @endforelse

            @if (count($sliders) > 1)
                <div class="absolute bottom-6 right-6 sm:right-12 z-30 flex items-center gap-2">
                    @foreach ($sliders as $index => $slider)
                        <button @click="currentSlide = {{ $index }}"
                            :class="currentSlide === {{ $index }} ? 'w-6 bg-[#FAF6EE]' :
                                'w-2 bg-[#FAF6EE]/45 hover:bg-[#FAF6EE]/80'"
                            class="h-1.5 rounded-full transition-all duration-300"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- KATALOG KAMAR -->
    <section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-bold text-[#2D231C] tracking-tight">Daftar Kamar</h2>
                <p class="text-sm text-[#6E5F53] mt-1">Pilih kamar untuk melihat detail fasilitas atau mengecek tanggal
                    masuk yang tersedia.</p>
            </div>
        </div>

        @if (count($rooms) === 0)
            <div class="text-center py-16 bg-[#FAF6EE] rounded-2xl">
                <p class="text-base font-semibold text-[#2D231C]">Tidak ada kamar yang cocok dengan filter ini.</p>
                <p class="text-sm text-[#6E5F53] mt-1">Coba ubah pilihan tipe atau rentang harga di atas.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7">
                @foreach ($rooms as $room)
                    @php
                        $roomPhotos = $room->all_images_urls ?? [$room->main_image_url];
                    @endphp
                    <article
                        class="bg-[#FAF6EE] rounded-2xl overflow-hidden shadow-2xs hover:shadow-md transition flex flex-col group">

                        <!-- AREA GAMBAR BISA DIGESER / SCROLL -->
                        <div x-data="{
                            active: 0,
                            photos: @js($roomPhotos),
                            startX: 0,
                            next() { this.active = (this.active + 1) % this.photos.length },
                            prev() { this.active = (this.active - 1 + this.photos.length) % this.photos.length }
                        }" x-on:touchstart="startX = $event.changedTouches[0].screenX"
                            x-on:touchend="let d = startX - $event.changedTouches[0].screenX; if (Math.abs(d) > 35) { d > 0 ? next() : prev() }"
                            class="relative h-56 overflow-hidden bg-[#E8DEC8] select-none">

                            <img :src="photos[active]" alt="{{ $room->name }}"
                                class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500">

                            <div
                                class="absolute inset-0 bg-gradient-to-b from-black/25 via-transparent to-black/30 pointer-events-none">
                            </div>

                            <!-- Badge Type Room-->
                            <div class="absolute top-4 left-4 z-10">
                                <span
                                    class="px-3.5 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#2D231C]/35 backdrop-blur-md text-[#FAF6EE]">
                                    {{ $room->room_type }} • Lt. {{ $room->floor }}
                                </span>
                            </div>

                            <!-- Badge Status -->
                            <div class="absolute top-4 right-4 z-10">
                                @if ($room->status === 'available')
                                    <span
                                        class="px-3 py-1.5 rounded-full text-[11px] font-bold bg-[#5B8552]/90 backdrop-blur-md text-[#FAF6EE]">
                                        Tersedia
                                    </span>
                                @elseif($room->status === 'occupied')
                                    <span
                                        class="px-3 py-1.5 rounded-full text-[11px] font-bold bg-[#2D231C]/65 backdrop-blur-md text-[#FAF6EE]">
                                        Terisi
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1.5 rounded-full text-[11px] font-bold bg-[#B8845A]/90 backdrop-blur-md text-[#FAF6EE]">
                                        Konfirmasi
                                    </span>
                                @endif
                            </div>

                            <!-- Navigasi Foto -->
                            <button type="button" x-show="photos.length > 1" x-on:click.stop="prev()"
                                class="absolute left-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-[#2D231C]/35 backdrop-blur-md text-[#FAF6EE] hover:bg-[#2D231C]/55 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </button>
                            <button type="button" x-show="photos.length > 1" x-on:click.stop="next()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 z-10 w-8 h-8 rounded-full bg-[#2D231C]/35 backdrop-blur-md text-[#FAF6EE] hover:bg-[#2D231C]/55 flex items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </button>

                            <!-- DOTS INDIKATOR FOTO DI BAWAH -->
                            <div x-show="photos.length > 1"
                                class="absolute bottom-3 inset-x-0 z-10 flex items-center justify-center gap-1.5">
                                <template x-for="(p, i) in photos" :key="i">
                                    <button type="button" x-on:click.stop="active = i"
                                        :class="active === i ? 'w-5 bg-[#FAF6EE]' :
                                            'w-1.5 bg-[#FAF6EE]/60 hover:bg-[#FAF6EE]/90'"
                                        class="h-1.5 rounded-full transition-all cursor-pointer"></button>
                                </template>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-baseline justify-between gap-2">
                                    <h3 class="text-lg font-bold text-[#2D231C]">
                                        {{ $room->name }}
                                    </h3>
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-mono font-semibold bg-[#EFE4D4] text-[#8F6547] shrink-0">
                                        #{{ $room->room_number }}
                                    </span>
                                </div>

                                @if ($room->size)
                                    <p class="text-xs text-[#8C7D70] mt-0.5">Luas kamar {{ $room->size }}</p>
                                @endif

                                <p class="text-sm text-[#6E5F53] mt-2.5 line-clamp-2 leading-relaxed">
                                    {{ $room->description }}
                                </p>
                            </div>

                            <div class="mt-5 pt-4">
                                <div class="flex items-baseline justify-between gap-2 mb-4">
                                    <div class="whitespace-nowrap">
                                        <span
                                            class="text-lg font-bold text-[#2D231C]">{{ $room->formatted_monthly_price }}</span>
                                        <span class="text-xs text-[#6E5F53]">/ bulan</span>
                                    </div>
                                    @if ($room->annual_price)
                                        <span class="text-xs text-[#6E5F53]">
                                            Tahunan: <strong
                                                class="text-[#2D231C]">{{ $room->formatted_annual_price }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <!-- TOMBOL LIHAT DETAIL + TOMBOL AJUKAN SEWA / CEK JADWAL -->
                                <div class="flex items-center gap-2">
                                    <button type="button" wire:click="openBookingModal({{ $room->id }})"
                                        class="flex-1 py-2.5 px-4 rounded-full font-semibold text-sm transition cursor-pointer
                                            {{ $room->status === 'available' ? 'bg-[#A67B5B] text-[#FAF6EE] hover:bg-[#8F6547]' : 'bg-[#EFE4D4] text-[#8F6547] hover:bg-[#E4D5C0]' }}">
                                        {{ $room->status === 'available' ? 'Ajukan Sewa Kamar' : 'Cek Jadwal & Antri' }}
                                    </button>
                                    <button type="button" wire:click="openRoomDetailModal({{ $room->id }})"
                                        class="px-4 py-2.5 rounded-full bg-[#F3ECE0] text-[#5C402C] hover:bg-[#EFE4D4] font-semibold text-sm inline-flex items-center justify-center gap-1.5 transition cursor-pointer shrink-0"
                                        title="Lihat Detail Kamar">
                                        <svg class="w-4 h-4 text-[#8F6547]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <span>Detail</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    <!-- POP-UP MODAL DETAIL KAMAR (GAYA AWAL + POSISI TENGAH) -->
    @if ($showRoomDetailModal && $detailRoom)
        @php $detailImages = $detailRoom->all_images_urls; @endphp
        @teleport('body')
            <div class="fixed inset-0 z-[9999] overflow-y-auto" role="dialog" aria-modal="true">

                <!-- Backdrop Blur Penuh -->
                <div class="fixed inset-0 bg-[#2D231C]/50 backdrop-blur-sm transition-opacity"
                    wire:click="closeRoomDetailModal"></div>

                <!-- Wrapper Tengah -->
                <div class="relative z-10 min-h-screen w-full flex items-center justify-center p-4">

                    <!-- Kotak Modal Tengah -->
                    <div
                        class="w-full max-w-lg max-h-[82vh] flex flex-col rounded-2xl bg-[#FAF6EE] shadow-2xl overflow-hidden text-left">

                        <!-- 1. GAMBAR SLIDER -->
                        <div x-data="{
                            active: 0,
                            images: @js($detailImages),
                            touchStartX: 0,
                            next() { this.active = (this.active + 1) % this.images.length },
                            prev() { this.active = (this.active - 1 + this.images.length) % this.images.length }
                        }" x-on:touchstart="touchStartX = $event.changedTouches[0].screenX"
                            x-on:touchend="let diff = touchStartX - $event.changedTouches[0].screenX; if (Math.abs(diff) > 40) { diff > 0 ? next() : prev() }"
                            class="relative h-48 sm:h-52 w-full bg-[#EFE4D4] shrink-0 select-none overflow-hidden">

                            <template x-for="(img, idx) in images" :key="idx">
                                <img x-show="active === idx" :src="img" alt="{{ $detailRoom->name }}"
                                    class="w-full h-full object-cover transition-opacity duration-300">
                            </template>

                            <!-- Gradient halus atas & bawah -->
                            <div
                                class="absolute inset-x-0 top-0 h-16 bg-gradient-to-b from-black/35 to-transparent pointer-events-none">
                            </div>
                            <div
                                class="absolute inset-x-0 bottom-0 h-14 bg-gradient-to-t from-black/40 to-transparent pointer-events-none">
                            </div>

                            <!-- Badge Tipe -->
                            <div class="absolute top-4 left-4 z-10 flex items-center gap-2">
                                <span
                                    class="px-3.5 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider bg-[#2D231C]/40 backdrop-blur-md text-[#FAF6EE]">
                                    {{ $detailRoom->room_type }} • Lantai {{ $detailRoom->floor }}
                                </span>
                                @if ($detailRoom->status === 'available')
                                    <span
                                        class="px-3 py-1.5 rounded-full text-[11px] font-bold bg-[#5B8552]/90 backdrop-blur-md text-[#FAF6EE]">
                                        Tersedia
                                    </span>
                                @elseif($detailRoom->status === 'occupied')
                                    <span
                                        class="px-3 py-1.5 rounded-full text-[11px] font-bold bg-[#2D231C]/65 backdrop-blur-md text-[#FAF6EE]">
                                        Terisi
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1.5 rounded-full text-[11px] font-bold bg-[#B8845A]/90 backdrop-blur-md text-[#FAF6EE]">
                                        Konfirmasi
                                    </span>
                                @endif
                            </div>

                            <!-- Tombol Close (Kanan Atas) -->
                            <button type="button" wire:click="closeRoomDetailModal"
                                class="absolute top-3.5 right-3.5 z-10 w-8 h-8 rounded-full bg-[#2D231C]/35 backdrop-blur-md text-[#FAF6EE] hover:bg-[#2D231C]/55 flex items-center justify-center transition cursor-pointer"
                                title="Tutup">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>

                            <!-- Panah Kiri / Kanan -->
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

                            <!-- Counter & Dots Bawah -->
                            <div x-show="images.length > 1"
                                class="absolute bottom-2.5 inset-x-3.5 z-10 flex items-center justify-between">
                                <span
                                    class="px-2.5 py-0.5 rounded-full bg-white/20 backdrop-blur-md text-white text-[10px] font-semibold">
                                    Foto <span x-text="active + 1"></span> dari <span x-text="images.length"></span>
                                </span>
                                <div class="flex items-center gap-1.5">
                                    <template x-for="(img, idx) in images" :key="idx">
                                        <button type="button" x-on:click="active = idx"
                                            :class="active === idx ? 'w-4 bg-white' : 'w-1.5 bg-white/60'"
                                            class="h-1.5 rounded-full transition-all cursor-pointer"></button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- 2. KONTEN DETAIL -->
                        <div
                            class="p-5 space-y-4 overflow-y-auto flex-1 text-xs
                                [&::-webkit-scrollbar]:w-1.5
                                [&::-webkit-scrollbar-track]:bg-transparent
                                [&::-webkit-scrollbar-thumb]:bg-[#D5C6B2]
                                [&::-webkit-scrollbar-thumb]:rounded-full
                                hover:[&::-webkit-scrollbar-thumb]:bg-[#A67B5B]">

                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-2">
                                <div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <h3 class="text-base font-extrabold text-[#5C402C] leading-snug">
                                            {{ $detailRoom->name }}</h3>
                                        <span
                                            class="px-2 py-0.5 rounded-md bg-[#EFE4D4] text-[#8F6547] font-mono font-bold text-[10px]">
                                            #{{ $detailRoom->room_number }}
                                        </span>
                                    </div>
                                    <p class="text-[11px] text-[#8F6547] mt-0.5">
                                        Luas kamar <strong class="text-[#5C402C]">{{ $detailRoom->size }}</strong> •
                                        Berada di <strong class="text-[#5C402C]">Lantai {{ $detailRoom->floor }}</strong>
                                    </p>
                                </div>

                                <div class="sm:text-right shrink-0">
                                    <div class="text-base font-extrabold text-[#5C402C]">
                                        {{ $detailRoom->formatted_monthly_price }}<span
                                            class="text-[11px] font-normal text-[#8F6547]"> /bulan</span>
                                    </div>
                                    @if ($detailRoom->annual_price)
                                        <span class="text-[10px] text-[#8F6547] block">Tarif Tahunan:
                                            {{ $detailRoom->formatted_annual_price }}</span>
                                    @endif
                                </div>
                            </div>

                            @if ($detailRoom->description)
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#8F6547] block my-2">
                                    Deskripsi Kamar
                                </span>
                                <div
                                    class="p-3.5 rounded-xl bg-[#F3ECE0] text-[#5C402C] text-xs leading-relaxed break-words">
                                    <p>{{ trim($detailRoom->description) }}</p>
                                </div>
                            @endif

                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider text-[#8F6547] block mb-2">
                                    Fasilitas Kamar
                                </span>

                                @if (is_array($detailRoom->facilities) && count($detailRoom->facilities) > 0)
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                                        @foreach ($detailRoom->facilities as $fac)
                                            <div
                                                class="flex items-center gap-1.5 px-2.5 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-[11px]">
                                                <svg class="w-3.5 h-3.5 text-[#A67B5B] shrink-0" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span class="truncate">{{ $fac }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-[11px] text-[#9C785C]">Belum ada rincian fasilitas.</p>
                                @endif
                            </div>
                        </div>

                        <!-- 3. FOOTER AKSI -->
                        <div class="px-5 py-3.5 bg-[#F3ECE0]/70 flex items-center justify-end gap-2.5 shrink-0">
                            <button type="button" wire:click="closeRoomDetailModal"
                                class="px-4 py-2 rounded-full bg-[#EFE4D4] text-[#5C402C] font-semibold text-xs hover:bg-[#E2D6C3] transition cursor-pointer">
                                Tutup
                            </button>
                            <button type="button" wire:click="bookFromDetail({{ $detailRoom->id }})"
                                class="px-5 py-2 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] transition cursor-pointer">
                                {{ $detailRoom->status === 'available' ? 'Ajukan Sewa' : 'Antri Sewa Kamar' }}
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        @endteleport
    @endif

    <!-- Modal Pengajuan Sewa (GAYA AWAL + POSISI TENGAH) -->
    @if ($showBookingModal && $selectedRoom)
        @teleport('body')
            <div class="fixed inset-0 z-[9999] overflow-y-auto" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div class="fixed inset-0 bg-[#2D231C]/60 backdrop-blur-xs transition-opacity"
                    wire:click="closeBookingModal"></div>

                <div class="relative z-10 min-h-screen w-full flex items-center justify-center p-4 text-center">
                    <div
                        class="relative w-full max-w-2xl max-h-[86vh] flex flex-col transform overflow-hidden rounded-3xl bg-[#FAF6EE] text-left shadow-2xl transition-all">

                        <div class="px-6 py-4 bg-[#3B2E25] text-[#FAF6EE] flex items-center justify-between shrink-0">
                            <div>
                                <span class="text-[11px] font-semibold text-[#DEC3AC] uppercase tracking-wider">Pengajuan
                                    Sewa Kamar</span>
                                <h3 class="text-base font-bold text-[#FAF6EE]">{{ $selectedRoom->name }} — Kamar
                                    {{ $selectedRoom->room_number }}</h3>
                            </div>
                            <button wire:click="closeBookingModal" class="text-[#C4B4A5] hover:text-[#FAF6EE] p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-6 space-y-5 overflow-y-auto flex-1">
                            @if (session()->has('booking_error'))
                                <div class="p-3.5 rounded-2xl bg-rose-50 text-rose-800 text-sm">
                                    {{ session('booking_error') }}
                                </div>
                            @endif

                            @if ($bookingSuccess && $createdBooking)
                                <div class="py-4 space-y-4">
                                    <div
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-[#EFE4D4] text-[#8F6547] text-xs font-bold">
                                        Pengajuan Tercatat
                                    </div>
                                    <h4 class="text-xl font-bold text-[#2D231C]">Booking Berhasil Dibuat</h4>
                                    <p class="text-sm text-[#6E5F53] leading-relaxed">
                                        @if ($createdBooking->status === 'waiting_renewal_confirmation')
                                            Pengajuan Anda masuk ke daftar tunggu. Pembayaran baru perlu dilakukan setelah
                                            penghuni saat ini mengonfirmasi tanggal keluar.
                                        @else
                                            Kode booking Anda adalah <span
                                                class="font-mono font-bold text-[#8F6547] bg-[#EFE4D4] px-2.5 py-0.5 rounded-full">{{ $createdBooking->booking_code }}</span>.
                                            Silakan lanjutkan pembayaran melalui halaman tagihan penyewa.
                                        @endif
                                    </p>

                                    <div class="p-4 rounded-2xl bg-[#F3ECE0] text-xs space-y-2">
                                        <div class="flex justify-between"><span class="text-[#6E5F53]">Kamar</span>
                                            <strong class="text-[#2D231C]">{{ $selectedRoom->room_number }}
                                                ({{ $selectedRoom->room_type }})</strong>
                                        </div>
                                        <div class="flex justify-between"><span class="text-[#6E5F53]">Periode Sewa</span>
                                            <strong
                                                class="text-[#2D231C]">{{ $createdBooking->start_date->format('d M Y') }}
                                                – {{ $createdBooking->end_date->format('d M Y') }}</strong>
                                        </div>
                                        <div class="flex justify-between"><span class="text-[#6E5F53]">Skema Bayar</span>
                                            <strong
                                                class="text-[#2D231C]">{{ $createdBooking->payment_scheme === 'dp' ? 'DP 50%' : 'Lunas' }}</strong>
                                        </div>
                                        <div class="flex justify-between"><span class="text-[#6E5F53]">Total Biaya</span>
                                            <strong
                                                class="text-[#8F6547] font-bold">{{ $createdBooking->formatted_total_price }}</strong>
                                        </div>
                                    </div>

                                    <div class="pt-3 flex flex-col sm:flex-row gap-2.5">
                                        <a href="{{ route('tenant.dashboard') }}"
                                            class="px-5 py-2.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-semibold text-sm text-center hover:bg-[#8F6547] transition">
                                            Ke Dashboard Penyewa
                                        </a>
                                        <a href="{{ route('tenant.payments') }}"
                                            class="px-5 py-2.5 rounded-full text-[#2D231C] font-semibold text-sm text-center hover:bg-[#F3ECE0] transition">
                                            Upload Bukti Transfer
                                        </a>
                                    </div>
                                </div>
                            @else
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-[#2D231C] mb-1">Tanggal Mulai Sewa
                                            <span class="text-rose-600">*</span></label>
                                        <input type="date" wire:model.live="startDate"
                                            class="w-full px-3.5 py-2 rounded-xl bg-[#F3ECE0] text-sm outline-none">
                                        @error('startDate')
                                            <span class="text-xs text-rose-600">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-xs font-semibold text-[#2D231C] mb-1">Durasi Sewa <span
                                                class="text-rose-600">*</span></label>
                                        <select wire:model.live="durationMonths"
                                            class="w-full px-3.5 py-2 rounded-xl bg-[#F3ECE0] text-sm outline-none">
                                            <option value="1">1 Bulan</option>
                                            <option value="3">3 Bulan</option>
                                            <option value="6">6 Bulan</option>
                                            <option value="12">12 Bulan (1 Tahun)</option>
                                            <option value="24">24 Bulan (2 Tahun)</option>
                                        </select>
                                        @error('durationMonths')
                                            <span class="text-xs text-rose-600">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                @if ($hasConflict)
                                    <div class="p-4 rounded-2xl bg-rose-50 text-rose-900 space-y-1.5">
                                        <p class="font-bold text-sm text-rose-800">Jadwal Kamar Tidak Tersedia di Tanggal
                                            Ini</p>
                                        <p class="text-xs leading-relaxed text-rose-700">{{ $conflictMessage }}</p>
                                        <p class="text-xs font-medium text-rose-800 pt-1">
                                            Pilih tanggal mulai setelah <strong>{{ $currentOccupantEndDate }}</strong>
                                            untuk masuk ke daftar antrian kamar ini.
                                        </p>
                                    </div>
                                @endif

                                @if ($isWaitingList && !$hasConflict)
                                    <div class="p-4 rounded-2xl bg-[#EFE4D4] text-[#6E4D36] space-y-1.5">
                                        <p class="font-bold text-sm">Masuk Daftar Tunggu (Waiting List)</p>
                                        <p class="text-xs leading-relaxed">{{ $waitingListExplanation }}</p>
                                        <p class="text-[11px] opacity-85">
                                            Tagihan belum perlu dibayar sebelum penghuni sebelumnya mengonfirmasi
                                            kepindahan.
                                        </p>
                                    </div>
                                @endif

                                <div>
                                    <label class="block text-xs font-semibold text-[#2D231C] mb-2">Skema Pembayaran</label>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <label
                                            class="flex items-start gap-3 p-3.5 rounded-2xl cursor-pointer transition {{ $paymentScheme === 'full' ? 'bg-[#EFE4D4]/75' : 'bg-[#F3ECE0]/60 hover:bg-[#EFE4D4]/40' }}">
                                            <input type="radio" wire:model.live="paymentScheme" value="full"
                                                class="mt-0.5 accent-[#A67B5B]">
                                            <div>
                                                <p class="text-sm font-semibold text-[#2D231C]">Bayar Lunas (100%)</p>
                                                <p class="text-xs text-[#6E5F53]">Pelunasan penuh di awal sewa</p>
                                            </div>
                                        </label>

                                        <label
                                            class="flex items-start gap-3 p-3.5 rounded-2xl cursor-pointer transition {{ $paymentScheme === 'dp' ? 'bg-[#EFE4D4]/75' : 'bg-[#F3ECE0]/60 hover:bg-[#EFE4D4]/40' }}">
                                            <input type="radio" wire:model.live="paymentScheme" value="dp"
                                                class="mt-0.5 accent-[#A67B5B]">
                                            <div>
                                                <p class="text-sm font-semibold text-[#2D231C]">Down Payment (DP 50%)</p>
                                                <p class="text-xs text-[#6E5F53]">Sisa dilunasi sebelum masuk</p>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <div class="p-4 rounded-2xl bg-[#F3ECE0] space-y-2 text-xs">
                                    <div class="flex justify-between text-[#6E5F53]">
                                        <span>Tanggal Selesai Sewa</span>
                                        <span class="font-semibold text-[#2D231C]">{{ $calculatedEndDate ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between text-[#6E5F53]">
                                        <span>Total Biaya Sewa</span>
                                        <span class="font-bold text-sm text-[#2D231C]">Rp
                                            {{ number_format($calculatedTotalPrice, 0, ',', '.') }}</span>
                                    </div>
                                    @if ($paymentScheme === 'dp')
                                        <div class="pt-2 flex justify-between text-[#8F6547] font-semibold">
                                            <span>Pembayaran DP (50%)</span>
                                            <span>Rp {{ number_format($calculatedDpAmount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-[#6E5F53]">
                                            <span>Sisa Pelunasan</span>
                                            <span class="font-semibold">Rp
                                                {{ number_format($calculatedRemainingAmount, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div>
                                    <label class="block text-xs font-semibold text-[#2D231C] mb-1">Catatan
                                        (Opsional)</label>
                                    <textarea wire:model="notes" rows="2" placeholder="Perkiraan jam kedatangan atau catatan tambahan..."
                                        class="w-full px-3 py-2 rounded-xl bg-[#F3ECE0] text-xs outline-none"></textarea>
                                </div>

                                <div class="pt-3 flex items-center justify-end gap-2.5">
                                    <button type="button" wire:click="closeBookingModal"
                                        class="px-4 py-2 rounded-full text-[#2D231C] font-medium text-xs hover:bg-[#F3ECE0]">
                                        Batal
                                    </button>

                                    <button type="button" wire:click="submitBooking"
                                        {{ $hasConflict ? 'disabled' : '' }}
                                        class="px-5 py-2 rounded-full font-semibold text-xs text-[#FAF6EE] transition
                                            {{ $hasConflict ? 'bg-stone-400 cursor-not-allowed' : 'bg-[#A67B5B] hover:bg-[#8F6547]' }}">
                                        @if ($hasConflict)
                                            Pilih Tanggal Lain
                                        @elseif($isWaitingList)
                                            Masuk Daftar Antrian
                                        @else
                                            Kirim Pengajuan Sewa
                                        @endif
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endteleport
    @endif

    <!-- SECTION FASILITAS KOST-->
    <section id="keunggulan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 mb-7">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-[#2D231C] tracking-tight">Fasilitas Kost</h2>
                <p class="text-xs sm:text-sm text-[#6E5F53] mt-1">Kenyamanan bersama untuk seluruh penghuni</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
            <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                <div class="flex items-center gap-3 mb-2.5">
                    <div
                        class="w-9 h-9 rounded-xl bg-[#EFE4D4] text-[#A67B5B] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-[#2D231C] leading-snug">Akses 24 Jam</h4>
                </div>
                <p class="text-xs text-[#6E5F53] leading-relaxed">Gerbang kartu & CCTV aktif sepanjang hari.</p>
            </div>

            <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                <div class="flex items-center gap-3 mb-2.5">
                    <div
                        class="w-9 h-9 rounded-xl bg-[#EFE4D4] text-[#A67B5B] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0" />
                        </svg>
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-[#2D231C] leading-snug">WiFi Tiap Lantai</h4>
                </div>
                <p class="text-xs text-[#6E5F53] leading-relaxed">Koneksi fiber stabil untuk kerja & kuliah.</p>
            </div>

            <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                <div class="flex items-center gap-3 mb-2.5">
                    <div
                        class="w-9 h-9 rounded-xl bg-[#EFE4D4] text-[#A67B5B] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-[#2D231C] leading-snug">Perbaikan Cepat</h4>
                </div>
                <p class="text-xs text-[#6E5F53] leading-relaxed">Lapor kendala kamar langsung dari akun.</p>
            </div>

            <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                <div class="flex items-center gap-3 mb-2.5">
                    <div
                        class="w-9 h-9 rounded-xl bg-[#EFE4D4] text-[#A67B5B] flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <h4 class="text-sm sm:text-base font-bold text-[#2D231C] leading-snug">Bisa DP 50%</h4>
                </div>
                <p class="text-xs text-[#6E5F53] leading-relaxed">Booking kamar lebih awal dengan uang muka.</p>
            </div>
        </div>
    </section>

    <!-- SECTION ALUR SEWA -->
    <section id="alur-sewa" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#2D231C] tracking-tight">Cara Booking & Sistem Antrian</h2>
            <p class="text-xs sm:text-sm text-[#6E5F53] mt-1.5">Ikuti 4 tahapan terstruktur mulai dari memilih kamar
                hingga siap check-in.</p>
        </div>

        <div class="space-y-0">
            <!-- LANGKAH 1 -->
            <div class="grid grid-cols-1 md:grid-cols-[1fr_72px_1fr] items-center gap-4 md:gap-0 pb-8 md:pb-0">
                <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                    <div class="flex items-center gap-2 text-xs font-semibold text-[#8F6547] mb-1.5">
                        <span>Langkah 1</span>
                    </div>
                    <h4 class="text-base font-bold text-[#2D231C]">Pilih Kamar & Tanggal Masuk</h4>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-3 text-[11px] text-[#6E5F53]">
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#A67B5B]"></span>
                            1–24 Bulan
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#5B8552]"></span>
                            Cek Real-time
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#B8845A]"></span>
                            Tanpa Chat Admin
                        </span>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-center self-stretch">
                    <div class="w-0.5 flex-1 bg-transparent"></div>
                    <div
                        class="w-8 h-8 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs flex items-center justify-center shrink-0 my-1">
                        1
                    </div>
                    <div class="w-0.5 flex-1 bg-[#DFD2BE]"></div>
                </div>

                <div class="md:pl-4 md:py-6">
                    <div class="flex items-center gap-2 md:hidden mb-1">
                        <span
                            class="w-6 h-6 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs inline-flex items-center justify-center">1</span>
                        <span class="text-xs font-bold text-[#8F6547]">Tahap Pertama</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#2D231C]">Tentukan Unit & Durasi Sewa</h3>
                    <p class="text-xs sm:text-sm text-[#6E5F53] mt-1.5 leading-relaxed">
                        Buka katalog kamar, tinjau fasilitas serta foto tiap ruangan, lalu pilih tanggal mulai masuk dan
                        durasi sewa sesuai kebutuhan Anda.
                    </p>
                </div>
            </div>

            <!-- LANGKAH 2 -->
            <div class="grid grid-cols-1 md:grid-cols-[1fr_72px_1fr] items-center gap-4 md:gap-0 pb-8 md:pb-0">
                <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                    <div class="flex items-center gap-2 text-xs font-semibold text-[#8F6547] mb-1.5">
                        <span>Langkah 2</span>
                    </div>
                    <h4 class="text-base font-bold text-[#2D231C]">Cek Bentrok & Antrian Otomatis</h4>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-3 text-[11px] text-[#6E5F53]">
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#A67B5B]"></span>
                            Deteksi Jadwal
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#5B8552]"></span>
                            Opsi Waiting List
                        </span>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-center self-stretch">
                    <div class="w-0.5 flex-1 bg-[#DFD2BE]"></div>
                    <div
                        class="w-8 h-8 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs flex items-center justify-center shrink-0 my-1">
                        2
                    </div>
                    <div class="w-0.5 flex-1 bg-[#DFD2BE]"></div>
                </div>

                <div class="md:pl-4 md:py-6">
                    <div class="flex items-center gap-2 md:hidden mb-1">
                        <span
                            class="w-6 h-6 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs inline-flex items-center justify-center">2</span>
                        <span class="text-xs font-bold text-[#8F6547]">Tahap Kedua</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#2D231C]">Validasi Ketersediaan Jadwal</h3>
                    <p class="text-xs sm:text-sm text-[#6E5F53] mt-1.5 leading-relaxed">
                        Sistem mengecek jadwal penghuni aktif secara otomatis. Jika kamar sedang terisi, pengajuan Anda
                        dicatat sebagai daftar tunggu setelah masa sewa penghuni lama selesai.
                    </p>
                </div>
            </div>

            <!-- LANGKAH 3 -->
            <div class="grid grid-cols-1 md:grid-cols-[1fr_72px_1fr] items-center gap-4 md:gap-0 pb-8 md:pb-0">
                <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                    <div class="flex items-center gap-2 text-xs font-semibold text-[#8F6547] mb-1.5">
                        <span>Langkah 3</span>
                    </div>
                    <h4 class="text-base font-bold text-[#2D231C]">Transfer & Unggah Bukti Bayar</h4>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-3 text-[11px] text-[#6E5F53]">
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#A67B5B]"></span>
                            Lunas 100%
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#B8845A]"></span>
                            Bisa DP 50%
                        </span>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-center self-stretch">
                    <div class="w-0.5 flex-1 bg-[#DFD2BE]"></div>
                    <div
                        class="w-8 h-8 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs flex items-center justify-center shrink-0 my-1">
                        3
                    </div>
                    <div class="w-0.5 flex-1 bg-[#DFD2BE]"></div>
                </div>

                <div class="md:pl-4 md:py-6">
                    <div class="flex items-center gap-2 md:hidden mb-1">
                        <span
                            class="w-6 h-6 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs inline-flex items-center justify-center">3</span>
                        <span class="text-xs font-bold text-[#8F6547]">Tahap Ketiga</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#2D231C]">Pilih Skema Lunas atau DP 50%</h3>
                    <p class="text-xs sm:text-sm text-[#6E5F53] mt-1.5 leading-relaxed">
                        Transfer biaya sewa ke rekening resmi pengelola dan unggah bukti pembayaran langsung melalui
                        dashboard penyewa dengan kode booking unik Anda.
                    </p>
                </div>
            </div>

            <!-- LANGKAH 4 -->
            <div class="grid grid-cols-1 md:grid-cols-[1fr_72px_1fr] items-center gap-4 md:gap-0">
                <div class="bg-[#FAF6EE] rounded-2xl p-5 shadow-2xs transition">
                    <div class="flex items-center gap-2 text-xs font-semibold text-[#8F6547] mb-1.5">
                        <span>Langkah 4</span>
                    </div>
                    <h4 class="text-base font-bold text-[#2D231C]">Verifikasi & Siap Check-in</h4>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1.5 mt-3 text-[11px] text-[#6E5F53]">
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#5B8552]"></span>
                            Invoice PDF
                        </span>
                        <span class="inline-flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-[#A67B5B]"></span>
                            Pengingat Perpanjangan
                        </span>
                    </div>
                </div>

                <div class="hidden md:flex flex-col items-center self-stretch">
                    <div class="w-0.5 flex-1 bg-[#DFD2BE]"></div>
                    <div
                        class="w-8 h-8 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs flex items-center justify-center shrink-0 my-1">
                        4
                    </div>
                    <div class="w-0.5 flex-1 bg-transparent"></div>
                </div>

                <div class="md:pl-4 md:py-6">
                    <div class="flex items-center gap-2 md:hidden mb-1">
                        <span
                            class="w-6 h-6 rounded-full bg-[#EFE4D4] text-[#8F6547] font-bold text-xs inline-flex items-center justify-center">4</span>
                        <span class="text-xs font-bold text-[#8F6547]">Tahap Keempat</span>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-[#2D231C]">Kamar Aktif Sesuai Jadwal</h3>
                    <p class="text-xs sm:text-sm text-[#6E5F53] mt-1.5 leading-relaxed">
                        Setelah pembayaran diverifikasi pengelola, status kamar langsung aktif, kwitansi PDF siap
                        diunduh, dan Anda siap menempati kamar sesuai tanggal masuk.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION FAQ (PERTANYAAN UMUM) -->
    <section id="faq" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-[#2D231C] tracking-tight">Pertanyaan Umum</h2>
            <p class="text-xs sm:text-sm text-[#6E5F53] mt-1.5">Jawaban singkat seputar cara booking, pembayaran DP,
                dan aturan kost.</p>
        </div>

        <div x-data="{ activeFaq: 0 }" class="space-y-3">
            <!-- FAQ 1 -->
            <div class="bg-[#FAF6EE] rounded-2xl transition-colors duration-200"
                :class="activeFaq === 0 ? 'ring-1 ring-[#D8C7AF]' : 'hover:bg-[#FAF6EE]/80'">
                <button type="button" @click="activeFaq = activeFaq === 0 ? null : 0"
                    class="w-full px-5 py-4 flex items-center justify-between gap-4 text-left cursor-pointer">
                    <span class="text-sm sm:text-base font-bold text-[#2D231C] transition-colors"
                        :class="activeFaq === 0 ? 'text-[#8F6547]' : ''">
                        Apakah saya bisa membayar DP 50%?
                    </span>
                    <span
                        class="w-7 h-7 rounded-full text-[#8F6547] flex items-center justify-center shrink-0 transition-transform duration-300 ease-out"
                        :class="activeFaq === 0 ? 'rotate-180' : ''">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 0" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="px-5 pb-4 text-xs sm:text-sm text-[#6E5F53] leading-relaxed">
                    <div class="pt-3 border-t border-[#EFE4D4]">
                        Ya, jika opsi DP tersedia untuk kamar tersebut, Anda dapat membayar 50% terlebih dahulu sesuai
                        ketentuan pengelola, dan sisanya dilunasi sebelum tanggal masuk.
                    </div>
                </div>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-[#FAF6EE] rounded-2xl transition-colors duration-200"
                :class="activeFaq === 1 ? 'ring-1 ring-[#D8C7AF]' : 'hover:bg-[#FAF6EE]/80'">
                <button type="button" @click="activeFaq = activeFaq === 1 ? null : 1"
                    class="w-full px-5 py-4 flex items-center justify-between gap-4 text-left cursor-pointer">
                    <span class="text-sm sm:text-base font-bold text-[#2D231C] transition-colors"
                        :class="activeFaq === 1 ? 'text-[#8F6547]' : ''">
                        Bagaimana jika kamar yang saya inginkan sedang terisi?
                    </span>
                    <span
                        class="w-7 h-7 rounded-full text-[#8F6547] flex items-center justify-center shrink-0 transition-transform duration-300 ease-out"
                        :class="activeFaq === 1 ? 'rotate-180' : ''">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 1" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="px-5 pb-4 text-xs sm:text-sm text-[#6E5F53] leading-relaxed">
                    <div class="pt-3 border-t border-[#EFE4D4]">
                        Anda tetap dapat mengajukan sewa untuk tanggal setelah masa sewa penghuni saat ini berakhir.
                        Pengajuan Anda akan masuk ke daftar antrian dan pembayaran baru dibuka setelah penghuni lama
                        mengonfirmasi kepindahan.
                    </div>
                </div>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-[#FAF6EE] rounded-2xl transition-colors duration-200"
                :class="activeFaq === 2 ? 'ring-1 ring-[#D8C7AF]' : 'hover:bg-[#FAF6EE]/80'">
                <button type="button" @click="activeFaq = activeFaq === 2 ? null : 2"
                    class="w-full px-5 py-4 flex items-center justify-between gap-4 text-left cursor-pointer">
                    <span class="text-sm sm:text-base font-bold text-[#2D231C] transition-colors"
                        :class="activeFaq === 2 ? 'text-[#8F6547]' : ''">
                        Berapa lama proses verifikasi setelah saya unggah bukti transfer?
                    </span>
                    <span
                        class="w-7 h-7 rounded-full text-[#8F6547] flex items-center justify-center shrink-0 transition-transform duration-300 ease-out"
                        :class="activeFaq === 2 ? 'rotate-180' : ''">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 2" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="px-5 pb-4 text-xs sm:text-sm text-[#6E5F53] leading-relaxed">
                    <div class="pt-3 border-t border-[#EFE4D4]">
                        Pengelola memverifikasi pembayaran maksimal 1×24 jam setelah bukti transfer diunggah. Setelah
                        disetujui, status kamar otomatis aktif dan kwitansi PDF bisa langsung diunduh dari dashboard
                        penyewa.
                    </div>
                </div>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-[#FAF6EE] rounded-2xl transition-colors duration-200"
                :class="activeFaq === 3 ? 'ring-1 ring-[#D8C7AF]' : 'hover:bg-[#FAF6EE]/80'">
                <button type="button" @click="activeFaq = activeFaq === 3 ? null : 3"
                    class="w-full px-5 py-4 flex items-center justify-between gap-4 text-left cursor-pointer">
                    <span class="text-sm sm:text-base font-bold text-[#2D231C] transition-colors"
                        :class="activeFaq === 3 ? 'text-[#8F6547]' : ''">
                        Apakah biaya sewa bulanan sudah termasuk listrik dan WiFi?
                    </span>
                    <span
                        class="w-7 h-7 rounded-full text-[#8F6547] flex items-center justify-center shrink-0 transition-transform duration-300 ease-out"
                        :class="activeFaq === 3 ? 'rotate-180' : ''">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </button>
                <div x-show="activeFaq === 3" x-cloak x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="px-5 pb-4 text-xs sm:text-sm text-[#6E5F53] leading-relaxed">
                    <div class="pt-3 border-t border-[#EFE4D4]">
                        Tarif sewa sudah mencakup akses WiFi tiap lantai, air bersih, serta keamanan 24 jam. Untuk
                        pemakaian listrik masing-masing kamar menggunakan sistem token prabayar mandiri.
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>