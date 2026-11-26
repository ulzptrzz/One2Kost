<div class="space-y-5 pb-24">

    <!-- HEADER BAR -->
    <div class="flex flex-row items-center justify-between gap-3">
        <div class="min-w-0">
            <h2 class="text-lg font-extrabold text-[#5C402C] tracking-tight">Laporan Kerusakan</h2>
        </div>
        <button wire:click="openCreateModal"
            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#A67B5B] text-[#FAF6EE] font-bold text-xs hover:bg-[#8F6547] transition cursor-pointer shrink-0">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Lapor Kerusakan
        </button>
    </div>

    @if(session()->has('success'))
        <div class="p-3.5 rounded-lg bg-[#EBF2E6] border border-[#C6D8BA] text-[#3F5E30] text-xs font-semibold flex items-center gap-2.5">
            <svg class="w-4 h-4 text-[#5B8552] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- TABEL RIWAYAT LAPORAN KERUSAKAN -->
    <div class="bg-[#FAF6EE] rounded-lg border border-[#E2D6C3] overflow-hidden">
        <div class="px-5 py-3 bg-[#F3ECE0] border-b border-[#E2D6C3] flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-[#8F6547]">Riwayat Kerusakan</h3>
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
                        <th class="px-5 py-3 min-w-[190px]">Kerusakan</th>
                        <th class="px-5 py-3 min-w-[230px]">Deskripsi Kerusakan</th>
                        <th class="px-5 py-3 min-w-[115px]">Foto Bukti</th>
                        <th class="px-5 py-3 min-w-[140px]">Status Pelacakan</th>
                        <th class="px-5 py-3 min-w-[200px]">Respon Pengelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DEC9] text-[#5C402C]">
                    @forelse($reports as $r)
                        <tr class="hover:bg-[#F3ECE0]/60 transition">
                            <!-- Kolom 1: Perlengkapan & Tanggal -->
                            <td class="px-5 py-3.5 align-top">
                                <span class="font-bold text-[#5C402C] block leading-snug">{{ $r->facility_name }}</span>
                                <span class="block text-[11px] text-[#9C785C] mt-0.5 whitespace-nowrap">
                                    {{ $r->created_at->format('d M Y, H:i') }} WIB
                                </span>
                            </td>

                            <!-- Kolom 2: Deskripsi -->
                            <td class="px-5 py-3.5 align-top text-[#7A563C] leading-relaxed max-w-xs">
                                {{ $r->description }}
                            </td>

                            <!-- Kolom 3: Foto Bukti -->
                            <td class="px-5 py-3.5 align-top whitespace-nowrap">
                                @if($r->photo)
                                    <a href="{{ $r->photo_url }}" target="_blank"
                                       class="inline-flex items-center gap-1 px-2.5 py-1 rounded-md bg-[#EFE4D4] text-[#5C402C] font-bold text-[11px] hover:bg-[#E2D6C3] border border-[#DDD0BC] transition">
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-xs text-[#9C785C] italic">Tidak ada</span>
                                @endif
                            </td>

                            <!-- Kolom 4: Status -->
                            <td class="px-5 py-3.5 align-top whitespace-nowrap">
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
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-[#EFE4D4] text-[#5C402C] border border-[#DDD0BC]">
                                        {{ $r->status_label }}
                                    </span>
                                @endif
                            </td>

                            <!-- Kolom 5: Respon Pengelola -->
                            <td class="px-5 py-3.5 align-top text-xs text-[#8F6547] leading-relaxed">
                                {{ $r->admin_response ?: '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-[#9C785C] text-xs">
                                Belum ada laporan kerusakan yang diajukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-5 py-3 border-t border-[#E8DEC9] bg-[#F3ECE0]/50">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- MODAL CREATE LAPORAN KERUSAKAN (TENGAH & ADA SCROLL SEPERTI ADMIN) -->
    @if($showCreateModal)
        @teleport('body')
            <div class="fixed inset-0 z-[9999] flex items-center justify-center p-4 sm:p-6" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-[#5C402C]/45 backdrop-blur-xs transition-opacity" wire:click="$set('showCreateModal', false)"></div>

                <div class="relative z-10 w-full max-w-lg max-h-[82dvh] flex flex-col overflow-hidden rounded-xl bg-[#FAF6EE] text-left shadow-2xl">

                    <div class="px-5 py-3.5 bg-[#C29A78] text-[#FAF6EE] flex items-center justify-between gap-3 shrink-0">
                        <div>
                            <span class="text-[11px] font-bold text-[#FAF6EE]/85 uppercase tracking-wider block">Layanan Perbaikan</span>
                            <h3 class="text-sm font-bold text-[#FAF6EE]">Formulir Lapor Kerusakan Fasilitas</h3>
                        </div>
                        <button type="button" wire:click="$set('showCreateModal', false)" class="text-[#FAF6EE]/80 hover:text-[#FAF6EE] p-1 cursor-pointer shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="submitDamageReport"
                          class="p-5 space-y-4 text-xs text-[#5C402C] overflow-y-auto flex-1
                                 [&::-webkit-scrollbar]:w-2
                                 [&::-webkit-scrollbar-track]:bg-[#F3ECE0]
                                 [&::-webkit-scrollbar-thumb]:bg-[#C9B49A]
                                 [&::-webkit-scrollbar-thumb]:rounded-full
                                 [&::-webkit-scrollbar-thumb]:border-2
                                 [&::-webkit-scrollbar-thumb]:border-[#F3ECE0]
                                 hover:[&::-webkit-scrollbar-thumb]:bg-[#A67B5B]">
                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Jenis Perlengkapan / Kerusakan <span class="text-[#9E4735]">*</span></label>
                            <input type="text" wire:model="facilityName" placeholder="Contoh: AC Menetes / Lampu Kamar Mandi Mati / Keran Bocor" class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]">
                            @error('facilityName') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Deskripsi Detail Kerusakan <span class="text-[#9E4735]">*</span></label>
                            <textarea wire:model="description" rows="3" placeholder="Jelaskan secara jelas kendala yang dialami..." class="w-full px-3 py-2.5 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-[#5C402C] placeholder-[#9C785C] text-xs outline-none focus:ring-2 focus:ring-[#A67B5B]"></textarea>
                            @error('description') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold uppercase text-[#5C402C] mb-1.5">Foto Bukti Kerusakan (Opsional)</label>
                            <input type="file" wire:model="photo" accept="image/*" class="w-full px-3 py-2 rounded-lg border border-[#DDD0BC] bg-[#F3ECE0]/60 text-xs text-[#7A563C] file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#EFE4D4] file:text-[#5C402C] hover:file:bg-[#E2D6C3]">
                            <span wire:loading wire:target="photo" class="text-xs text-[#A67B5B] mt-1 block">Mengunggah foto...</span>
                            @error('photo') <span class="text-xs text-[#9E4735] mt-1 block">{{ $message }}</span> @enderror

                            @if ($photo)
                                <div class="mt-2.5 text-xs text-[#8F6547]">
                                    Preview:
                                    <img src="{{ $photo->temporaryUrl() }}" class="mt-1.5 h-24 rounded-lg border border-[#E2D6C3] object-cover">
                                </div>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-[#E8DEC9] flex items-center justify-end gap-2.5">
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
        @endteleport
    @endif
</div>