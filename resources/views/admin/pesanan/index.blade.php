<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-100 rounded-lg text-[#D40000]">
                    <i data-lucide="shopping-bag" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="font-black text-2xl text-gray-800 tracking-tight">
                        {{ __('Kelola Pesanan') }}
                    </h2>
                    <p class="text-sm text-gray-500 mt-1">Pantau transaksi dan status pesanan masuk.</p>
                </div>
            </div>
            
            {{-- TOMBOL PESANAN OFFLINE --}}
            <button onclick="document.getElementById('modalOffline').classList.remove('hidden')" 
                    class="inline-flex items-center px-5 py-2.5 bg-[#D40000] hover:bg-red-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-red-200 transition-all transform hover:-translate-y-0.5 group">
                <i data-lucide="plus-circle" class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform"></i>
                Pesanan Offline Baru
            </button>
        </div>
    </x-slot>

    {{-- TAMBAHKAN x-data DI SINI --}}
    <div class="py-8 bg-gray-50 min-h-screen" x-data="{ searchQuery: '' }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Toolbar: Search & Filter --}}
            <div class="bg-white p-4 rounded-t-3xl border-b border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4 shadow-sm mt-6">
                
                {{-- Search Bar (CLIENT SIDE) --}}
                <div class="relative w-full md:w-96">
                    <input type="text" 
                           x-model="searchQuery"
                           placeholder="Cari ID / Nama Pelanggan..." 
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl border-gray-200 focus:border-red-500 focus:ring-red-500 text-sm bg-gray-50 focus:bg-white transition-colors shadow-inner">
                    
                    <div class="absolute left-3 top-3 text-gray-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>

                    {{-- Tombol Clear --}}
                    <button x-show="searchQuery.length > 0" 
                            @click="searchQuery = ''" 
                            class="absolute right-3 top-2.5 text-gray-400 hover:text-red-500 transition-colors"
                            style="display: none;">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
                
                {{-- Filter Status Server-Side (Tetap Form Biasa karena logic status kompleks) --}}
                <form method="GET" action="{{ route('admin.pesanan.index') }}">
                    <select name="status" onchange="this.form.submit()" class="rounded-xl border-gray-200 text-sm focus:border-red-500 focus:ring-red-500 bg-gray-50 w-full md:w-auto">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </form>

                {{-- Status Legend --}}
                <div class="hidden md:flex items-center gap-4 text-xs font-medium text-gray-500 border-l border-gray-200 pl-4">
                    <div class="flex items-center gap-1.5"><div class="w-2 h-2 bg-yellow-400 rounded-full"></div> Pending</div>
                    <div class="flex items-center gap-1.5"><div class="w-2 h-2 bg-blue-400 rounded-full"></div> Proses</div>
                    <div class="flex items-center gap-1.5"><div class="w-2 h-2 bg-green-400 rounded-full"></div> Selesai</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-b-3xl border border-gray-100 border-t-0">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">ID & Waktu</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Pelanggan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Layanan</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($pesanans as $pesanan)
                                @php
                                    // Siapkan data string untuk pencarian
                                    $searchString = strtolower($pesanan->id . ' ' . ($pesanan->user->name ?? '') . ' ' . $pesanan->catatan_pelanggan);
                                @endphp

                                {{-- LOGIKA SEARCH ALPINE --}}
                                <tr class="hover:bg-gray-50/80 transition-colors group"
                                    x-show="!searchQuery || '{{ $searchString }}'.includes(searchQuery.toLowerCase())"
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform scale-95"
                                    x-transition:enter-end="opacity-100 transform scale-100">
                                    
                                    {{-- ID & Waktu --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col">
                                            <span class="font-mono text-sm font-bold text-gray-900">#{{ $pesanan->id }}</span>
                                            <span class="text-xs text-gray-400 mt-0.5">{{ $pesanan->created_at->format('d M, H:i') }}</span>
                                        </div>
                                    </td>

                                    {{-- Pelanggan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-9 w-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 font-bold text-xs mr-3 shadow-sm border border-gray-100">
                                                @if(str_contains($pesanan->catatan_pelanggan, 'OFFLINE'))
                                                    <i data-lucide="store" class="w-4 h-4 text-blue-600"></i>
                                                @else
                                                    {{ substr($pesanan->user->name ?? 'G', 0, 1) }}
                                                @endif
                                            </div>
                                            <div>
                                                @if(str_contains($pesanan->catatan_pelanggan, 'OFFLINE'))
                                                    <div class="text-sm font-bold text-gray-900">{{ str_replace('OFFLINE - ', '', $pesanan->catatan_pelanggan) }}</div>
                                                    <div class="text-[10px] font-bold text-blue-600 bg-blue-50 px-1.5 py-0.5 rounded inline-block mt-0.5">OFFLINE</div>
                                                @else
                                                    <div class="text-sm font-bold text-gray-900">{{ $pesanan->user->name }}</div>
                                                    <div class="text-xs text-gray-400">Online Order</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Layanan --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pesanan->tipe_layanan == 'Dine-in')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                                <i data-lucide="utensils" class="w-3 h-3"></i> Dine-in
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-50 text-orange-700 border border-orange-100">
                                                <i data-lucide="shopping-bag" class="w-3 h-3"></i> Take Away
                                            </span>
                                        @endif
                                    </td>
                                    
                                    {{-- Total --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-black text-gray-900">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</div>
                                        <div class="text-xs text-gray-400">{{ $pesanan->details->count() }} Item</div>
                                    </td>
                                    
                                    {{-- Status --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pesanan->status == 'pending')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Pending
                                            </span>
                                        @elseif($pesanan->status == 'processing')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                                <i data-lucide="loader-2" class="w-3 h-3 animate-spin"></i> Proses
                                            </span>
                                        @elseif($pesanan->status == 'completed')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                                <i data-lucide="check-circle" class="w-3 h-3"></i> Selesai
                                            </span>
                                        @elseif($pesanan->status == 'cancelled')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                                                <i data-lucide="x-circle" class="w-3 h-3"></i> Batal
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" 
                                           class="inline-flex items-center justify-center w-8 h-8 bg-white border border-gray-200 rounded-full text-gray-400 hover:text-[#D40000] hover:border-red-200 hover:bg-red-50 transition-all shadow-sm group/btn">
                                            <i data-lucide="chevron-right" class="w-5 h-5 group-hover/btn:translate-x-0.5 transition-transform"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="mx-auto w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="inbox" class="w-10 h-10 text-gray-300"></i>
                                        </div>
                                        <h3 class="text-gray-900 font-bold text-lg">Belum ada pesanan</h3>
                                        <p class="text-gray-500 text-sm mt-1">Pesanan masuk akan muncul di sini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination (Tetap Server-side) --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $pesanans->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PESANAN OFFLINE (Sama seperti sebelumnya) --}}
    <div id="modalOffline" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="document.getElementById('modalOffline').classList.add('hidden')"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <div class="bg-red-100 p-1.5 rounded-lg">
                                <i data-lucide="store" class="w-5 h-5 text-[#D40000]"></i>
                            </div>
                            Pesanan Offline Baru
                        </h3>
                        <button onclick="document.getElementById('modalOffline').classList.add('hidden')" class="text-gray-400 hover:text-red-500 transition rounded-full p-1 hover:bg-red-50">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <form action="{{ route('admin.pesanan.storeOffline') }}" method="POST">
                        @csrf
                        <div class="px-6 py-6 space-y-6">
                            <div>
                                <label for="nama_pelanggan" class="block text-sm font-bold text-gray-700 mb-1">Nama Pelanggan / Meja</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i data-lucide="user" class="w-4 h-4 text-gray-400"></i>
                                    </div>
                                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" 
                                           class="pl-10 w-full rounded-xl border-gray-300 focus:border-red-500 focus:ring-red-500 text-sm shadow-sm transition-colors" 
                                           placeholder="Contoh: Budi (Meja 5)">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">Tipe Layanan</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="tipe_layanan" value="Dine-in" class="peer sr-only" checked>
                                        <div class="p-4 rounded-xl border-2 border-gray-100 bg-white peer-checked:border-[#D40000] peer-checked:bg-red-50 transition-all hover:border-red-200 h-full flex flex-col items-center justify-center gap-2 text-center">
                                            <i data-lucide="utensils" class="w-6 h-6 text-gray-400 peer-checked:text-[#D40000]"></i>
                                            <span class="text-sm font-bold text-gray-600 peer-checked:text-[#D40000]">Makan di Tempat</span>
                                        </div>
                                    </label>
                                    <label class="cursor-pointer relative">
                                        <input type="radio" name="tipe_layanan" value="Take Away" class="peer sr-only">
                                        <div class="p-4 rounded-xl border-2 border-gray-100 bg-white peer-checked:border-[#D40000] peer-checked:bg-red-50 transition-all hover:border-red-200 h-full flex flex-col items-center justify-center gap-2 text-center">
                                            <i data-lucide="shopping-bag" class="w-6 h-6 text-gray-400 peer-checked:text-[#D40000]"></i>
                                            <span class="text-sm font-bold text-gray-600 peer-checked:text-[#D40000]">Bungkus</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 rounded-b-2xl">
                            <button type="button" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-bold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors" onclick="document.getElementById('modalOffline').classList.add('hidden')">
                                Batal
                            </button>
                            <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center gap-2 rounded-xl border border-transparent bg-[#D40000] px-6 py-2.5 text-sm font-bold text-white shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all transform active:scale-95">
                                <i data-lucide="check-circle" class="w-4 h-4"></i>
                                Buat Pesanan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>