<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.menus.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-900 shadow-sm border border-gray-100 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    Edit Menu
                </h2>
                <p class="text-sm text-gray-500">Memperbarui informasi untuk: <span class="font-bold text-gray-800">{{ $menu->namaMenu }}</span></p>
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

            <form method="POST" action="{{ route('admin.menus.update', $menu->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- KOLOM KIRI: DETAIL UTAMA --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h3 class="text-lg font-bold text-gray-800 mb-6 flex items-center gap-2">
                                <i data-lucide="file-text" class="w-5 h-5 text-gray-400"></i> Informasi Produk
                            </h3>

                            <div class="space-y-6">
                                {{-- Nama Menu --}}
                                <div>
                                    <x-input-label for="namaMenu" :value="__('Nama Menu')" />
                                    <x-text-input id="namaMenu" class="block mt-1 w-full" type="text" name="namaMenu" :value="old('namaMenu', $menu->namaMenu)" required placeholder="Contoh: Nasi Goreng Spesial" />
                                    <x-input-error :messages="$errors->get('namaMenu')" class="mt-2" />
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <x-input-label for="deskripsi" :value="__('Deskripsi Singkat')" />
                                    <textarea id="deskripsi" name="deskripsi" rows="4" 
                                              class="block mt-1 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm text-sm"
                                              placeholder="Jelaskan rasa, bahan utama, atau keunikan menu ini...">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
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
                                                   placeholder="0" value="{{ old('harga', $menu->harga) }}" required min="1"
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
                                                   placeholder="Contoh: 50" value="{{ old('kapasitas', $menu->kapasitas) }}" required min="1"
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
                                    <input type="radio" name="kategori" value="makanan" class="peer sr-only" {{ old('kategori', $menu->kategori) == 'makanan' ? 'checked' : '' }}>
                                    <div class="p-3 rounded-xl border-2 border-gray-100 bg-gray-50 peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-white transition-all text-center">
                                        <div class="mx-auto w-8 h-8 bg-white rounded-full flex items-center justify-center mb-2 shadow-sm">
                                            <i data-lucide="utensils" class="w-4 h-4 text-orange-500"></i>
                                        </div>
                                        <span class="text-xs font-bold text-gray-700 block">Makanan</span>
                                    </div>
                                </label>
                                
                                {{-- Minuman --}}
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="kategori" value="minuman" class="peer sr-only" {{ old('kategori', $menu->kategori) == 'minuman' ? 'checked' : '' }}>
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
                            
                            {{-- Preview Gambar Lama --}}
                            <div class="relative w-full aspect-video rounded-xl overflow-hidden bg-gray-100 border border-gray-200 mb-4 group">
                                @if($menu->gambar)
                                    <img src="{{ asset($menu->gambar) }}" class="w-full h-full object-cover" alt="Preview">
                                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <p class="text-white text-xs font-medium">Gambar Saat Ini</p>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                        <i data-lucide="image" class="w-8 h-8 mb-2"></i>
                                        <span class="text-xs">Belum ada gambar</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Input File --}}
                            <label class="block">
                                <span class="sr-only">Pilih gambar</span>
                                <input type="file" name="gambar" class="block w-full text-sm text-gray-500
                                  file:mr-4 file:py-2.5 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-xs file:font-bold
                                  file:bg-red-50 file:text-red-700
                                  hover:file:bg-red-100
                                  cursor-pointer transition-colors
                                "/>
                            </label>
                            <p class="text-[10px] text-gray-400 mt-2">*Format: JPG, PNG. Maks 2MB. Kosongkan jika tidak ingin mengubah.</p>
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
                        <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>