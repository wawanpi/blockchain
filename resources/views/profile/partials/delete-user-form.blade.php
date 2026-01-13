<section class="space-y-6">
    <header class="flex items-start gap-4 mb-6">
        <div class="p-2 bg-red-50 rounded-lg text-red-600">
            <i data-lucide="alert-triangle" class="w-6 h-6"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">
                {{ __('Hapus Akun') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Setelah akun dihapus, semua data dan sumber daya akan dihapus secara permanen. Harap unduh data penting sebelum melanjutkan.') }}
            </p>
        </div>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors"
    >
        {{ __('Hapus Akun') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mb-4">
                <div class="p-2 bg-red-100 rounded-full text-red-600">
                    <i data-lucide="alert-octagon" class="w-6 h-6"></i>
                </div>
                <h2 class="text-lg font-bold text-gray-900">
                    {{ __('Apakah Anda yakin ingin menghapus akun?') }}
                </h2>
            </div>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Setelah akun dihapus, semua data akan hilang permanen. Masukkan password Anda untuk konfirmasi.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="rounded-xl">
                    {{ __('Batal') }}
                </x-secondary-button>

                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                    {{ __('Hapus Akun') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>