<x-guest-layout>
    <div class="mb-6 text-sm text-gray-600 leading-relaxed">
        {{ __('Lupa kata sandi? Tidak masalah. Cukup beri tahu kami alamat email Anda dan kami akan mengirimkan tautan pengaturan ulang kata sandi yang memungkinkan Anda memilih yang baru.') }}
    </div>

    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                </div>
                <x-text-input id="email" class="block w-full pl-10 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm" type="email" name="email" :value="old('email')" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#D40000] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-red-200">
                {{ __('Kirim Link Reset Password') }}
            </button>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-[#D40000] transition-colors flex items-center justify-center gap-1">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Login
            </a>
        </div>
    </form>
</x-guest-layout>