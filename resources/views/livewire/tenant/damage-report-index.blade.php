<div class="space-y-8">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-[#5C402C] tracking-tight">Laporan Kerusakan Fasilitas</h2>
            <p class="text-xs sm:text-sm text-[#8F6547] mt-1">Laporkan kendala perlengkapan di dalam kamar agar tim teknisi pengelola dapat segera memperbaiki.</p>
        </div>
        <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs sm:text-sm hover:bg-[#8F6547] shadow-xs transition cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan Kerusakan
        </button>
    </div>

    @if(session()->has('success'))
        <div class="p-4 rounded-2xl bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs sm:text-sm font-semibold flex items-center gap-3">
            <svg class="w-5 h-5 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- LIST LAPORAN KERUSAKAN -->
    <div class="bg-[#FAF6EE] rounded-3xl border border-[#E2D6C3] overflow-hidden shadow-xs">
        <div class="px-6 py-4 border-b border-[#E8DEC9] flex items-center justify-between">
            <h3 class="text-base font-bold text-[#5C402C]">Riwayat Laporan & Pelacakan Status</h3>
            <span class="text-xs text-[#8F6547]">Total: {{ $reports->total() }} Laporan</span>
        </div>

        <div class="divide-y divide-[#E8DEC9]">
            @forelse($reports as $r)
                <div class="p-6 flex flex-col sm:flex-row items-start justify-between gap-6 hover:bg-[#F3ECE0]/60 transition">
                    <div class="flex items-start gap-4">
                        @if($r->photo)
                            <a href="{{ $r->photo_url }}" target="_blank" class="w-20 h-20 rounded-2xl overflow-hidden bg-[#EFE4D4] shrink-0 border border-[#DDD0BC] group relative">
                                <img src="{{ $r->photo_url }}" alt="Foto Kerusakan" class="w-full h-full object-cover group-hover:scale-105 transition">
                                <div class="absolute inset-0 bg-[#2D231C]/35 flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-[#FAF6EE] text-[10px] font-bold">
                                    Lihat
                                </div>
                            </a>
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-[#F9E6E2] text-[#9E4735] flex items-center justify-center shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        @endif

                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-base font-bold text-[#5C402C]">{{ $r->facility_name }}</h4>
                                <span class="text-xs text-[#9C785C]">• {{ $r->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <p class="text-xs text-[#7A563C] leading-relaxed max-w-xl">{{ $r->description }}</p>

                            @if($r->admin_response)
                                <div class="mt-3 p-3.5 rounded-2xl bg-[#F3ECE0] border border-[#DDD0BC] text-xs text-[#5C402C]">
                                    <strong class="text-[#8F6547] block font-bold mb-0.5">Respon Pengelola:</strong>
                                    {{ $r->admin_response }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Pelacakan Badge -->
                    <div class="shrink-0 self-end sm:self-center">
                        @if($r->status === 'resolved')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                <svg class="w-4 h-4 text-[#5B8552]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                {{ $r->status_label }}
                            </span>
                        @elseif($r->status === 'in_progress')
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]">
                                <span class="w-2 h-2 rounded-full bg-[#C2812E] animate-ping"></span>
                                {{ $r->status_label }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC]">
                                {{ $r->status_label }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-16 text-center text-[#9C785C] text-xs">
                    Belum ada laporan kerusakan yang diajukan.
                </div>
            @endforelse
        </div>

        <div class="p-4 border-t border-[#E8DEC9]">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- MODAL CREATE LAPORAN KERUSAKAN -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#2D231C]/65 backdrop-blur-xs transition-opacity" wire:click="$set('showCreateModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-3xl bg-[#FAF6EE] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#E2D6C3]">
                    
                    <div class="px-6 py-4 bg-[#5C402C] text-[#FAF6EE] flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-[#E6DBC9] uppercase tracking-wider">Layanan Perbaikan</span>
                            <h3 class="text-base font-bold text-[#FAF6EE]">Formulir Lapor Kerusakan Fasilitas</h3>
                        </div>
                        <button wire:click="$set('showCreateModal', false)" class="text-[#E6DBC9] hover:text-[#FAF6EE] cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="submitDamageReport" class="p-6 space-y-4 text-xs sm:text-sm text-[#5C402C]">
                        <div>
                            <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Jenis Perlengkapan / Kerusakan <span class="text-[#9E4735]">*</span></label>
                            <input type="text" wire:model="facilityName" placeholder="Contoh: AC Menetes / Lampu Kamar Mandi Mati / Keran Bocor" class="w-full px-3.5 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] placeholder-[#A88B73] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]">
                            @error('facilityName') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Deskripsi Detail Kerusakan <span class="text-[#9E4735]">*</span></label>
                            <textarea wire:model="description" rows="3" placeholder="Jelaskan secara jelas kendala yang dialami..." class="w-full px-3.5 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-[#5C402C] placeholder-[#A88B73] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B]"></textarea>
                            @error('description') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase text-[#5C402C] mb-1">Foto Bukti Kerusakan (Opsional)</label>
                            <input type="file" wire:model="photo" accept="image/*" class="w-full px-3 py-2 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-xs text-[#7A563C] file:mr-3 file:py-1.5 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-[#A67B5B] file:text-[#FAF6EE] hover:file:bg-[#8F6547]">
                            <span wire:loading wire:target="photo" class="text-xs text-[#8F6547] mt-1 block">Mengunggah foto...</span>
                            @error('photo') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror

                            @if ($photo)
                                <div class="mt-2 text-xs text-[#8F6547]">
                                    Preview:
                                    <img src="{{ $photo->temporaryUrl() }}" class="mt-1 h-24 rounded-xl border border-[#DDD0BC] object-cover">
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-[#E8DEC9] flex items-center justify-end gap-3">
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 rounded-full border border-[#DDD0BC] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="px-5 py-2 rounded-full bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] shadow-xs cursor-pointer">
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>