<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-900 shadow-sm border border-gray-100 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    Tambah Stok Harian
                </h2>
                <p class="text-sm text-gray-500">Update ketersediaan porsi untuk hari ini.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen flex items-start justify-center">
        <div class="max-w-lg w-full mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-3xl border border-gray-100">
                
                {{-- Product Header --}}
                <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex items-center gap-5">
                    <div class="relative h-20 w-20 flex-shrink-0">
                        <img src="{{ asset($menu->gambar) }}" 
                             alt="{{ $menu->namaMenu }}" 
                             class="h-full w-full object-cover rounded-2xl border border-gray-200 shadow-sm"
                             onerror="this.src='https://placehold.co/80x80/e2e8f0/94a3b8?text=IMG'">
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider {{ $menu->kategori == 'makanan' ? 'text-orange-600' : 'text-blue-600' }}">
                            {{ $menu->kategori }}
                        </span>
                        <h3 class="text-xl font-black text-gray-900 leading-tight mt-0.5">{{ $menu->namaMenu }}</h3>
                        <p class="text-xs text-gray-500 mt-1">ID: #{{ $menu->id }}</p>
                    </div>
                </div>

                <div class="p-8">
                    
                    {{-- Status Stok Saat Ini --}}
                    <div class="flex justify-between items-center mb-8 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <div>
                            <p class="text-sm font-semibold text-blue-800">Sisa Porsi Saat Ini</p>
                            <p class="text-xs text-blue-600 mt-0.5">Stok tersedia di aplikasi</p>
                        </div>
                        <div class="text-right">
                            <span class="text-3xl font-black {{ $ketersediaan->jumlah_saat_ini <= 5 ? 'text-red-600' : 'text-blue-900' }}">
                                {{ $ketersediaan->jumlah_saat_ini }}
                            </span>
                            <span class="text-sm font-bold text-blue-400">Porsi</span>
                        </div>
                    </div>

                    <form action="{{ route('admin.menus.updateKuota', $menu->id) }}" method="POST" x-data="{ addVal: '' }">
                        @csrf
                        @method('PUT')

                        <div class="mb-8">
                            <label for="tambahan_kuota" class="block text-sm font-bold text-gray-700 mb-2">
                                Tambah Berapa Porsi?
                            </label>
                            
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i data-lucide="plus" class="w-5 h-5 text-gray-400"></i>
                                </div>
                                <input type="number" 
                                       name="tambahan_kuota" 
                                       id="tambahan_kuota" 
                                       x-model="addVal"
                                       min="1" 
                                       class="w-full pl-12 pr-4 py-4 text-lg font-bold text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all shadow-sm"
                                       placeholder="0" 
                                       required 
                                       autofocus>
                            </div>

                            {{-- Quick Add Buttons (Optional UX enhancement) --}}
                            <div class="flex gap-2 mt-3">
                                <button type="button" @click="addVal = 5" class="px-3 py-1.5 text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+5</button>
                                <button type="button" @click="addVal = 10" class="px-3 py-1.5 text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+10</button>
                                <button type="button" @click="addVal = 20" class="px-3 py-1.5 text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+20</button>
                                <button type="button" @click="addVal = 50" class="px-3 py-1.5 text-xs font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors">+50</button>
                            </div>

                            @error('tambahan_kuota')
                                <p class="text-red-500 text-sm font-semibold mt-2 flex items-center gap-1">
                                    <i data-lucide="alert-circle" class="w-4 h-4"></i> {{ $message }}
                                </p>
                            @enderror
                            
                            <p class="text-xs text-gray-400 mt-4 flex items-start gap-1.5">
                                <i data-lucide="info" class="w-4 h-4 mt-0.5 flex-shrink-0"></i>
                                <span>Porsi yang ditambahkan akan langsung dijumlahkan dengan sisa stok saat ini dan tampil di Dashboard.</span>
                            </p>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="w-full sm:w-auto px-6 py-3 text-center bg-white border border-gray-300 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="w-full sm:w-auto px-8 py-3 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-black transition-all shadow-lg shadow-gray-200 hover:shadow-xl transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <i data-lucide="save" class="w-4 h-4"></i>
                                Simpan Stok
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>