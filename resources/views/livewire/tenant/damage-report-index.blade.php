<div class="space-y-5 pb-24">

    <!-- HEADER BAR -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-extrabold text-[#5C402C] tracking-tight">Laporan Kerusakan Fasilitas</h2>
            <p class="text-xs text-[#8F6547]">Laporkan kendala perlengkapan di dalam kamar agar tim teknisi pengelola dapat segera memperbaiki.</p>
        </div>
        <button wire:click="openCreateModal"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] transition cursor-pointer shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan Kerusakan
        </button>
    </div>

    @if(session()->has('success'))
        <div class="p-3.5 rounded-lg bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- LIST LAPORAN KERUSAKAN -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="px-5 py-3 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#8F6547]">Riwayat Laporan & Pelacakan Status</h3>
            <span class="text-xs font-semibold text-[#5C402C]">Total: {{ $reports->total() }} Laporan</span>
        </div>

        <div class="divide-y divide-[#E8DEC9]">
            @forelse($reports as$r)
                <div class="p-5 flex flex-col sm:flex-row items-start justify-between gap-4 hover:bg-[#F3ECE0]/60 transition">
                    <div class="flex items-start gap-3.5">
                        @if($r->photo)
                            <a href="{{ $r->photo_url }}" target="_blank" class="w-16 h-16 rounded-lg overflow-hidden bg-[#EFE4D4] shrink-0 border border-[#DDD0BC] group relative">
                                <img src="{{ $r->photo_url }}" alt="Foto Kerusakan" class="w-full h-full object-cover group-hover:scale-105 transition">
                                <div class="absolute inset-0 bg-[#5C402C]/45 flex items-center justify-center opacity-0 group-hover:opacity-100 transition text-[#FAF6EE] text-[10px] font-bold">
                                    Lihat
                                </div>
                            </a>
                        @else
                            <div class="w-14 h-14 rounded-lg bg-[#F9E6E2] border border-[#E0B5AC] text-[#9E4735] flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        @endif

                        <div class="space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h4 class="text-sm font-bold text-[#5C402C]">{{ $r->facility_name }}</h4>
                                <span class="text-[11px] text-[#9C785C]">• {{ $r->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <p class="text-xs text-[#7A563C] leading-relaxed max-w-xl">{{ $r->description }}</p>

                            @if($r->admin_response)
                                <div class="mt-2.5 p-3 rounded-lg bg-[#F3ECE0] border border-[#DDD0BC] text-xs text-[#5C402C]">
                                    <strong class="text-[#8F6547] block font-bold mb-0.5">Respon Pengelola:</strong>
                                    {{ $r->admin_response }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Pelacakan Badge -->
                    <div class="shrink-0 self-end sm:self-center">
                        @if($r->status === 'resolved')
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EBF2E6] text-[#3F5E30] border border-[#C6D8BA]">
                                <svg class="w-3.5 h-3.5 text-[#5B8552]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                {{ $r->status_label }}
                            </span>
                        @elseif($r->status === 'in_progress')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#F7ECD9] text-[#8A5A19] border border-[#E3C898]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#C2812E]"></span>
                                {{ $r->status_label }}
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC]">
                                {{ $r->status_label }}
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-[#9C785C] text-xs">
                    Belum ada laporan kerusakan yang diajukan.
                </div>
            @endforelse
        </div>

        <div class="px-5 py-3 border-t border-[#E8DEC9] bg-[#F3ECE0]/50">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- MODAL CREATE LAPORAN KERUSAKAN (GAYA ADMIN) -->
    @if($showCreateModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity" wire:click="$set('showCreateModal', false)"></div>

            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-[#E2D6C3]">

                    <div class="px-5 py-3.5 bg-[#C29A78] text-[#FAF6EE] flex items-center justify-between">
                        <div>
                            <span class="text-[11px] font-bold text-[#FAF6EE]/85 uppercase">Layanan Perbaikan</span>
                            <h3 class="text-sm font-bold text-[#FAF6EE]">Formulir Lapor Kerusakan Fasilitas</h3>
                        </div>
                        <button wire:click="$set('showCreateModal', false)" class="text-[#FAF6EE]/80 hover:text-[#FAF6EE] cursor-pointer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="submitDamageReport" class="p-5 space-y-4 text-xs text-[#5C402C]">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Jenis Perlengkapan / Kerusakan <span class="text-[#9E4735]">*</span></label>
                            <input type="text" wire:model="facilityName" placeholder="Contoh: AC Menetes / Lampu Kamar Mandi Mati / Keran Bocor" class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                            @error('facilityName') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Deskripsi Detail Kerusakan <span class="text-[#9E4735]">*</span></label>
                            <textarea wire:model="description" rows="3" placeholder="Jelaskan secara jelas kendala yang dialami..." class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]"></textarea>
                            @error('description') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1">Foto Bukti Kerusakan (Opsional)</label>
                            <input type="file" wire:model="photo" accept="image/*" class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-xs text-[#7A563C] file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#EFE4D4] file:text-[#5C402C] hover:file:bg-[#E2D6C3]">
                            <span wire:loading wire:target="photo" class="text-xs text-[#A67B5B] mt-1 block">Mengunggah foto...</span>
                            @error('photo') <span class="text-xs text-[#9E4735]">{{ $message }}</span> @enderror

                            @if ($photo)
                                <div class="mt-2 text-xs text-[#8F6547]">
                                    Preview:
                                    <img src="{{ $photo->temporaryUrl() }}" class="mt-1 h-24 rounded-lg border border-[#E2D6C3] object-cover">
                                </div>
                            @endif
                        </div>

                        <div class="pt-3.5 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
                            <button type="button" wire:click="$set('showCreateModal', false)" class="px-4 py-2 rounded-lg bg-[#F3ECE0] text-[#5C402C] font-semibold text-xs hover:bg-[#EFE4D4] cursor-pointer">
                                Batal
                            </button>
                            <button type="submit" wire:loading.attr="disabled" class="px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] cursor-pointer">
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>