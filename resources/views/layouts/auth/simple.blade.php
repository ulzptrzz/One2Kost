<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-[#F5EFE6]" style="color-scheme: light;">
    <head>
        @include('partials.head')
        <script>
            document.documentElement.classList.remove('dark');
        </script>
    </head>
    <body class="min-h-screen bg-[#F5EFE6] text-[#5C402C] antialiased selection:bg-[#A67B5B] selection:text-[#FAF6EE]">
        
        <!-- Full-Width Split Screen (Tanpa Card Pembungkus) -->
        <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-2">
            
            <!-- Sisi Kiri: Area Form Langsung di Atas Background -->
            <div class="flex flex-col justify-between px-6 py-8 sm:px-14 lg:px-20 xl:px-28">
                
                <!-- Navigasi Kembali di Pojok Kiri Atas -->
                <div>
                    <a href="{{ route('home') }}" wire:navigate
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#8F6547] hover:text-[#5C402C] transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>

                <!-- Form Login / Register (Tengah Vertikal) -->
                <div class="w-full max-w-md mx-auto my-auto py-8">
                    {{ $slot }}
                </div>

                <!-- Footer Kecil -->
                <div class="text-[11px] text-[#9C785C]">
                    &copy; {{ date('Y') }} Kost2Kost &bull; Sistem Pengelolaan Hunian Kost
                </div>
            </div>

            <!-- Sisi Kanan: Hero Slideshow Gambar Otomatis -->
            <div x-data="{
                    active: 0,
                    slides: [
                        {
                            image: 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=1400&q=85',
                            badge: 'HUNIAN NYAMAN & TERTATA',
                            title: 'Kamar siap huni dengan fasilitas lengkap dan bersih.',
                            desc: 'Cek ketersediaan unit secara langsung dan pilih tanggal masuk sesuai kebutuhanmu.'
                        },
                        {
                            image: 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?auto=format&fit=crop&w=1400&q=85',
                            badge: 'BOOKING & ANTRIAN PRAKTIS',
                            title: 'Tersedia opsi pembayaran DP 50% untuk mengamankan kamar.',
                            desc: 'Pantau status konfirmasi pembayaran dan jadwal masuk langsung dari akun penyewa.'
                        },
                        {
                            image: 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=1400&q=85',
                            badge: 'TAGIHAN BULANAN TRANSPARAN',
                            title: 'Kelola riwayat sewa dan perpanjangan kamar dalam satu tempat.',
                            desc: 'Tidak perlu repot mencatat manual, semua riwayat transaksi tersimpan rapi.'
                        }
                    ],
                    timer: null,
                    start() {
                        this.timer = setInterval(() => {
                            this.active = (this.active + 1) % this.slides.length;
                        }, 4500);
                    },
                    goTo(index) {
                        clearInterval(this.timer);
                        this.active = index;
                        this.start();
                    }
                 }"
                 x-init="start()"
                 class="relative hidden lg:block w-full h-full min-h-screen overflow-hidden bg-[#2D231C]">

                <!-- Daftar Slide Gambar -->
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="active === index"
                         x-transition:enter="transition-opacity duration-1000 ease-out"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-1000 ease-in"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0">
                        
                        <img :src="slide.image"
                             :alt="slide.title"
                             class="w-full h-full object-cover scale-105 transition-transform duration-[6000ms] ease-out"
                             :class="active === index ? 'scale-100' : 'scale-105'">

                        <!-- Overlay Gradasi Hangat -->
                        <div class="absolute inset-0 bg-gradient-to-t from-[#2D231C]/85 via-[#2D231C]/30 to-[#2D231C]/10"></div>

                        <!-- Teks Keterangan Slide -->
                        <div class="absolute bottom-14 left-12 right-12 text-[#FAF6EE] space-y-3">
                            <span x-text="slide.badge"
                                  class="inline-block px-4 py-1.5 rounded-full text-[11px] font-semibold uppercase tracking-widest bg-[#FAF6EE]/15 backdrop-blur-md border border-[#FAF6EE]/25">
                            </span>
                            <h2 x-text="slide.title" class="text-2xl xl:text-3xl font-bold leading-snug max-w-lg"></h2>
                            <p x-text="slide.desc" class="text-xs xl:text-sm text-[#E6DBC9] leading-relaxed max-w-md"></p>
                        </div>
                    </div>
                </template>

                <!-- Indikator Titik Slideshow (Pojok Kanan Bawah seperti Hero) -->
                <div class="absolute bottom-7 right-12 z-20 flex items-center gap-2">
                    <template x-for="(slide, index) in slides" :key="'dot-' + index">
                        <button type="button"
                                @click="goTo(index)"
                                :aria-label="'Slide ' + (index + 1)"
                                class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                                :class="active === index ? 'w-7 bg-[#FAF6EE]' : 'w-2 bg-[#FAF6EE]/45 hover:bg-[#FAF6EE]/75'">
                        </button>
                    </template>
                </div>

            </div>

        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>