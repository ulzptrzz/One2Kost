<x-layouts::auth :title="__('Reset password')">
    <div class="flex flex-col gap-6">
        <div class="space-y-1.5">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#5C402C]">Reset Password</h1>
            <p class="text-xs sm:text-sm text-[#8F6547]">Masukkan password baru Anda di bawah ini</p>
        </div>

        <x-auth-session-status class="text-xs font-medium text-[#7A563C]" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-4">
            @csrf
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email -->
            <div>
                <label for="email" class="block text-xs font-semibold text-[#5C402C] mb-1.5">Email</label>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email', request('email')) }}"
                       readonly
                       required
                       class="w-full px-3.5 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#EFE4D4] text-sm text-[#7A563C] outline-none cursor-not-allowed">
                @error('email')
                    <p class="mt-1 text-xs text-[#9E4735]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Baru -->
            <div x-data="{ show: false }">
                <label for="password" class="block text-xs font-semibold text-[#5C402C] mb-1.5">Password Baru</label>
                <div class="relative">
                    <input id="password"
                           name="password"
                           :type="show ? 'text' : 'password'"
                           required
                           autofocus
                           autocomplete="new-password"
                           placeholder="Minimal 8 karakter"
                           class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-sm text-[#5C402C] placeholder-[#A88B73] focus:bg-[#FAF6EE] focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B] outline-none transition">
                    <button type="button"
                            @click="show = !show"
                            aria-label="Lihat password"
                            class="absolute inset-y-0 right-3 flex items-center text-[#8F6547] hover:text-[#5C402C]">
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-[#9E4735]">{{ $message }}</p>
                @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div x-data="{ show: false }">
                <label for="password_confirmation" class="block text-xs font-semibold text-[#5C402C] mb-1.5">Konfirmasi Password</label>
                <div class="relative">
                    <input id="password_confirmation"
                           name="password_confirmation"
                           :type="show ? 'text' : 'password'"
                           required
                           autocomplete="new-password"
                           placeholder="Ulangi password baru"
                           class="w-full pl-3.5 pr-10 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-sm text-[#5C402C] placeholder-[#A88B73] focus:bg-[#FAF6EE] focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B] outline-none transition">
                    <button type="button"
                            @click="show = !show"
                            aria-label="Lihat konfirmasi password"
                            class="absolute inset-y-0 right-3 flex items-center text-[#8F6547] hover:text-[#5C402C]">
                        <svg x-show="!show" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        <svg x-show="show" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="mt-1 text-xs text-[#9E4735]">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-1">
                <button type="submit" data-test="reset-password-button"
                        class="w-full py-2.5 px-5 rounded-full bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] text-sm font-semibold shadow-xs transition cursor-pointer">
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>