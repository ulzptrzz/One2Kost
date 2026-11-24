<x-layouts::auth :title="__('Two-factor authentication')">
    <div class="flex flex-col gap-6"
         x-cloak
         x-data="{
            showRecoveryInput: @js($errors->has('recovery_code')),
            code: '',
            recovery_code: '',
            toggleInput() {
                this.showRecoveryInput = !this.showRecoveryInput;
                this.code = '';
                this.recovery_code = '';
                $nextTick(() => {
                    this.showRecoveryInput
                        ? this.$refs.recovery_code?.focus()
                        : this.$refs.code?.focus();
                });
            }
         }">

        <div x-show="!showRecoveryInput" class="space-y-1.5">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#5C402C]">Kode Autentikasi</h1>
            <p class="text-xs sm:text-sm text-[#8F6547]">Masukkan 6 digit kode dari aplikasi autentikator Anda.</p>
        </div>

        <div x-show="showRecoveryInput" class="space-y-1.5">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-[#5C402C]">Kode Pemulihan</h1>
            <p class="text-xs sm:text-sm text-[#8F6547]">Masukkan salah satu kode pemulihan darurat akun Anda.</p>
        </div>

        <form method="POST" action="{{ route('two-factor.login.store') }}" class="flex flex-col gap-4">
            @csrf

            <div x-show="!showRecoveryInput">
                <label for="code" class="block text-xs font-semibold text-[#5C402C] mb-1.5">Kode OTP (6 Digit)</label>
                <input id="code"
                       x-ref="code"
                       x-model="code"
                       type="text"
                       inputmode="numeric"
                       maxlength="6"
                       name="code"
                       autocomplete="one-time-code"
                       placeholder="000000"
                       class="w-full px-4 py-3 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-center text-lg font-bold tracking-[0.5em] text-[#5C402C] placeholder-[#A88B73] focus:bg-[#FAF6EE] focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B] outline-none transition">
                @error('code')
                    <p class="mt-1 text-xs text-[#9E4735]">{{ $message }}</p>
                @enderror
            </div>

            <div x-show="showRecoveryInput">
                <label for="recovery_code" class="block text-xs font-semibold text-[#5C402C] mb-1.5">Kode Pemulihan</label>
                <input id="recovery_code"
                       x-ref="recovery_code"
                       x-model="recovery_code"
                       type="text"
                       name="recovery_code"
                       x-bind:required="showRecoveryInput"
                       autocomplete="one-time-code"
                       placeholder="Masukkan kode pemulihan"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-[#DDD0BC] bg-[#F3ECE0] text-sm text-[#5C402C] placeholder-[#A88B73] focus:bg-[#FAF6EE] focus:ring-2 focus:ring-[#A67B5B]/25 focus:border-[#A67B5B] outline-none transition">
                @error('recovery_code')
                    <p class="mt-1 text-xs text-[#9E4735]">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-1">
                <button type="submit"
                        class="w-full py-2.5 px-5 rounded-full bg-[#A67B5B] hover:bg-[#8F6547] text-[#FAF6EE] text-sm font-semibold shadow-xs transition cursor-pointer">
                    Lanjutkan
                </button>
            </div>

            <div class="text-xs sm:text-sm text-center text-[#8F6547] pt-1">
                <span>Atau</span>
                <button type="button" @click="toggleInput()" class="text-[#5C402C] hover:text-[#A67B5B] font-semibold ml-1 underline cursor-pointer">
                    <span x-show="!showRecoveryInput">masuk dengan kode pemulihan</span>
                    <span x-show="showRecoveryInput">masuk dengan kode autentikasi</span>
                </button>
            </div>
        </form>
    </div>
</x-layouts::auth>