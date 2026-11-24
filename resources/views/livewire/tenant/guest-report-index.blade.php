<div class="space-y-8">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-[#5C402C] tracking-tight">Laporan Kunjungan Tamu</h2>
            <p class="text-xs sm:text-sm text-[#8F6547] mt-1">Form pelaporan teman atau keluarga yang berkunjung malam / menginap demi ketertiban & keamanan lingkungan kost.</p>
        </div>
        <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs sm:text-sm hover:bg-[#8F6547] shadow-xs transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Lapor Kunjungan Tamu
        </button>
    </div>

    @if(session()->has('success'))
        <div class="p-4 rounded-2xl bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs sm:text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- LIST LAPORAN TAMU -->
    <div class="bg-[#FAF6EE] rounded-3xl border border-[#E2D6C3] overflow-hidden shadow-xs">
        <div class="px-6 py-4 border-b border-[#E8DEC9] flex items-center justify-between">
            <h3 class="text-base font-bold text-[#5C402C]">Riwayat Catatan Tamu Berkunjung</h3>
            <span class="text-xs text-[#8F6547]">Total: {{ $reports->total() }} Catatan</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs sm:text-sm">
                <thead>
                    <tr class="bg-[#F3ECE0] text-[#8F6547] text-[11px] font-bold uppercase tracking-wider border-b border-[#E2D6C3]">
                        <th class="px-6 py-3.5">Nama Tamu & Hubungan</th>
                        <th class="px-6 py-3.5">Tanggal & Jam</th>
                        <th class="px-6 py-3.5">Durasi Kunjungan</th>
                        <th class="px-6 py-3.5">Keperluan</th>
                        <th class="px-6 py-3.5">No. Kontak Tamu</th>
                        <th class="px-6 py-3.5">Status Pengelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse($reports as $r)
                        <tr class="hover:bg-[#F3ECE0]/60 transition">
                            <td class="px-6 py-4">
                                <span class="font-bold text-[#5C402C] block">{{ $r->guest_name }}</span>
                                <span class="text-xs text-[#8F6547] bg-[#EFE4D4] px-2.5 py-0.5 rounded-full font-medium inline-block mt-0.5">{{ $r->relationship }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-[#5C402C]">{{ $r->visit_date->format('d M Y') }}</span>
                                <span class="block text-xs text-[#8F6547]">{{ $r->visit_time }}</span>
                            </td>
                            <td class="px-6 py-4 font-medium text-[#5C402C]">
                                {{ $r->duration }}
                            </td>
                            <td class="px-6 py-4 text-[#7A563C] max-w-xs leading-relaxed">
                                {{ $r->purpose }}
                            </td>
                            <td class="px-6 py-4 text-[#8F6547] font-mono text-xs">
                                {{ $r->guest_phone ?: '-' }}
                            </td>
                            <td class="px-6 py-4">
                                @if($r->status === 'acknowledged')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                        ✓ Dikonfirmasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC]">
                                        Tercatat
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-[#9C785C] text-xs">
                                Belum ada riwayat kunjungan tamu.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-[#E8DEC9]">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- MODAL CREATE LAPORAN TAMU -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#2D231C]/65 backdrop-blur-xs transition-opacity" wire:click="$set('showCreateModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-[#FAF6EE] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#E2D6C3]">
                    
                    <div class="px-6 py-4 bg-[#5C402C] text-[#FAF6EE] flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-[#E6DBC9] uppercase tracking-wider">Ketertiban Kost</span>
                            <h3 class="text-base font-bold text-[#FAF6EE]">Formulir Laporan Tamu Berkunjung</h3>
                        </div>
                        <button wire:click="$set('showCreateModal', false)" class="text-[#E6DBC9] hover:text-[#FAF6EE] cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="submitGuestReport" class="p-6 space-y-4 text-xs sm:text-sm text-[#5C402C]">
                        
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Nama Lengkap Tamu <span class="text-[#9E4735]">*</span></label>
                                <input type="text" wire:model="guestName" placeholder="Contoh: Rian Sanjaya" class="w-full px-3 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] placeholder-[#A88B73] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]">
                                @error('guestName') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Hubungan Tamu <span class="text-[#9E4735]">*</span></label>
                                <select wire:model="relationship" class="w-full px-3 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]">
                                    <option value="Teman">Teman</option>
                                    <option value="Keluarga">Keluarga</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Rekan Kerja">Rekan Kerja</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('relationship') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Tanggal Kunjungan <span class="text-[#9E4735]">*</span></label>
                                <input type="date" wire:model="visitDate" class="w-full px-3 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]">
                                @error('visitDate') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Jam Berkunjung <span class="text-[#9E4735]">*</span></label>
                                <input type="text" wire:model="visitTime" placeholder="Contoh: 19:00 - 22:00 WIB" class="w-full px-3 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] placeholder-[#A88B73] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]">
                                @error('visitTime') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Perkiraan Durasi <span class="text-[#9E4735]">*</span></label>
                                <select wire:model="duration" class="w-full px-3 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]">
                                    <option value="1-2 Jam">1 - 2 Jam</option>
                                    <option value="3-5 Jam">3 - 5 Jam</option>
                                    <option value="Seharian">Seharian</option>
                                    <option value="Menginap 1 Malam">Menginap 1 Malam</option>
                                </select>
                                @error('duration') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">No. HP / WhatsApp Tamu</label>
                                <input type="text" wire:model="guestPhone" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] placeholder-[#A88B73] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Keperluan Kunjungan <span class="text-[#9E4735]">*</span></label>
                            <textarea wire:model="purpose" rows="2" placeholder="Contoh: Diskusi tugas kuliah / berkunjung keluarga..." class="w-full px-3 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] placeholder-[#A88B73] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]"></textarea>
                            @error('purpose') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4 border-t border-[#E8DEC9] flex items-center justify-end gap-3">
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 rounded-full border border-[#DDD0BC] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" class="px-5 py-2 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] shadow-xs cursor-pointer">
                                Simpan Laporan Tamu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

</div>