<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-6">
        <div class="text-center space-y-1.5">
            <h1 class="text-xl font-bold tracking-tight text-[#2D231C]">Lupa Password</h1>
            <p class="text-xs sm:text-sm text-[#6E5F53]">Masukkan email akun Anda untuk menerima tautan reset password</p>
        </div>

        <x-auth-session-status class="text-center text-xs font-medium text-[#5B8552]" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-4">
            @csrf

            <div>
                <label for="email" class="block text-xs font-semibold text-[#2D231C] mb-1.5">Email</label>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       placeholder="nama@email.com"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-sm text-[#2D231C] placeholder-[#9A8B7E] focus:bg-[#FAF6EE] focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B] outline-none transition">
                @error('email')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-1">
                <button type="submit" data-test="email-password-reset-link-button"
                        class="w-full py-2.5 px-5 rounded-full bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] text-sm font-semibold shadow-xs transition cursor-pointer">
                    Kirim Tautan Reset Password
                </button>
            </div>
        </form>

        <div class="text-xs sm:text-sm text-center text-[#6E5F53]">
            <span>Kembali ke halaman</span>
            <a href="{{ route('login') }}" wire:navigate class="text-[#8F6547] hover:text-[#6E4D36] font-semibold ml-1">
                Masuk
            </a>
        </div>
    </div>
</x-layouts::auth>