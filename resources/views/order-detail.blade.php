<x-app-layout>
    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-3xl">
        {{-- Page Header --}}
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('orders.index') }}" class="p-2 rounded-full hover:bg-gray-100 transition text-gray-500 hover:text-[#E3002B] group">
                <i data-lucide="arrow-left" class="w-6 h-6 group-hover:-translate-x-1 transition-transform"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-gray-900 uppercase tracking-wide">
                    Detail <span class="text-[#E3002B]">Pesanan</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">ID: #{{ $pesanan->id }}</p>
            </div>
        </div>

        <div class="space-y-6">
            {{-- CARD 1: STATUS & INFO UTAMA --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden relative">
                {{-- Decorative Top Bar --}}
                <div class="h-2 w-full bg-[#E3002B]"></div>
                
                <div class="p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        {{-- Status Badge --}}
                        @php
                            $statusStyles = [
                                'pending' => ['bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'border' => 'border-yellow-200', 'icon' => 'clock'],
                                'processing' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'icon' => 'loader'],
                                'completed' => ['bg' => 'bg-green-50', 'text' => 'text-green-700', 'border' => 'border-green-200', 'icon' => 'check-circle'],
                                'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-700', 'border' => 'border-red-200', 'icon' => 'x-circle'],
                            ];
                            $style = $statusStyles[$pesanan->status] ?? $statusStyles['pending'];
                        @endphp
                        
                        <div class="flex items-center gap-2 px-4 py-2 rounded-full border {{ $style['bg'] }} {{ $style['border'] }}">
                            <i data-lucide="{{ $style['icon'] }}" class="w-4 h-4 {{ $style['text'] }}"></i>
                            <span class="font-bold text-sm uppercase tracking-wide {{ $style['text'] }}">{{ ucfirst($pesanan->status) }}</span>
                        </div>

                        {{-- Tanggal --}}
                        <div class="text-right">
                            <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Tanggal Pemesanan</p>
                            <p class="font-medium text-gray-900">{{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>

                    {{-- Total Amount Large --}}
                    <div class="text-center py-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200 mb-6">
                        <p class="text-sm text-gray-500 font-medium mb-1">Total Pembayaran</p>
                        <p class="text-4xl font-black text-[#E3002B]">Rp {{ number_format($pesanan->total_bayar, 0, ',', '.') }}</p>
                    </div>

                    {{-- Customer Note --}}
                    @if($pesanan->catatan_pelanggan)
                        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex gap-3 items-start">
                            <i data-lucide="message-square-quote" class="w-5 h-5 text-blue-500 mt-0.5 shrink-0"></i>
                            <div>
                                <p class="text-xs font-bold text-blue-800 uppercase mb-1">Catatan Pesanan:</p>
                                <p class="text-sm text-blue-900 italic">"{{ $pesanan->catatan_pelanggan }}"</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- CARD 2: ITEM LIST --}}
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-50">
                    <h3 class="font-bold text-lg text-gray-800 flex items-center gap-2">
                        <i data-lucide="shopping-bag" class="w-5 h-5 text-gray-400"></i>
                        Rincian Menu
                    </h3>
                </div>
                
                <div class="divide-y divide-gray-50">
                    @foreach($pesanan->details as $item)
                        <div class="p-4 sm:p-6 flex gap-4 hover:bg-gray-50 transition-colors">
                            {{-- Image --}}
                            <div class="w-16 h-16 sm:w-20 sm:h-20 shrink-0 bg-gray-100 rounded-xl overflow-hidden shadow-sm">
                                <img src="{{ asset($item->menu->gambar) }}" alt="{{ $item->menu->namaMenu }}" class="w-full h-full object-cover">
                            </div>

                            {{-- Info --}}
                            <div class="flex-grow flex flex-col justify-center">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="font-bold text-gray-900 text-base sm:text-lg line-clamp-1">{{ $item->menu->namaMenu }}</h4>
                                    <p class="font-bold text-gray-900 whitespace-nowrap ml-2">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                <div class="flex items-center text-sm text-gray-500">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-bold text-gray-600 mr-2">x{{ $item->jumlah }}</span>
                                    <span>@ Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Action Footer --}}
                <div class="p-6 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                    <p class="text-xs text-gray-400">Butuh bantuan dengan pesanan ini?</p>
                    <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20butuh%20bantuan%20soal%20pesanan%20%23{{ $pesanan->id }}" target="_blank" class="text-sm font-bold text-[#E3002B] hover:underline flex items-center gap-1">
                        <i data-lucide="help-circle" class="w-4 h-4"></i> Hubungi Admin
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>