<x-app-layout>
    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-5xl">
        {{-- Page Header --}}
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('dashboard') }}" class="p-2 rounded-full hover:bg-gray-100 transition text-gray-500 hover:text-[#E3002B]">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-2xl lg:text-3xl font-black text-gray-900 uppercase tracking-wide">
                Keranjang <span class="text-[#E3002B]">Saya</span>
            </h1>
        </div>

        {{-- Alerts --}}
        @if ($message = Session::get('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm mb-6 flex items-center gap-3 animate-fade-in-down" role="alert">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span>{{ $message }}</span>
            </div>
        @endif
        @if ($message = Session::get('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm mb-6 flex items-center gap-3 animate-fade-in-down" role="alert">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span>{{ $message }}</span>
            </div>
        @endif

        @if(!Cart::isEmpty())
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                {{-- LEFT COLUMN: CART ITEMS --}}
                <div class="w-full lg:w-2/3 space-y-4">
                    @foreach ($cartItems as $item)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex gap-4 items-center transition hover:shadow-md">
                            {{-- Image --}}
                            <div class="w-20 h-20 sm:w-24 sm:h-24 shrink-0 bg-gray-50 rounded-xl overflow-hidden relative">
                                @if($item->attributes->image)
                                    <img src="{{ asset($item->attributes->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">No Img</div>
                                @endif
                            </div>

                            {{-- Details --}}
                            <div class="flex-grow flex flex-col justify-between self-stretch py-1">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-bold text-gray-900 text-lg leading-tight line-clamp-1">{{ $item->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">@ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                    
                                    {{-- Delete Button --}}
                                    <form action="{{ route('cart.remove') }}" method="POST">
                                        @csrf
                                        <input type="hidden" value="{{ $item->id }}" name="id">
                                        <button class="text-gray-400 hover:text-red-500 p-1.5 hover:bg-red-50 rounded-full transition-colors" title="Hapus Item">
                                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                                        </button>
                                    </form>
                                </div>

                                {{-- Action Row: Qty Stepper & Subtotal --}}
                                <div class="flex justify-between items-end mt-3">
                                    
                                    {{-- Qty Stepper (Auto Update) --}}
                                    <form action="{{ route('cart.update') }}" method="POST" class="flex items-center" x-data>
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $item->id }}">
                                        
                                        <div class="flex items-center border border-gray-200 rounded-full px-2 py-1 bg-gray-50">
                                            {{-- Tombol Kurang (-) --}}
                                            {{-- Logika: Set quantity value ke current - 1, lalu submit form --}}
                                            <button type="submit" 
                                                    name="quantity" 
                                                    value="{{ $item->quantity - 1 }}" 
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-white text-gray-600 shadow-sm hover:text-[#E3002B] disabled:opacity-50 transition"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <i data-lucide="minus" class="w-3 h-3"></i>
                                            </button>

                                            {{-- Display Angka (Read Only agar user pake tombol) --}}
                                            <span class="w-10 text-center font-bold text-gray-900 text-sm select-none">{{ $item->quantity }}</span>

                                            {{-- Tombol Tambah (+) --}}
                                            {{-- Logika: Set quantity value ke current + 1, lalu submit form --}}
                                            <button type="submit" 
                                                    name="quantity" 
                                                    value="{{ $item->quantity + 1 }}" 
                                                    class="w-7 h-7 flex items-center justify-center rounded-full bg-[#E3002B] text-white shadow-sm hover:bg-red-700 transition">
                                                <i data-lucide="plus" class="w-3 h-3"></i>
                                            </button>
                                        </div>
                                    </form>

                                    {{-- Subtotal --}}
                                    <div class="text-right">
                                        <p class="text-[10px] text-gray-400 uppercase font-bold tracking-wider">Subtotal</p>
                                        <p class="font-black text-lg text-[#E3002B]">
                                            Rp {{ number_format($item->getPriceSum(), 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Clear Cart --}}
                    <div class="text-right mt-6">
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin mengosongkan keranjang?');">
                            @csrf
                            <button class="text-xs text-red-500 hover:text-red-700 font-bold flex items-center gap-1 ml-auto transition hover:bg-red-50 px-3 py-2 rounded-lg">
                                <i data-lucide="trash" class="w-3 h-3"></i>
                                Kosongkan Keranjang
                            </button>
                        </form>
                    </div>
                </div>

                {{-- RIGHT COLUMN: SUMMARY (Sticky on Desktop) --}}
                <div class="w-full lg:w-1/3 lg:sticky lg:top-24">
                    <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-100">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="bg-yellow-100 p-2 rounded-full text-yellow-600">
                                <i data-lucide="receipt" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-black text-xl text-gray-900">Ringkasan Pesanan</h3>
                        </div>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Total Item</span>
                                <span class="font-bold">{{ Cart::getTotalQuantity() }} item</span>
                            </div>
                            <div class="flex justify-between text-sm text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-bold">Rp {{ number_format(Cart::getTotal(), 0, ',', '.') }}</span>
                            </div>
                            {{-- Space untuk Pajak/Ongkir jika nanti ada --}}
                            
                            <div class="border-t border-dashed border-gray-200 my-2 pt-2"></div>
                            
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 text-lg">Total Bayar</span>
                                <span class="font-black text-2xl text-[#E3002B]">Rp {{ number_format(Cart::getTotal(), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="w-full flex items-center justify-center gap-2 py-4 bg-[#E3002B] hover:bg-red-700 text-white text-center font-bold text-lg rounded-xl shadow-lg shadow-red-200 transition-all transform hover:-translate-y-1 active:scale-95">
                            <span>Lanjut Checkout</span>
                            <i data-lucide="arrow-right" class="w-5 h-5"></i>
                        </a>
                        
                        <div class="mt-4 flex items-start gap-2 bg-blue-50 p-3 rounded-lg text-blue-700 text-xs">
                            <i data-lucide="info" class="w-4 h-4 mt-0.5 shrink-0"></i>
                            <p>Pastikan pesanan Anda sudah benar sebelum lanjut ke pembayaran.</p>
                        </div>
                    </div>
                </div>

            </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center justify-center py-20 text-center animate-fade-in-up">
                <div class="w-48 h-48 bg-red-50 rounded-full flex items-center justify-center mb-6 animate-bounce-slow">
                    <i data-lucide="shopping-cart" class="w-20 h-20 text-red-200"></i>
                </div>
                <h3 class="text-3xl font-black text-gray-900 mb-2">Keranjang Masih Kosong</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto leading-relaxed">
                    Perut lapar tapi keranjang kosong? Yuk, isi dengan menu favoritmu dari Burjo Minang sekarang! 🍜
                </p>
                <a href="{{ route('dashboard') }}" class="px-10 py-4 bg-[#E3002B] text-white font-bold rounded-full shadow-xl hover:bg-red-700 hover:shadow-red-200 transition-all transform hover:-translate-y-1 flex items-center gap-2">
                    <i data-lucide="utensils" class="w-5 h-5"></i>
                    Mulai Pesan
                </a>
            </div>
        @endif
    </div>
</x-app-layout>