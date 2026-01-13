<section>
    <header class="flex items-start gap-4 mb-6">
        <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
            <i data-lucide="id-card" class="w-6 h-6"></i>
        </div>
        <div>
            <h2 class="text-lg font-bold text-gray-900">
                {{ __('Informasi Profil') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                {{ __("Perbarui informasi profil akun dan alamat email Anda.") }}
            </p>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                </div>
                <x-text-input id="name" name="name" type="text" class="pl-10 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                </div>
                <x-text-input id="email" name="email" type="email" class="pl-10 block w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm" :value="old('email', $user->email)" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800 flex items-start gap-2">
                        <i data-lucide="alert-triangle" class="w-4 h-4 mt-0.5 shrink-0"></i>
                        <span>
                            {{ __('Email Anda belum diverifikasi.') }}
                            <button form="send-verification" class="underline hover:text-yellow-900 font-medium ml-1">
                                {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                            </button>
                        </span>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 flex items-center gap-2">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            {{ __('Link verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-black transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-medium flex items-center gap-1"
                >
                    <i data-lucide="check" class="w-4 h-4"></i> {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>