<x-layouts::auth :title="__('Email verification')">
    <div class="flex flex-col gap-6">
        <div class="space-y-1.5">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#5C402C]">Verifikasi Email</h1>
            <p class="text-xs sm:text-sm text-[#8F6547] leading-relaxed">
                Silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan ke email Anda.
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="p-3.5 rounded-2xl bg-[#EFE4D4] border border-[#DEC9AF] text-xs font-medium text-[#5C402C]">
                Tautan verifikasi baru telah dikirim ke alamat email yang Anda daftarkan.
            </div>
        @endif

        <div class="flex flex-col gap-3 pt-1">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="w-full py-2.5 px-5 rounded-full bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] text-sm font-semibold shadow-xs transition cursor-pointer">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" data-test="logout-button"
                        class="text-xs sm:text-sm font-semibold text-[#8F6547] hover:text-[#5C402C] py-2 transition cursor-pointer">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</x-layouts::auth>