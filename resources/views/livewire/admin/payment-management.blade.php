<div class="space-y-6">
    <!-- Top Header & Search (Selaras dengan Manage pay$payments) -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight">Invoices & Pembayaran</h2>
            <p class="text-xs text-[#8F6547] mt-0.5">Transaksi pembayaran tercatat</p>
        </div>

        <div class="relative w-full sm:w-72">
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari penyewa, kode, atau kamar..."
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

    <!-- Ringkasan Keuangan -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-[#FAF6EE] rounded-lg p-5 border border-[#E2D6C3]">
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#8F6547]">Total Uang Masuk</span>
            <h3 class="text-xl sm:text-2xl font-extrabold text-[#3F5E30] tracking-tight mt-1.5">
                Rp {{ number_format($totalApprovedRevenue, 0, ',', '.') }}
            </h3>
            <p class="text-[11px] text-[#9C785C] mt-1">Dari seluruh transaksi terverifikasi</p>
        </div>

        <div class="bg-[#FAF6EE] rounded-lg p-5 border border-[#E2D6C3]">
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#8F6547]">Pendapatan Bulan Ini</span>
            <h3 class="text-xl sm:text-2xl font-extrabold text-[#5C402C] tracking-tight mt-1.5">
                Rp {{ number_format($thisMonthApprovedRevenue, 0, ',', '.') }}
            </h3>
            <p class="text-[11px] text-[#9C785C] mt-1">Periode {{ date('F Y') }}</p>
        </div>

        <div class="bg-[#FAF6EE] rounded-lg p-5 border border-[#E2D6C3]">
            <span class="text-[11px] font-bold uppercase tracking-wider text-[#8F6547]">Menunggu Verifikasi</span>
            <h3 class="text-xl sm:text-2xl font-extrabold text-[#C2812E] tracking-tight mt-1.5">
                {{ $totalPendingCount }} Bukti Transfer
            </h3>
            <p class="text-[11px] text-[#9C785C] mt-1">Perlu pengecekan mutasi bank</p>
        </div>
    </div>

    <!-- Card Tabel Pembayaran -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-6 py-3.5">Penyewa</th>
                        <th class="px-6 py-3.5">Kode & Kamar</th>
                        <th class="px-6 py-3.5">Nominal & Jenis</th>
                        <th class="px-6 py-3.5">Tgl Transfer</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse ($payments as $p)
                        @php
                            $initials = collect(explode(' ', $p->user->name ?? 'P'))->take(2)->map(fn($w) => strtoupper(substr($w, 0, 1)))->implode('');
                        @endphp
                        <tr class="hover:bg-[#F3ECE0]/50 transition">
                            <!-- Penyewa & Pengirim -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-[#EFE4D4] border border-[#E2D6C3] text-[#8F6547] font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-[#5C402C] block text-xs sm:text-[13px]">{{ $p->user->name ?? 'Penyewa' }}</span>
                                        <span class="text-[11px] text-[#8F6547] block">
                                            Rek: {{ $p->sender_name ?? '-' }}{{ $p->sender_bank ? ' (' . $p->sender_bank . ')' : '' }}
                                        </span>
                                    </div>
                                </div>
                            </td>

                            <!-- Kode & Kamar -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">Kamar {{ $p->booking->room->room_number ?? '-' }}</span>
                                <span class="text-[11px] font-mono text-[#8F6547] block">{{ $p->booking->booking_code ?? '-' }}</span>
                            </td>

                            <!-- Nominal & Jenis -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $p->formatted_amount }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $p->payment_type_label }}</span>
                            </td>

                            <!-- Tgl Transfer -->
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $p->payment_date ? $p->payment_date->format('d M Y') : '-' }}</span>
                                <span class="text-[11px] text-[#8F6547] block">{{ $p->bankAccount->bank_name ?? 'Transfer Bank' }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4">
                                @if (empty($p->proof_image))
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EFE4D4] text-[#7A563C] border border-[#DDD0BC]">
                                        Belum Upload
                                    </span>
                                @elseif ($p->status === 'approved')
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                        Disetujui
                                    </span>
                                @elseif ($p->status === 'pending')
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]">
                                        Diproses
                                    </span>
                                @else
                                    <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-bold bg-[#F9E6E2] text-[#9E4735] border border-[#E0B5AC]">
                                        Ditolak
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex items-center justify-end gap-2">
                                    @if (!empty($p->proof_image))
                                        <a href="{{ $p->proof_image_url }}" target="_blank"
                                            class="p-1.5 rounded-lg text-[#8F6547] hover:bg-[#EFE4D4] transition"
                                            title="Lihat Bukti Transfer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    <button type="button" wire:click="openVerifyModal({{ $p->id }})"
                                        class="px-3 py-1 rounded-lg bg-[#A67B5B] text-[#FAF6EE] hover:bg-[#8F6547] font-bold text-[11px] transition cursor-pointer">
                                        Verifikasi
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-[#9C785C] text-xs">
                                Tidak ada data pembayaran yang ditemukan.
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
                <span>data dari <strong class="text-[#5C402C]">{{ $payments->total() }}</strong> unit</span>
            </div>

            <div class="flex items-center gap-1">
                @if ($payments->onFirstPage())
                    <span class="w-6 h-6 rounded-full border border-[#E2D6C3] bg-[#F3ECE0] text-[#B89F86] flex items-center justify-center cursor-not-allowed">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </span>
                @else
                    <button wire:click="previousPage" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] flex items-center justify-center transition cursor-pointer">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                @endif

                @for ($page = 1; $page <= max(1, $payments->lastPage()); $page++)
                    @if ($page == $payments->currentPage())
                        <span class="w-6 h-6 rounded-full bg-[#A67B5B] text-[#FAF6EE] text-[11px] font-bold flex items-center justify-center">{{ $page }}</span>
                    @else
                        <button wire:click="gotoPage({{ $page }})" class="w-6 h-6 rounded-full border border-[#DDD0BC] bg-[#FAF6EE] text-[#5C402C] hover:bg-[#EFE4D4] text-[11px] font-semibold flex items-center justify-center transition cursor-pointer">{{ $page }}</button>
                    @endif
                @endfor

                @if ($payments->hasMorePages())
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

    <!-- MODAL DETAIL & VERIFIKASI PEMBAYARAN -->
    @if ($showVerifyModal && $selectedPayment)
        <div class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#2D231C]/50 backdrop-blur-xs transition-opacity" wire:click="$set('showVerifyModal', false)"></div>

            <div class="relative z-10 min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-2xl rounded-2xl bg-[#FAF6EE] border border-[#E2D6C3] shadow-2xl overflow-hidden text-xs">
                    <div class="px-6 py-4 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-extrabold text-[#5C402C]">Verifikasi Pembayaran {{ $selectedPayment->booking->booking_code ?? '' }}</h3>
                            <p class="text-[11px] text-[#8F6547]">Periksa kesesuaian bukti transfer dengan nominal tagihan</p>
                        </div>
                        <button type="button" wire:click="$set('showVerifyModal', false)" class="text-[#8F6547] hover:text-[#5C402C] cursor-pointer">✕</button>
                    </div>

                    <div class="p-6 space-y-5 max-h-[80vh] overflow-y-auto">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <!-- Foto Bukti -->
                            <div class="space-y-2">
                                <span class="text-[11px] font-bold uppercase text-[#8F6547] block">Foto Bukti Transfer</span>
                                @if (!empty($selectedPayment->proof_image))
                                    <div class="rounded-xl border border-[#E2D6C3] overflow-hidden bg-[#F3ECE0]">
                                        <img src="{{ $selectedPayment->proof_image_url }}" alt="Bukti Transfer" class="w-full max-h-64 object-contain mx-auto">
                                    </div>
                                    <div class="text-right">
                                        <a href="{{ $selectedPayment->proof_image_url }}" target="_blank" class="text-[11px] text-[#A67B5B] font-bold hover:underline">
                                            Buka Ukuran Penuh ↗
                                        </a>
                                    </div>
                                @else
                                    <div class="p-8 text-center bg-[#F3ECE0] rounded-xl text-[#9C785C]">Tidak ada bukti transfer diunggah</div>
                                @endif
                            </div>

                            <!-- Rincian Transaksi -->
                            <div class="space-y-3">
                                <div class="p-3.5 rounded-xl bg-[#F3ECE0] border border-[#E2D6C3] space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-[#8F6547]">Penyewa</span>
                                        <strong class="text-[#5C402C]">{{ $selectedPayment->user->name ?? '-' }}</strong>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#8F6547]">Kamar</span>
                                        <strong class="text-[#5C402C]">{{ $selectedPayment->booking->room->room_number ?? '-' }} ({{ $selectedPayment->booking->room->room_type ?? '-' }})</strong>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#8F6547]">Jenis</span>
                                        <strong class="text-[#A67B5B]">{{ $selectedPayment->payment_type_label }}</strong>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#8F6547]">Nominal</span>
                                        <strong class="text-sm text-[#5C402C] font-extrabold">{{ $selectedPayment->formatted_amount }}</strong>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#8F6547]">Tgl Transfer</span>
                                        <strong class="text-[#5C402C]">{{ $selectedPayment->payment_date ? $selectedPayment->payment_date->format('d M Y') : '-' }}</strong>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#8F6547]">Pengirim</span>
                                        <strong class="text-[#5C402C]">{{ $selectedPayment->sender_name ?? '-' }}{{ $selectedPayment->sender_bank ? ' (' . $selectedPayment->sender_bank . ')' : '' }}</strong>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-[#8F6547]">Rekening Tujuan</span>
                                        <strong class="text-[#5C402C]">{{ $selectedPayment->bankAccount->bank_name ?? 'Bank Pengelola' }}</strong>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Catatan Pengelola / Alasan Penolakan</label>
                                    <textarea wire:model="adminNotes" rows="2" placeholder="Tuliskan catatan verifikasi atau alasan jika ditolak..."
                                        class="w-full px-3 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] text-xs outline-none focus:border-[#A67B5B]"></textarea>
                                    @error('adminNotes') <span class="text-[11px] text-[#9E4735]">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-[#E8DEC9] flex flex-col sm:flex-row items-center justify-between gap-3">
                            <span class="text-xs text-[#8F6547]">
                                Status:
                                <strong class="text-[#5C402C]">
                                    @if (empty($selectedPayment->proof_image))
                                        Belum Upload
                                    @elseif ($selectedPayment->status === 'pending')
                                        Diproses
                                    @else
                                        {{ $selectedPayment->status_label }}
                                    @endif
                                </strong>
                            </span>

                            <div class="flex items-center gap-2">
                                <button type="button" wire:click="rejectPayment"
                                    class="px-4 py-1.5 rounded-full bg-[#F9E6E2] text-[#9E4735] hover:bg-[#F3D5CE] font-bold text-xs transition cursor-pointer">
                                    Tolak
                                </button>
                                <button type="button" wire:click="approvePayment"
                                    class="px-5 py-1.5 rounded-full bg-[#5B8552] text-[#FAF6EE] hover:bg-[#4B7043] font-bold text-xs transition cursor-pointer">
                                    Setujui Pembayaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>