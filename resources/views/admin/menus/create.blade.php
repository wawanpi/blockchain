<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.menus.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-900 shadow-sm border border-gray-100 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    Tambah Menu Baru
                </h2>
                <p class="text-sm text-gray-500">Tambahkan sajian lezat baru ke daftar menu.</p>
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
                        <strong class="font-bold">Gagal Menyimpan!</strong>
                    </div>
                    <ul class="list-disc list-inside text-sm ml-7">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: DETAIL UTAMA --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <i data-lucide="file-plus" class="w-5 h-5 text-gray-400"></i> Informasi Produk
                            </h3>

                            <div class="space-y-6">
                                {{-- Nama Menu --}}
                                <div>
                                    <x-input-label for="namaMenu" :value="__('Nama Menu')" />
                                    <x-text-input id="namaMenu" class="block mt-1 w-full" type="text" name="namaMenu" :value="old('namaMenu')" required placeholder="Contoh: Magelangan Jumbo" autofocus />
                                    <x-input-error :messages="$errors->get('namaMenu')" class="mt-2" />
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <x-input-label for="deskripsi" :value="__('Deskripsi Singkat')" />
                                    <textarea id="deskripsi" name="deskripsi" rows="4" 
                                              class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm"
                                              placeholder="Jelaskan rasa, bahan utama, atau keunikan menu ini...">{{ old('deskripsi') }}</textarea>
                                    <x-input-error :messages="$errors->get('deskripsi')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Harga --}}
                                    <div>
                                        <x-input-label for="harga" :value="__('Harga Jual')" />
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <span class="text-gray-500 sm:text-sm font-bold">Rp</span>
                                            </div>
                                            <input type="number" name="harga" id="harga" 
                                                   class="block w-full rounded-xl border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500 sm:text-sm py-2.5" 
                                                   placeholder="0" value="{{ old('harga') }}" required min="1"
                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                        <x-input-error :messages="$errors->get('harga')" class="mt-2" />
                                    </div>

                                    {{-- Kapasitas / Stok --}}
                                    <div>
                                        <x-input-label for="kapasitas" :value="__('Stok Harian (Porsi)')" />
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                                <i data-lucide="package" class="w-4 h-4 text-gray-400"></i>
                                            </div>
                                            <input type="number" name="kapasitas" id="kapasitas" 
                                                   class="block w-full rounded-xl border-gray-300 pl-10 focus:border-red-500 focus:ring-red-500 sm:text-sm py-2.5" 
                                                   placeholder="Contoh: 50" value="{{ old('kapasitas') }}" required min="1"
                                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                        <x-input-error :messages="$errors->get('kapasitas')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: KATEGORI & GAMBAR --}}
                    <div class="lg:col-span-1 space-y-6">
                        
                        {{-- Kategori (Radio Cards) --}}
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Kategori</h3>
                            <div class="grid grid-cols-2 gap-3">
                                {{-- Makanan --}}
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="kategori" value="makanan" class="peer sr-only" {{ old('kategori') == 'makanan' ? 'checked' : '' }}>
                                    <div class="p-3 rounded-xl border-2 border-gray-100 bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-white transition-all text-center">
                                        <div class="mx-auto w-8 h-8 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm">
                                            <i data-lucide="utensils" class="w-4 h-4 text-orange-500"></i>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700 block">Makanan</span>
                                    </div>
                                </label>
                                
                                {{-- Minuman --}}
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="kategori" value="minuman" class="peer sr-only" {{ old('kategori') == 'minuman' ? 'checked' : '' }}>
                                    <div class="p-3 rounded-xl border-2 border-gray-100 bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-white transition-all text-center">
                                        <div class="mx-auto w-8 h-8 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm">
                                            <i data-lucide="coffee" class="w-4 h-4 text-blue-500"></i>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700 block">Minuman</span>
                                    </div>
                                </label>
                            </div>
                            <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                        </div>

                        {{-- Upload Gambar --}}
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-sm font-bold text-gray-800 mb-4 uppercase tracking-wider">Foto Produk</h3>
                            
                            {{-- Dropzone Style Input --}}
                            <div class="relative border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors p-6 flex flex-col items-center justify-center text-center cursor-pointer group">
                                <i data-lucide="image-plus" class="w-10 h-10 text-gray-400 group-hover:text-red-500 transition-colors mb-3"></i>
                                <div class="text-sm text-gray-600 font-medium">
                                    <label for="gambar" class="relative cursor-pointer rounded-md font-bold text-red-600 hover:text-red-500 focus-within:outline-none">
                                        <span>Upload file</span>
                                        <input id="gambar" name="gambar" type="file" class="sr-only" required>
                                    </label>
                                    <span class="pl-1 font-normal">atau drag ke sini</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG (Max. 2MB)</p>
                            </div>
                            <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                        </div>

                    </div>
                </div>

                {{-- TOMBOL AKSI STICKY --}}
                <div class="mt-8 flex justify-end gap-4 border-t border-gray-200 pt-6">
                    <a href="{{ route('admin.menus.index') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-bold text-sm hover:bg-gray-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-gray-900 text-white font-bold text-sm shadow-lg hover:bg-black transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Simpan Menu
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>