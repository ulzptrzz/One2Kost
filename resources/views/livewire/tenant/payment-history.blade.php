<div class="space-y-5 pb-24">

    <!-- HEADER BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-[#5C402C] tracking-tight">Riwayat Sewa & Bukti Pembayaran</h2>
            <p class="text-xs text-[#8F6547]">Pantau informasi kamar aktif, masa berlaku sewa, serta kelola bukti transfer pembayaran Anda dalam satu halaman.</p>
        </div>
        <button wire:click="openUploadModal"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] transition cursor-pointer shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Unggah Bukti Transfer
        </button>
    </div>

    <!-- NOTIFIKASI SUKSES / PERPANJANGAN -->
    @if(session()->has('success') || session()->has('renewal_message'))
        <div class="p-3.5 rounded-lg bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>{{ session('success') ?? session('renewal_message') }}</div>
        </div>
    @endif

    <!-- PERINGATAN SISA PELUNASAN DP -->
    @if($dpBookingPendingSettlement)
        <div class="p-4 rounded-lg bg-[#F7ECD9] border border-[#E3C898] text-[#5C402C]">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-lg bg-[#C2812E] text-[#FAF6EE] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#C2812E]/20 text-[#8A5A19] uppercase">Penting</span>
                        <h3 class="text-sm font-bold text-[#5C402C] mt-1">Anda Memiliki Sisa Tagihan Pelunasan</h3>
                        <p class="text-xs text-[#7A563C] mt-0.5 leading-relaxed">
                            DP untuk <strong>Kamar {{ $dpBookingPendingSettlement->room->room_number }}</strong> telah diterima. Mohon lunasi sisa tagihan sebesar <strong class="text-[#9E4735] font-extrabold">{{ $dpBookingPendingSettlement->formatted_remaining_amount }}</strong> sebelum {{ $dpBookingPendingSettlement->start_date->format('d M Y') }}.
                        </p>
                    </div>
                </div>
                <button wire:click="openUploadModal" class="px-4 py-2 rounded-lg bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] font-bold text-xs shrink-0 cursor-pointer">
                    Upload Pelunasan
                </button>
            </div>
        </div>
    @endif

    <!-- BAGIAN 1: INFORMASI KAMAR & MASA SEWA SAYA -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="px-5 py-3 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#8F6547]">Informasi Kamar & Masa Sewa Saya</h3>
            @if($activeBooking)
                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold {{ $activeBooking->status === 'active' ? 'bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]' : 'bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]' }}">
                    {{ $activeBooking->status_label }}
                </span>
            @endif
        </div>

        <div class="p-5">
            @if($activeBooking)
                <div class="flex flex-col sm:flex-row gap-5">
                    <div class="w-full sm:w-44 h-32 rounded-lg overflow-hidden bg-[#EFE4D4] shrink-0 relative border border-[#E2D6C3]">
                        <img src="{{ $activeBooking->room->main_image_url }}" alt="Kamar" class="w-full h-full object-cover">
                        <span class="absolute bottom-2 left-2 px-2 py-0.5 rounded text-[10px] font-bold bg-[#5C402C] text-[#FAF6EE]">
                            Lantai {{ $activeBooking->room->floor }}
                        </span>
                    </div>

                    <div class="flex-1 space-y-3">
                        <div>
                            <span class="text-[11px] font-bold text-[#A67B5B] uppercase tracking-wide">{{ $activeBooking->room->room_type }}</span>
                            <h4 class="text-base font-extrabold text-[#5C402C]">{{ $activeBooking->room->name }} (No. {{ $activeBooking->room->room_number }})</h4>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5 text-xs">
                            <div class="p-3 rounded-lg bg-[#F3ECE0] border border-[#E2D6C3]">
                                <span class="text-[#8F6547] block text-[10px] uppercase font-bold">Tanggal Mulai</span>
                                <span class="font-bold text-[#5C402C]">{{ $activeBooking->start_date->format('d M Y') }}</span>
                            </div>
                            <div class="p-3 rounded-lg bg-[#F3ECE0] border border-[#E2D6C3]">
                                <span class="text-[#8F6547] block text-[10px] uppercase font-bold">Tanggal Berakhir</span>
                                <span class="font-bold text-[#5C402C]">{{ $activeBooking->end_date->format('d M Y') }}</span>
                            </div>
                            <div class="p-3 rounded-lg bg-[#F3ECE0] border border-[#E2D6C3]">
                                <span class="text-[#8F6547] block text-[10px] uppercase font-bold">Durasi Sewa</span>
                                <span class="font-bold text-[#5C402C]">{{ $activeBooking->duration_months }} Bulan</span>
                            </div>
                            <div class="p-3 rounded-lg bg-[#F3ECE0] border border-[#E2D6C3]">
                                <span class="text-[#8F6547] block text-[10px] uppercase font-bold">Skema Bayar</span>
                                <span class="font-bold text-[#5C402C]">{{ $activeBooking->payment_scheme === 'dp' ? 'DP 50%' : 'Lunas Penuh' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konfirmasi Perpanjangan Sewa -->
                <div class="mt-4 bg-[#F3ECE0] border border-[#E2D6C3] rounded-lg p-3.5">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-bold text-[#5C402C]">Status Rencana Sewa Mendatang:</p>
                            <div class="flex flex-wrap items-center gap-2 mt-1">
                                <span class="px-2.5 py-0.5 rounded text-[11px] font-bold
                                    {{ $activeBooking->renewal_status === 'renewing' ? 'bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]' : ($activeBooking->renewal_status === 'moving_out' ? 'bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC]' : 'bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC]') }}">
                                    {{ $activeBooking->renewal_status_label }}
                                </span>
                                <span class="text-[11px] text-[#8F6547]">(Membantu penentuan antrian calon penghuni baru)</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button wire:click="confirmRenewal({{ $activeBooking->id }}, 'renewing')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition cursor-pointer {{ $activeBooking->renewal_status === 'renewing' ? 'bg-[#5B8552] text-[#FAF6EE]' : 'bg-[#FAF6EE] border border-[#C6D8BA] text-[#3F5E30] hover:bg-[#EBF2E6]' }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M5 13l4 4L19 7"/></svg>
                                Ingin Perpanjang
                            </button>
                            <button wire:click="confirmRenewal({{ $activeBooking->id }}, 'moving_out')"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold transition cursor-pointer {{ $activeBooking->renewal_status === 'moving_out' ? 'bg-[#9E4735] text-[#FAF6EE]' : 'bg-[#FAF6EE] border border-[#E0B5AC] text-[#9E4735] hover:bg-[#F9E6E2]' }}">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Rencana Pindah
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="py-8 text-center text-[#8F6547] space-y-2.5">
                    <div class="w-11 h-11 rounded-lg bg-[#EFE4D4] border border-[#DDD0BC] mx-auto flex items-center justify-center text-[#8F6547]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <p class="text-xs font-bold text-[#5C402C]">Anda belum memiliki kamar sewa aktif saat ini.</p>
                    <p class="text-xs text-[#8F6547] max-w-sm mx-auto">Silakan lihat katalog kamar di halaman utama untuk memilih kamar dan mengajukan sewa baru.</p>
                    <div class="pt-1">
                        <a href="{{ route('home') }}#katalog" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] text-xs font-bold hover:bg-[#8F6547] transition">
                            Cari Kamar Tersedia
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- PENGAJUAN SEWA & ANTRIAN (JIKA ADA) -->
    @if(count($waitingBookings) > 0)
        <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
            <div class="px-5 py-3 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center gap-2">
                <svg class="w-4 h-4 text-[#8F6547]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="text-xs font-bold uppercase tracking-wider text-[#8F6547]">Status Pengajuan Sewa & Antrian Anda</h3>
            </div>
            <div class="divide-y divide-[#E8DEC9] px-5">
                @foreach($waitingBookings as $wb)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-mono font-bold text-xs bg-[#EFE4D4] border border-[#DDD0BC] px-2 py-0.5 rounded text-[#5C402C] whitespace-nowrap">{{ $wb->booking_code }}</span>
                                <h4 class="font-bold text-xs text-[#5C402C]">{{ $wb->room->name }} (No. {{ $wb->room->room_number }})</h4>
                            </div>
                            <p class="text-xs text-[#8F6547] mt-1">
                                {{ $wb->start_date->format('d M Y') }} s.d. {{ $wb->end_date->format('d M Y') }} ({{ $wb->duration_months }} Bulan) • Total: <strong class="text-[#5C402C]">{{ $wb->formatted_total_price }}</strong>
                            </p>
                        </div>
                        <span class="px-2.5 py-0.5 rounded text-[11px] font-bold self-start sm:self-center whitespace-nowrap {{ $wb->status === 'waiting_renewal_confirmation' ? 'bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]' : 'bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC]' }}">
                            {{ $wb->status_label }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- BAGIAN 2: REKENING TUJUAN -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] p-5 space-y-3">
        <h3 class="text-xs font-bold uppercase tracking-wider text-[#8F6547]">Rekening Bank Resmi Tujuan Transfer Pengelola</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            @foreach($bankAccounts as $bank)
                <div class="p-3.5 rounded-lg bg-[#F3ECE0] border border-[#E2D6C3]">
                    <span class="text-[11px] font-bold text-[#A67B5B] uppercase tracking-wider">{{ $bank->bank_name }}</span>
                    <p class="text-sm font-mono font-extrabold text-[#5C402C] mt-0.5">{{ $bank->account_number }}</p>
                    <p class="text-xs text-[#7A563C] mt-0.5 truncate">a.n. {{ $bank->account_holder }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <!-- TABEL HISTORI & BUKTI PEMBAYARAN -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="px-5 py-3 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#8F6547]">Histori & Bukti Pembayaran</h3>
            <span class="text-xs font-semibold text-[#5C402C]">Total: {{ $payments->total() }} Transaksi</span>
        </div>

        <div class="overflow-x-auto
                    [&::-webkit-scrollbar]:h-2
                    [&::-webkit-scrollbar-track]:bg-[#F3ECE0]
                    [&::-webkit-scrollbar-thumb]:bg-[#C9B49A]
                    [&::-webkit-scrollbar-thumb]:rounded-full
                    hover:[&::-webkit-scrollbar-thumb]:bg-[#A67B5B]">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3] whitespace-nowrap">
                        <th class="px-5 py-3 min-w-[180px]">Kode / Kamar</th>
                        <th class="px-5 py-3 min-w-[175px]">Tipe Pembayaran</th>
                        <th class="px-5 py-3 min-w-[125px]">Nominal</th>
                        <th class="px-5 py-3 min-w-[130px]">Tanggal Transfer</th>
                        <th class="px-5 py-3 min-w-[115px]">Bukti Foto</th>
                        <th class="px-5 py-3 min-w-[135px]">Status Verifikasi</th>
                        <th class="px-5 py-3 min-w-[160px]">Catatan Pengelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse($payments as $p)
                        <tr class="hover:bg-[#F3ECE0]/60 transition">
                            <td class="px-5 py-3.5 align-top">
                                <span class="inline-block font-mono font-bold text-[11px] bg-[#EFE4D4] text-[#5C402C] px-2.5 py-0.5 rounded border border-[#DDD0BC] whitespace-nowrap">
                                    {{ $p->booking->booking_code ?? '-' }}
                                </span>
                                <div class="text-xs font-bold text-[#5C402C] mt-1.5 leading-snug">
                                    {{ $p->booking->room->name ?? 'Kamar Kost' }}
                                </div>
                            </td>
                            <td class="px-5 py-3.5 align-top">
                                <span class="font-bold text-[#5C402C] block">{{ $p->payment_type_label }}</span>
                                <span class="block text-[11px] text-[#8F6547] mt-0.5 leading-relaxed">
                                    {{ $p->sender_name ? "Pengirim: {$p->sender_name} ({$p->sender_bank})" : 'Belum ada data pengirim' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 align-top font-extrabold text-[#5C402C] whitespace-nowrap">
                                {{ $p->formatted_amount }}
                            </td>
                            <td class="px-5 py-3.5 align-top text-[#7A563C] whitespace-nowrap">
                                {{ $p->payment_date ? $p->payment_date->format('d M Y') : '-' }}
                            </td>
                            <td class="px-5 py-3.5 align-top whitespace-nowrap">
                                @if($p->proof_image)
                                    <a href="{{ $p->proof_image_url }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-[#EFE4D4] text-[#5C402C] font-bold text-[11px] hover:bg-[#E2D6C3] border border-[#DDD0BC] transition">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-xs text-[#9C785C] italic">Belum diunggah</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 align-top whitespace-nowrap">
                                @if(empty($p->proof_image))
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EFE4D4] text-[#7A563C] border border-[#DDD0BC]">Belum Ada</span>
                                @elseif($p->status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                        <svg class="w-3.5 h-3.5 text-[#5B8552]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                        Disetujui
                                    </span>
                                @elseif($p->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]">Diproses</span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC]">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        Ditolak
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 align-top text-xs text-[#8F6547] leading-relaxed">
                                {{ $p->admin_notes ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-[#9C785C] text-xs">
                                Belum ada riwayat transaksi pembayaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-[#E8DEC9] bg-[#F3ECE0]/50">
            {{ $payments->links() }}
        </div>
    </div>

    <!-- MODAL FORM UNGGAH BUKTI TRANSFER (TENGAH, TIDAK MEPET & ADA SCROLL SEPERTI ADMIN) -->
    @if($showUploadModal)
        @teleport('body')
            <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <!-- Backdrop -->
                <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity" wire:click="$set('showUploadModal', false)"></div>

                <!-- Kotak Modal Tengah -->
                <div class="relative z-10 w-full max-w-lg max-h-[82dvh] flex flex-col overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl border border-[#E2D6C3]">

                    <!-- Header Warna Admin -->
                    <div class="px-5 py-3.5 bg-[#C29A78] text-[#FAF6EE] flex items-center justify-between gap-3 shrink-0">
                        <div>
                            <span class="text-[11px] font-bold text-[#FAF6EE]/85 uppercase tracking-wider block">Verifikasi Transaksi</span>
                            <h3 class="text-sm font-bold text-[#FAF6EE]">Unggah Bukti Pembayaran</h3>
                        </div>
                        <button type="button" wire:click="$set('showUploadModal', false)" class="text-[#FAF6EE]/80 hover:text-[#FAF6EE] p-1 cursor-pointer shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Form dengan Scrollbar -->
                    <form wire:submit.prevent="submitPayment"
                          class="p-5 space-y-4 text-xs text-[#5C402C] overflow-y-auto flex-1
                                 [&::-webkit-scrollbar]:w-2
                                 [&::-webkit-scrollbar-track]:bg-[#F3ECE0]
                                 [&::-webkit-scrollbar-thumb]:bg-[#C9B49A]
                                 [&::-webkit-scrollbar-thumb]:rounded-full
                                 [&::-webkit-scrollbar-thumb]:border-2
                                 [&::-webkit-scrollbar-thumb]:border-[#F3ECE0]
                                 hover:[&::-webkit-scrollbar-thumb]:bg-[#A67B5B]">

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Pilih Tagihan Booking <span class="text-[#9E4735]">*</span></label>
                            <select wire:model.live="selectedBookingId" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                <option value="">-- Pilih Booking Kamar --</option>
                                @foreach($payableBookings as $b)
                                    <option value="{{ $b->id }}">
                                        {{ $b->booking_code }} - {{ $b->room->name }} (Status: {{ $b->status_label }})
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedBookingId') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Jenis Pembayaran <span class="text-[#9E4735]">*</span></label>
                                <select wire:model.live="paymentType" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                    <option value="full">Bayar Lunas</option>
                                    <option value="dp">Uang Muka (DP 50%)</option>
                                    <option value="settlement">Pelunasan Sisa</option>
                                </select>
                                @error('paymentType') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Nominal Transfer (Rp) <span class="text-[#9E4735]">*</span></label>
                                <input type="number" wire:model="amount" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-xs font-bold text-[#5C402C] outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @error('amount') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Ditransfer ke Rekening <span class="text-[#9E4735]">*</span></label>
                            <select wire:model="bankAccountId" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @foreach($bankAccounts as $bank)
                                    <option value="{{ $bank->id }}">
                                        {{ $bank->bank_name }} - {{ $bank->account_number }} a.n. {{ $bank->account_holder }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bankAccountId') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Nama Pemilik Rekening <span class="text-[#9E4735]">*</span></label>
                                <input type="text" wire:model="senderName" placeholder="Contoh: Ahmad Pratama" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @error('senderName') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Bank Pengirim <span class="text-[#9E4735]">*</span></label>
                                <input type="text" wire:model="senderBank" placeholder="Contoh: BCA / Mandiri" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                                @error('senderBank') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Tanggal Transfer <span class="text-[#9E4735]">*</span></label>
                            <input type="date" wire:model="paymentDate" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                            @error('paymentDate') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Foto Bukti Transfer (Resi/Struk/Screenshot) <span class="text-[#9E4735]">*</span></label>
                            <input type="file" wire:model="proofImage" accept="image/*" class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-xs text-[#7A563C] file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#EFE4D4] file:text-[#5C402C] hover:file:bg-[#E2D6C3]">
                            <span wire:loading wire:target="proofImage" class="text-xs text-[#A67B5B] mt-1 block">Mengunggah gambar...</span>
                            @error('proofImage') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror

                            @if ($proofImage)
                                <div class="mt-2.5 text-xs text-[#8F6547]">
                                    Preview:
                                    <img src="{{ $proofImage->temporaryUrl() }}" class="mt-1.5 h-24 rounded-lg border border-[#E2D6C3] object-cover">
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
                            <button type="button" wire:click="$set('showUploadModal', false)" class="px-4 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] cursor-pointer">
                                Kirim Bukti Transfer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endteleport
    @endif
</div>