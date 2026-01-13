<x-guest-layout>
    <div class="mb-6 text-sm text-gray-600">
        {{ __('Ini adalah area aplikasi yang aman. Harap konfirmasi kata sandi Anda sebelum melanjutkan.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                </div>
                <x-text-input id="password" class="block w-full pl-10 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-6">
            <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-3 bg-[#D40000] border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg shadow-red-200">
                {{ __('Konfirmasi') }}
            </button>
        </div>
    </form>
</x-guest-layout>