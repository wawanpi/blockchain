<x-app-layout>
    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-6xl">
        
        {{-- Page Header --}}
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('cart.list') }}" class="p-2 rounded-full hover:bg-gray-100 transition text-gray-500 hover:text-[#E3002B]">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <h1 class="text-2xl lg:text-3xl font-black text-gray-900 uppercase tracking-wide">
                Konfirmasi <span class="text-[#E3002B]">Checkout</span>
            </h1>
        </div>

        <form action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">
                
                {{-- === KOLOM KIRI: FORMULIR INPUT === --}}
                <div class="w-full lg:w-7/12 space-y-8">
                    
                    {{-- 1. Pilih Tipe Layanan --}}
                    <section class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-[#E3002B] flex items-center justify-center text-xs">1</span>
                            Pilih Tipe Layanan
                        </h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input type="radio" name="tipe_layanan" id="tipe_take_away" value="Take Away" class="peer sr-only" {{ old('tipe_layanan', 'Take Away') == 'Take Away' ? 'checked' : '' }}>
                                <label for="tipe_take_away" class="block p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all hover:border-red-200 peer-checked:border-[#E3002B] peer-checked:bg-red-50 peer-checked:text-[#E3002B] h-full flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="shopping-bag" class="w-6 h-6 text-gray-500 peer-checked:text-[#E3002B]"></i>
                                    <span class="font-bold text-gray-700 peer-checked:text-[#E3002B]">Bungkus (Take Away)</span>
                                </label>
                            </div>
                            
                            <div class="relative">
                                <input type="radio" name="tipe_layanan" id="tipe_dine_in" value="Dine-in" class="peer sr-only" {{ old('tipe_layanan') == 'Dine-in' ? 'checked' : '' }}>
                                <label for="tipe_dine_in" class="block p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all hover:border-red-200 peer-checked:border-[#E3002B] peer-checked:bg-red-50 peer-checked:text-[#E3002B] h-full flex flex-col items-center justify-center gap-2">
                                    <i data-lucide="utensils" class="w-6 h-6 text-gray-500 peer-checked:text-[#E3002B]"></i>
                                    <span class="font-bold text-gray-700 peer-checked:text-[#E3002B]">Makan di Tempat</span>
                                </label>
                            </div>
                        </div>
                        @error('tipe_layanan') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror

                        {{-- Input Jumlah Tamu --}}
                        <div id="jumlah_tamu_wrapper" class="mt-4 animate-fade-in-down" style="display: {{ old('tipe_layanan') == 'Dine-in' ? 'block' : 'none' }};">
                            <label for="jumlah_tamu" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Orang</label>
                            <input type="number" name="jumlah_tamu" id="jumlah_tamu" value="{{ old('jumlah_tamu', '1') }}" min="1" 
                                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 transition-colors">
                            @error('jumlah_tamu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </section>

                    {{-- 2. Detail Tambahan --}}
                    <section class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-[#E3002B] flex items-center justify-center text-xs">2</span>
                            Catatan Pesanan
                        </h3>
                        <textarea name="catatan_pelanggan" id="catatan_pelanggan" rows="3" 
                            class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500 transition-colors placeholder-gray-400" 
                            placeholder="Contoh: Jangan pakai bawang goreng, pedas level 5...">{{ old('catatan_pelanggan') }}</textarea>
                        @error('catatan_pelanggan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </section>

                    {{-- 3. Pembayaran (REVISI UI) --}}
                    <section class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-red-100 text-[#E3002B] flex items-center justify-center text-xs">3</span>
                            Metode Pembayaran
                        </h3>

                        {{-- A. Pilihan Metode (Radio Button) --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            {{-- Opsi Transfer --}}
                            <div class="relative">
                                <input type="radio" name="metode_pembayaran" id="pilih_transfer" value="Transfer Bank" class="peer sr-only" {{ old('metode_pembayaran') == 'Transfer Bank' ? 'checked' : '' }}>
                                <label for="pilih_transfer" class="block p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all hover:border-blue-300 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-white p-2 rounded-full shadow-sm text-blue-600">
                                            <i data-lucide="landmark" class="w-5 h-5"></i>
                                        </div>
                                        <span class="font-bold text-gray-700 peer-checked:text-blue-800">Transfer Bank</span>
                                    </div>
                                </label>
                            </div>

                            {{-- Opsi QRIS --}}
                            <div class="relative">
                                <input type="radio" name="metode_pembayaran" id="pilih_qris" value="QRIS" class="peer sr-only" {{ old('metode_pembayaran') == 'QRIS' ? 'checked' : '' }}>
                                <label for="pilih_qris" class="block p-4 rounded-xl border-2 border-gray-200 cursor-pointer transition-all hover:border-blue-300 peer-checked:border-blue-600 peer-checked:bg-blue-50">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-white p-2 rounded-full shadow-sm text-blue-600">
                                            <i data-lucide="qr-code" class="w-5 h-5"></i>
                                        </div>
                                        <span class="font-bold text-gray-700 peer-checked:text-blue-800">QRIS (E-Wallet)</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('metode_pembayaran') <p class="text-red-500 text-xs mb-4">{{ $message }}</p> @enderror

                        {{-- B. Area Detail Informasi (Dinamis) --}}
                        <div class="bg-blue-50/50 border border-blue-100 rounded-xl p-5 mb-6 transition-all duration-300">
                            
                            {{-- Placeholder jika belum ada yang dipilih --}}
                            <div id="detail_placeholder" class="text-center text-gray-500 text-sm py-4">
                                <i data-lucide="arrow-up-circle" class="w-6 h-6 mx-auto mb-2 text-gray-400"></i>
                                Silakan pilih metode pembayaran di atas.
                            </div>

                            {{-- Detail Transfer Bank (Hidden by default) --}}
                            <div id="detail_transfer" class="hidden animate-fade-in-down">
                                <div class="flex items-start gap-3">
                                    <div class="bg-white p-2 rounded border border-gray-200 shrink-0">
                                        <i data-lucide="landmark" class="w-5 h-5 text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wide">Transfer Bank</p>
                                        <p class="text-lg font-black text-gray-900 tracking-tight">BCA 1234567890</p>
                                        <p class="text-xs text-gray-600">a.n Burmin Official</p>
                                        <p class="text-[10px] text-blue-600 mt-2 bg-blue-100 inline-block px-2 py-1 rounded">
                                            Silakan transfer sesuai total tagihan, lalu upload bukti di bawah.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- Detail QRIS (Hidden by default) --}}
                            <div id="detail_qris" class="hidden animate-fade-in-down">
                                <div class="text-center">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Scan QRIS</p>
                                    <div class="group relative inline-block cursor-pointer bg-white p-2 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-all" onclick="openModal('qrisModal')">
                                        <img src="{{ asset('menu-images/qris.jpg') }}" alt="QRIS Code" class="w-32 h-auto rounded opacity-90 group-hover:opacity-100 transition-opacity mx-auto">
                                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-200 bg-black/10 rounded-xl backdrop-blur-[1px]">
                                            <i data-lucide="zoom-in" class="w-6 h-6 text-white drop-shadow-md"></i>
                                        </div>
                                    </div>
                                    <p class="text-[10px] text-blue-600 mt-2 italic">Klik QRIS untuk memperbesar</p>
                                    <p class="text-[10px] text-gray-500 mt-1">Support: GoPay, OVO, Dana, M-Banking</p>
                                </div>
                            </div>
                        </div>

                        {{-- C. Upload Bukti (Dropzone Style) - Tetap Ada --}}
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Bukti Transfer <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:bg-gray-50 hover:border-red-300 transition-colors cursor-pointer relative">
                                <div class="space-y-1 text-center">
                                    <i data-lucide="upload-cloud" class="mx-auto h-10 w-10 text-gray-400"></i>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="bukti_bayar" class="relative cursor-pointer bg-white rounded-md font-medium text-red-600 hover:text-red-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-red-500">
                                            <span>Upload file</span>
                                            <input id="bukti_bayar" name="bukti_bayar" type="file" class="sr-only" accept="image/*" required>
                                        </label>
                                        <p class="pl-1">atau drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                                </div>
                            </div>
                            @error('bukti_bayar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </section>
                </div>

                {{-- === KOLOM KANAN: RINGKASAN PESANAN (STICKY) === --}}
                <div class="w-full lg:w-5/12 lg:sticky lg:top-24">
                    <div class="bg-gray-50 p-6 rounded-3xl shadow-inner border border-gray-200">
                        <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
                            <i data-lucide="receipt" class="w-5 h-5 text-gray-400"></i>
                            Ringkasan Pesanan
                        </h3>
                        
                        <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            @foreach ($cartItems as $item)
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 shrink-0 bg-white rounded-lg overflow-hidden border border-gray-100">
                                        <img src="{{ $item->attributes->image ? asset($item->attributes->image) : 'https://placehold.co/64x64/e2e8f0/e2e8f0?text=IMG' }}" 
                                             class="w-full h-full object-cover" 
                                             alt="{{ $item->name }}">
                                    </div>
                                    <div class="flex-grow">
                                        <div class="flex justify-between items-start">
                                            <p class="font-bold text-gray-800 text-sm line-clamp-2">{{ $item->name }}</p>
                                            <p class="font-bold text-gray-900 text-sm ml-2">Rp {{ number_format($item->getPriceSum(), 0, ',', '.') }}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-t border-dashed border-gray-300 my-6"></div>

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-gray-600 font-medium">Total Bayar</span>
                            <span class="text-2xl font-black text-[#E3002B]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="w-full py-4 bg-[#E3002B] hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                            <span>Buat Pesanan Sekarang</span>
                            <i data-lucide="check-circle" class="w-5 h-5"></i>
                        </button>
                        
                        <p class="text-[10px] text-center text-gray-400 mt-4">
                            Dengan memesan, Anda menyetujui S&K yang berlaku.
                        </p>
                    </div>
                </div>

            </div>
        </form>
    </div>

    {{-- MODAL QRIS FULL SIZE --}}
    <div id="qrisModal" class="fixed inset-0 z-50 hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity" onclick="closeModal('qrisModal')"></div>
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:w-full sm:max-w-sm">
                    <div class="bg-white p-6">
                        <div class="text-center">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Scan QRIS</h3>
                            <div class="bg-gray-50 p-2 rounded-xl inline-block border border-gray-100">
                                <img src="{{ asset('menu-images/qris.jpg') }}" alt="QRIS Full" class="w-full h-auto rounded-lg">
                            </div>
                            <p class="text-sm text-gray-500 mt-4">Scan menggunakan GoPay, OVO, Dana, atau Mobile Banking.</p>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6">
                        <button type="button" class="w-full justify-center rounded-xl bg-gray-900 px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-black transition" onclick="closeModal('qrisModal')">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Script JavaScript --}}
    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
            document.body.style.overflow = 'auto'; 
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Logic Dine-In vs Take-Away
            const radioDineIn = document.getElementById('tipe_dine_in');
            const radioTakeAway = document.getElementById('tipe_take_away');
            const jumlahTamuWrapper = document.getElementById('jumlah_tamu_wrapper');

            function toggleJumlahTamu() {
                if (radioDineIn.checked) {
                    jumlahTamuWrapper.style.display = 'block';
                    jumlahTamuWrapper.classList.remove('hidden');
                } else {
                    jumlahTamuWrapper.style.display = 'none';
                    jumlahTamuWrapper.classList.add('hidden');
                }
            }

            if(radioDineIn && radioTakeAway){
                toggleJumlahTamu(); 
                radioDineIn.addEventListener('change', toggleJumlahTamu);
                radioTakeAway.addEventListener('change', toggleJumlahTamu);
            }

            // --- LOGIC METODE PEMBAYARAN (Baru) ---
            const radioTransfer = document.getElementById('pilih_transfer');
            const radioQRIS = document.getElementById('pilih_qris');
            
            const detailPlaceholder = document.getElementById('detail_placeholder');
            const detailTransfer = document.getElementById('detail_transfer');
            const detailQRIS = document.getElementById('detail_qris');

            function toggleMetodePembayaran() {
                // Sembunyikan semua dulu
                detailPlaceholder.classList.add('hidden');
                detailTransfer.classList.add('hidden');
                detailQRIS.classList.add('hidden');

                if (radioTransfer.checked) {
                    detailTransfer.classList.remove('hidden');
                } else if (radioQRIS.checked) {
                    detailQRIS.classList.remove('hidden');
                } else {
                    // Jika belum ada yang dipilih (saat load pertama kali dan tidak ada old input)
                    detailPlaceholder.classList.remove('hidden');
                }
            }

            if(radioTransfer && radioQRIS) {
                // Jalankan saat load (untuk handle old input validation error)
                toggleMetodePembayaran();

                // Listener change
                radioTransfer.addEventListener('change', toggleMetodePembayaran);
                radioQRIS.addEventListener('change', toggleMetodePembayaran);
            }
        });
    </script>
</x-app-layout>