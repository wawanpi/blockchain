<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.menus.index') }}" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-900 shadow-sm border border-gray-100 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    {{ __('Detail Menu') }}
                </h2>
                <p class="text-sm text-gray-500">{{ $menu->namaMenu }}</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                {{-- === KOLOM KIRI: INFO MENU === --}}
                <div class="md:col-span-1 space-y-6">
                    
                    {{-- Kartu Info Utama --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative group">
                        
                        {{-- Gambar Menu --}}
                        <div class="relative h-64 w-full bg-gray-100">
                            @if($menu->gambar)
                                <img src="{{ asset($menu->gambar) }}" 
                                     alt="{{ $menu->namaMenu }}" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     onerror="this.src='https://placehold.co/400x300/f1f5f9/94a3b8?text=No+Image'">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <i data-lucide="image" class="w-12 h-12"></i>
                                </div>
                            @endif

                            {{-- Badge Status Stok di Atas Gambar --}}
                            @php
                                $sisa = $menu->jumlah_saat_ini;
                                $statusClass = $sisa <= 0 ? 'bg-red-600 text-white' : ($sisa <= 10 ? 'bg-orange-500 text-white' : 'bg-green-500 text-white');
                                $statusText = $sisa <= 0 ? 'Habis' : ($sisa <= 10 ? 'Menipis' : 'Tersedia');
                            @endphp
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold uppercase shadow-md {{ $statusClass }}">
                                {{ $statusText }}
                            </div>
                        </div>

                        <div class="p-6">
                            {{-- Judul & Kategori --}}
                            <div class="flex justify-between items-start mb-2">
                                <h1 class="text-2xl font-black text-gray-800 leading-tight">{{ $menu->namaMenu }}</h1>
                            </div>
                            
                            <div class="flex items-center gap-2 mb-6">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider
                                    {{ $menu->kategori == 'makanan' ? 'bg-orange-50 text-orange-700' : 'bg-blue-50 text-blue-700' }}">
                                    {{ ucfirst($menu->kategori) }}
                                </span>
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600 flex items-center gap-1">
                                    <i data-lucide="box" class="w-3 h-3"></i> Stok: {{ $sisa }}
                                </span>
                            </div>

                            {{-- Harga --}}
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-sm text-gray-500 font-medium">Harga</span>
                                <span class="text-3xl font-black text-[#D40000]">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-8">
                                <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                                    <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i> Deskripsi
                                </h4>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    {{ $menu->deskripsi ?? 'Tidak ada deskripsi tersedia untuk menu ini.' }}
                                </p>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="space-y-3">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                   class="flex items-center justify-center w-full px-4 py-3 bg-gray-900 text-white rounded-xl font-bold text-sm hover:bg-black transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i> Edit Menu
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                
                {{-- === KOLOM KANAN: ULASAN === --}}
                <div class="md:col-span-2 space-y-6">
                    
                    {{-- Kartu Ringkasan Rating --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex items-center gap-6">
                        <div class="text-center px-4 border-r border-gray-100">
                            <p class="text-5xl font-black text-gray-900">{{ number_format($menu->average_rating, 1) }}</p>
                            <div class="flex items-center justify-center gap-1 text-yellow-400 my-2">
                                @for($i=1; $i<=5; $i++)
                                    <i data-lucide="star" class="w-4 h-4 {{ $menu->average_rating >= $i ? 'fill-current' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                            <p class="text-xs text-gray-500 font-medium">{{ $menu->ratings_count }} Ulasan</p>
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Analitik Ulasan</h3>
                            <p class="text-sm text-gray-500">Ringkasan kepuasan pelanggan terhadap menu ini.</p>
                        </div>
                    </div>

                    {{-- Daftar Ulasan --}}
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Ulasan Pelanggan</h3>
                        </div>

                        <div class="divide-y divide-gray-50 max-h-[600px] overflow-y-auto custom-scrollbar p-6 space-y-6">
                            @forelse($menu->reviews as $review)
                                <div class="flex gap-4">
                                    {{-- Avatar User --}}
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-sm font-bold text-gray-600 border border-gray-200">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                                <div class="flex items-center gap-1 mt-0.5">
                                                    @for($i=1; $i<=5; $i++)
                                                        <i data-lucide="star" class="w-3 h-3 {{ $review->rating >= $i ? 'text-yellow-400 fill-current' : 'text-gray-200' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        
                                        <div class="mt-3 bg-gray-50 rounded-xl p-3 text-sm text-gray-600 italic border border-gray-100">
                                            "{{ $review->komentar ?? 'Tidak ada komentar tertulis.' }}"
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                        <i data-lucide="message-square-off" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada ulasan untuk menu ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>