<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg text-[#D40000]">
                    <i data-lucide="utensils-crossed" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="font-black text-xl text-gray-800 leading-tight">
                        {{ __('Manajemen Menu') }}
                    </h2>
                    <p class="text-sm text-gray-500">Kelola daftar menu, harga, dan ketersediaan stok.</p>
                </div>
            </div>
            
            <a href="{{ route('admin.menus.create') }}" 
               class="inline-flex items-center justify-center px-5 py-2.5 bg-[#D40000] text-white font-bold text-sm rounded-xl shadow-lg shadow-red-200 hover:bg-red-700 hover:-translate-y-0.5 transition-all gap-2">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Tambah Menu Baru
            </a>
        </div>
    </x-slot>

    {{-- TAMBAHKAN x-data DI WRAPPER UTAMA --}}
    <div class="py-8 bg-gray-50 min-h-screen" x-data="{ searchQuery: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Notifikasi Sukses --}}
            @if ($message = Session::get('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6 flex justify-between items-center" role="alert">
                    <div class="flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        <span>{{ $message }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700"><i data-lucide="x" class="w-4 h-4"></i></button>
                </div>
            @endif

            {{-- Main Content Card --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                
                {{-- Toolbar: Search (CLIENT SIDE - ALPINE JS) --}}
                <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2">
                        <i data-lucide="list" class="w-4 h-4 text-gray-400"></i> Daftar Menu
                    </h3>
                    
                    {{-- Input Search (Tanpa Form Submit) --}}
                    <div class="relative w-full sm:w-72">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Cari menu..." 
                               class="w-full pl-10 pr-10 py-2 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 text-sm shadow-sm transition-all">
                        
                        <div class="absolute left-3 top-2.5 text-gray-400">
                            <i data-lucide="search" class="w-4 h-4"></i>
                        </div>

                        {{-- Tombol Clear (X) --}}
                        <button x-show="searchQuery.length > 0" 
                                @click="searchQuery = ''" 
                                class="absolute right-3 top-2.5 text-gray-400 hover:text-red-500 transition-colors"
                                style="display: none;"> {{-- Default hidden, Alpine will handle visibility --}}
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Harga & Rating</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Stok Harian</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-50">
                            @forelse ($menus as $menu)
                                {{-- 
                                    LOGIKA SEARCH ALPINE:
                                    x-show="!searchQuery || '...'.includes(...)"
                                --}}
                                <tr class="hover:bg-gray-50/80 transition-colors group"
                                    x-show="!searchQuery || '{{ strtolower($menu->namaMenu) }}'.includes(searchQuery.toLowerCase())"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100">
                                    
                                    {{-- Produk (Gambar & Nama) --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-4">
                                            <div class="h-16 w-16 flex-shrink-0 rounded-xl overflow-hidden border border-gray-100 shadow-sm bg-gray-50">
                                                @if($menu->gambar)
                                                    <img class="h-full w-full object-cover" src="{{ asset($menu->gambar) }}" alt="{{ $menu->namaMenu }}" onerror="this.src='https://placehold.co/64x64/f1f5f9/94a3b8?text=IMG'">
                                                @else
                                                    <div class="h-full w-full flex items-center justify-center text-gray-300">
                                                        <i data-lucide="image" class="w-6 h-6"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                {{-- Highlight text search match (optional, but keep simple first) --}}
                                                <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $menu->namaMenu }}</div>
                                                <div class="text-xs text-gray-400 mt-0.5">ID: #{{ $menu->id }}</div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Kategori --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($menu->kategori == 'makanan')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100">
                                                <i data-lucide="soup" class="w-3 h-3"></i> Makanan
                                            </span>
                                        @elseif($menu->kategori == 'minuman')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                <i data-lucide="coffee" class="w-3 h-3"></i> Minuman
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600">
                                                {{ ucfirst($menu->kategori) }}
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Harga & Rating --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-gray-900">Rp {{ number_format($menu->harga, 0, ',', '.') }}</div>
                                        <div class="flex items-center gap-1 mt-1 text-xs text-yellow-500 font-bold">
                                            <i data-lucide="star" class="w-3 h-3 fill-current"></i>
                                            {{ number_format($menu->average_rating, 1) }}
                                            <span class="text-gray-400 font-normal ml-1">({{ $menu->ratings_count }} ulasan)</span>
                                        </div>
                                    </td>

                                    {{-- Stok --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex flex-col items-center">
                                            @php
                                                $sisa = $menu->jumlah_saat_ini;
                                                $kapasitas = $menu->kapasitas;
                                                $persen = $kapasitas > 0 ? ($sisa / $kapasitas) * 100 : 0;
                                                
                                                $color = 'bg-green-500';
                                                if($sisa <= 0) $color = 'bg-gray-400';
                                                elseif($persen <= 30) $color = 'bg-red-500';
                                                elseif($persen <= 60) $color = 'bg-yellow-500';
                                            @endphp

                                            <div class="text-sm font-bold {{ $sisa <= 0 ? 'text-red-600' : 'text-gray-700' }}">
                                                {{ $sisa }} <span class="text-gray-400 text-xs font-normal">/ {{ $kapasitas }}</span>
                                            </div>
                                            
                                            {{-- Progress Bar Mini --}}
                                            <div class="w-16 h-1.5 bg-gray-100 rounded-full mt-1.5 overflow-hidden">
                                                <div class="h-full {{ $color }} rounded-full" style="width: {{ $persen }}%"></div>
                                            </div>

                                            @if($sisa <= 0)
                                                <span class="text-[10px] font-bold text-red-600 mt-1 uppercase tracking-wider">Habis</span>
                                            @elseif($persen <= 30)
                                                <span class="text-[10px] font-bold text-red-500 mt-1 uppercase tracking-wider">Menipis</span>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- Ulasan --}}
                                            <a href="{{ route('admin.menus.show', $menu->id) }}" 
                                               class="p-2 rounded-lg text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                               title="Lihat Ulasan">
                                                <i data-lucide="message-square" class="w-4 h-4"></i>
                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                               class="p-2 rounded-lg text-gray-400 hover:text-yellow-600 hover:bg-yellow-50 transition-colors"
                                               title="Edit Menu">
                                                <i data-lucide="edit-3" class="w-4 h-4"></i>
                                            </a>

                                            {{-- Hapus --}}
                                            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus menu ini? Data tidak bisa dikembalikan.');" 
                                                  class="m-0 block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="p-2 rounded-lg text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
                                                        title="Hapus Menu">
                                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                {{-- Pesan Kosong Jika Data Database Kosong --}}
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="mx-auto w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="search-x" class="w-10 h-10 text-gray-300"></i>
                                        </div>
                                        <h3 class="text-gray-900 font-bold text-lg">Menu tidak ditemukan</h3>
                                        <p class="text-gray-500 text-sm mt-1">Coba kata kunci lain atau tambahkan menu baru.</p>
                                    </td>
                                </tr>
                            @endforelse

                            {{-- Pesan Kosong Jika Hasil Search Tidak Ditemukan (Opsional) --}}
                            {{-- Catatan: Alpine tidak mudah mendeteksi '0 results' di loop blade server-side yang sudah ter-render. 
                                 Solusi sederhana: Jika semua baris disembunyikan, tabel akan kosong. --}}
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($menus->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        {{ $menus->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>