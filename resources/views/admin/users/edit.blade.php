<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.users.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-900 shadow-sm border border-gray-100 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    Edit Pengguna
                </h2>
                <p class="text-sm text-gray-500">Memperbarui data untuk: <span class="font-bold text-gray-800">{{ $user->name }}</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Error --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm">
                    <div class="flex items-center gap-2 mb-1">
                        <i data-lucide="alert-circle" class="w-5 h-5"></i>
                        <strong class="font-bold">Gagal Memperbarui!</strong>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    {{-- KOLOM KIRI: INFORMASI PROFIL --}}
                    <div class="space-y-6">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <i data-lucide="user" class="w-5 h-5 text-gray-400"></i> Informasi Akun
                            </h3>

                            <div class="space-y-5">
                                {{-- Nama --}}
                                <div>
                                    {{-- PERBAIKAN: Label dibold dan dihitamkan --}}
                                    <x-input-label for="name" :value="__('Nama Lengkap')" class="!text-gray-900 !font-bold !text-sm mb-1" />
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                        <x-text-input id="name" 
                                            class="block w-full pl-10 !bg-white !border-gray-300 !text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                                            type="text" 
                                            name="name" 
                                            :value="old('name', $user->name)" 
                                            required 
                                            autofocus 
                                            placeholder="Contoh: Budi Santoso" />
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div>
                                    {{-- PERBAIKAN: Label dibold dan dihitamkan --}}
                                    <x-input-label for="email" :value="__('Alamat Email')" class="!text-gray-900 !font-bold !text-sm mb-1" />
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                        <x-text-input id="email" 
                                            class="block w-full pl-10 !bg-white !border-gray-300 !text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                                            type="email" 
                                            name="email" 
                                            :value="old('email', $user->email)" 
                                            required 
                                            autocomplete="username" 
                                            placeholder="budi@example.com" />
                                    </div>
                                </div>

                                {{-- No HP / WhatsApp --}}
                                <div>
                                    {{-- PERBAIKAN: Label dibold dan dihitamkan --}}
                                    <x-input-label for="phone_number" :value="__('No HP / WhatsApp')" class="!text-gray-900 !font-bold !text-sm mb-1" />
                                    <div class="relative mt-1">
                                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                            <i data-lucide="phone" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                        <x-text-input id="phone_number" 
                                            class="block w-full pl-10 !bg-white !border-gray-300 !text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                                            type="text" 
                                            name="phone_number" 
                                            :value="old('phone_number', $user->phone_number)" 
                                            required 
                                            placeholder="08xxxxxxxxxx" />
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: KEAMANAN & AKSES --}}
                    <div class="space-y-6">
                        
                        {{-- Password --}}
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <i data-lucide="lock" class="w-5 h-5 text-gray-400"></i> Keamanan
                            </h3>
                            
                            <div class="space-y-5">
                                <div class="bg-yellow-50 text-yellow-800 text-xs p-3 rounded-lg border border-yellow-100 flex gap-2">
                                    <i data-lucide="info" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
                                    <span>Biarkan kolom password kosong jika Anda tidak ingin mengubah password pengguna ini.</span>
                                </div>

                                <div>
                                    {{-- PERBAIKAN: Label dibold dan dihitamkan --}}
                                    <x-input-label for="password" :value="__('Password Baru')" class="!text-gray-900 !font-bold !text-sm mb-1" />
                                    <x-text-input id="password" 
                                        class="block mt-1 w-full !bg-white !border-gray-300 !text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                                        type="password" 
                                        name="password" 
                                        autocomplete="new-password" 
                                        placeholder="••••••••" />
                                </div>

                                <div>
                                    {{-- PERBAIKAN: Label dibold dan dihitamkan --}}
                                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" class="!text-gray-900 !font-bold !text-sm mb-1" />
                                    <x-text-input id="password_confirmation" 
                                        class="block mt-1 w-full !bg-white !border-gray-300 !text-gray-900 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm" 
                                        type="password" 
                                        name="password_confirmation" 
                                        autocomplete="new-password" 
                                        placeholder="••••••••" />
                                </div>
                            </div>
                        </div>

                        {{-- Role --}}
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                                <i data-lucide="shield" class="w-5 h-5 text-gray-400"></i> Hak Akses (Role)
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-3">
                                @foreach($roles as $role)
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="roles" value="{{ $role }}" class="peer sr-only" {{ old('roles', $userRole) == $role ? 'checked' : '' }}>
                                        <div class="p-3 rounded-xl border-2 border-gray-100 bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-white transition-all text-center">
                                            <div class="mx-auto w-8 h-8 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm">
                                                @if($role == 'admin')
                                                    <i data-lucide="shield-check" class="w-4 h-4 text-red-600"></i>
                                                @else
                                                    <i data-lucide="user" class="w-4 h-4 text-gray-600"></i>
                                                @endif
                                            </div>
                                            <span class="text-xs font-bold text-gray-700 block uppercase">{{ $role }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                {{-- TOMBOL AKSI STICKY --}}
                <div class="mt-8 flex justify-end gap-4 border-t border-gray-200 pt-6">
                    <a href="{{ route('admin.users.index') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-gray-900 text-white font-bold text-sm shadow-lg hover:bg-black transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>