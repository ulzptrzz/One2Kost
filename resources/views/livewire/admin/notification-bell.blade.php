<div class="relative" x-data="{ open: false }" @click.outside="open = false" wire:poll.15s>
    <!-- Bell Button -->
    <button @click="open = !open" class="relative p-2.5 rounded-xl text-[#8F6547] hover:text-[#5C402C] hover:bg-[#EFE4D4] transition focus:outline-none cursor-pointer">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>

        @if($totalNotifications > 0)
            <span class="absolute top-1.5 right-1.5 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#C2812E] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-[#9E4735] text-[10px] font-bold text-[#FAF6EE] items-center justify-center">
                    {{ $totalNotifications > 9 ? '9+' : $totalNotifications }}
                </span>
            </span>
        @endif
    </button>

    <!-- Notification Dropdown Panel -->
    <div x-show="open" x-cloak class="absolute right-0 mt-3 w-80 sm:w-96 bg-[#FAF6EE] rounded-2xl shadow-xl border border-[#E2D6C3] overflow-hidden z-50">
        <!-- Header -->
        <div class="px-5 py-3.5 bg-gradient-to-r from-[#A67B5B] to-[#C29A78] text-[#FAF6EE] flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-bold text-sm">Pusat Notifikasi Admin</span>
                @if($totalNotifications > 0)
                    <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-[#FAF6EE] text-[#8F6547]">
                        {{ $totalNotifications }} Baru
                    </span>
                @endif
            </div>
            <span class="text-[11px] text-[#FAF6EE]/90 font-medium">Real-time</span>
        </div>

        <!-- 4 Categorized Indicators -->
        <div class="grid grid-cols-2 gap-2 p-3 bg-[#F3ECE0] border-b border-[#E2D6C3] text-xs">
            <a href="{{ route('admin.payments') }}" class="p-2.5 rounded-xl bg-[#FAF6EE] border border-[#E2D6C3] hover:border-[#A67B5B] transition group">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-[#5C402C] group-hover:text-[#A67B5B]">1. Pembayaran</span>
                    <span class="px-1.5 py-0.5 rounded-md font-bold {{ $pendingPaymentsCount > 0 ? 'bg-[#F7ECD9] text-[#8A5A19]' : 'bg-[#EFE4D4] text-[#8F6547]' }}">
                        {{ $pendingPaymentsCount }}
                    </span>
                </div>
                <p class="text-[10px] text-[#8F6547] mt-1">Verifikasi transfer masuk</p>
            </a>

            <a href="{{ route('admin.tenants') }}" class="p-2.5 rounded-xl bg-[#FAF6EE] border border-[#E2D6C3] hover:border-[#A67B5B] transition group">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-[#5C402C] group-hover:text-[#A67B5B]">2. Antrian Sewa</span>
                    <span class="px-1.5 py-0.5 rounded-md font-bold {{ $waitingBookingsCount > 0 ? 'bg-[#EFE4D4] text-[#5C402C]' : 'bg-[#EFE4D4] text-[#8F6547]' }}">
                        {{ $waitingBookingsCount }}
                    </span>
                </div>
                <p class="text-[10px] text-[#8F6547] mt-1">Calon penyewa / waiting list</p>
            </a>

            <a href="{{ route('admin.damages') }}" class="p-2.5 rounded-xl bg-[#FAF6EE] border border-[#E2D6C3] hover:border-[#A67B5B] transition group">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-[#5C402C] group-hover:text-[#A67B5B]">3. Kerusakan</span>
                    <span class="px-1.5 py-0.5 rounded-md font-bold {{ $reportedDamagesCount > 0 ? 'bg-[#F9E6E2] text-[#9E4735]' : 'bg-[#EFE4D4] text-[#8F6547]' }}">
                        {{ $reportedDamagesCount }}
                    </span>
                </div>
                <p class="text-[10px] text-[#8F6547] mt-1">Laporan baru dari kamar</p>
            </a>

            <a href="{{ route('admin.guests') }}" class="p-2.5 rounded-xl bg-[#FAF6EE] border border-[#E2D6C3] hover:border-[#A67B5B] transition group">
                <div class="flex items-center justify-between">
                    <span class="font-semibold text-[#5C402C] group-hover:text-[#A67B5B]">4. Tamu Kamar</span>
                    <span class="px-1.5 py-0.5 rounded-md font-bold {{ $recordedGuestsCount > 0 ? 'bg-[#E6EFEF] text-[#356368]' : 'bg-[#EFE4D4] text-[#8F6547]' }}">
                        {{ $recordedGuestsCount }}
                    </span>
                </div>
                <p class="text-[10px] text-[#8F6547] mt-1">Kunjungan malam / menginap</p>
            </a>
        </div>

        <!-- Recent Notification Items List -->
        <div class="max-h-72 overflow-y-auto divide-y divide-[#E8DEC9]">
            @if($totalNotifications === 0)
                <div class="p-6 text-center text-[#9C785C] text-xs">
                    <svg class="w-8 h-8 mx-auto mb-2 text-[#C4A88B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Semua laporan dan aktivitas telah ditindaklanjuti.
                </div>
            @else
                @foreach($recentPayments as $p)
                    <a href="{{ route('admin.payments') }}" class="block p-3 hover:bg-[#F3ECE0] transition">
                        <div class="flex items-start gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#C2812E] mt-1.5 shrink-0"></span>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#5C402C]">Pembayaran Masuk: {{ $p->formatted_amount }}</p>
                                <p class="text-[11px] text-[#8F6547]">{{ $p->user->name ?? 'Penyewa' }} • {{ $p->payment_type_label }}</p>
                                <span class="text-[10px] text-[#9C785C]">{{ $p->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach

                @foreach($recentDamages as $d)
                    <a href="{{ route('admin.damages') }}" class="block p-3 hover:bg-[#F3ECE0] transition">
                        <div class="flex items-start gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#9E4735] mt-1.5 shrink-0"></span>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#5C402C]">Kerusakan: {{ $d->facility_name }}</p>
                                <p class="text-[11px] text-[#8F6547]">Kamar {{ $d->room->room_number ?? '-' }} • {{ $d->user->name ?? '' }}</p>
                                <span class="text-[10px] text-[#9C785C]">{{ $d->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach

                @foreach($recentBookings as $b)
                    <a href="{{ route('admin.tenants') }}" class="block p-3 hover:bg-[#F3ECE0] transition">
                        <div class="flex items-start gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#A67B5B] mt-1.5 shrink-0"></span>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#5C402C]">Antrian/Pengajuan: Kamar {{ $b->room->room_number ?? '-' }}</p>
                                <p class="text-[11px] text-[#8F6547]">{{ $b->user->name ?? '' }} (Mulai {{ $b->start_date->format('d M Y') }})</p>
                                <span class="text-[10px] text-[#9C785C]">{{ $b->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach

                @foreach($recentGuests as $g)
                    <a href="{{ route('admin.guests') }}" class="block p-3 hover:bg-[#F3ECE0] transition">
                        <div class="flex items-start gap-2.5">
                            <span class="w-2 h-2 rounded-full bg-[#356368] mt-1.5 shrink-0"></span>
                            <div class="flex-1">
                                <p class="text-xs font-bold text-[#5C402C]">Tamu Baru: {{ $g->guest_name }}</p>
                                <p class="text-[11px] text-[#8F6547]">Kamar {{ $g->room->room_number ?? '-' }} • {{ $g->duration }}</p>
                                <span class="text-[10px] text-[#9C785C]">{{ $g->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
    </div>
</div>