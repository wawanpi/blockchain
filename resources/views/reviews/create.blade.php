<x-app-layout>
    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-3xl">
        {{-- Page Header --}}
        <div class="text-center mb-10">
            <h1 class="text-3xl font-black text-gray-900 uppercase tracking-wide mb-2">
                Beri <span class="text-[#E3002B]">Ulasan</span>
            </h1>
            <p class="text-gray-500">Bagaimana pengalaman makanmu? Ceritakan kepada kami!</p>
            <div class="mt-2 inline-block bg-gray-100 px-3 py-1 rounded-full text-xs font-bold text-gray-600">
                Order #{{ $pesanan->id }}
            </div>
        </div>

        {{-- Error Alert Global --}}
        @if ($errors->any())
            <div class="mb-8 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm flex items-start gap-3 animate-fade-in-down">
                <i data-lucide="alert-circle" class="w-5 h-5 mt-0.5 shrink-0"></i>
                <div>
                    <strong class="font-bold block mb-1">Ups! Ada yang belum lengkap.</strong>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('reviews.store', $pesanan->id) }}" method="POST">
            @csrf

            <div class="space-y-6">
                @foreach ($pesanan->details as $index => $detail)
                    {{-- REVIEW CARD --}}
                    <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300"
                         x-data="{ 
                            rating: {{ old('reviews.' . $detail->menu_id . '.rating', 0) }},
                            hoverRating: 0
                         }">
                        
                        <div class="flex flex-col sm:flex-row gap-6">
                            {{-- Image --}}
                            <div class="shrink-0 flex justify-center sm:justify-start">
                                <img src="{{ asset($detail->menu->gambar) }}" 
                                     alt="{{ $detail->menu->namaMenu }}" 
                                     class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-xl shadow-sm border border-gray-100">
                            </div>

                            {{-- Content --}}
                            <div class="flex-grow w-full">
                                <div class="mb-4 text-center sm:text-left">
                                    <h3 class="text-xl font-bold text-gray-900 leading-tight">{{ $detail->menu->namaMenu }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $detail->jumlah }} porsi • {{ $detail->menu->kategori }}</p>
                                </div>

                                {{-- Star Rating Input --}}
                                <div class="mb-6 flex flex-col items-center sm:items-start">
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Rating Kamu</label>
                                    <div class="flex items-center gap-1" @mouseleave="hoverRating = 0">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <button type="button" 
                                                    @click="rating = {{ $i }}" 
                                                    @mouseenter="hoverRating = {{ $i }}"
                                                    class="focus:outline-none transition-transform active:scale-90"
                                                    title="Beri {{ $i }} Bintang">
                                                <i data-lucide="star" 
                                                   class="w-8 h-8 sm:w-9 sm:h-9 transition-colors duration-200"
                                                   :class="(hoverRating >= {{ $i }} || (hoverRating === 0 && rating >= {{ $i }})) 
                                                        ? 'fill-yellow-400 text-yellow-400 drop-shadow-sm' 
                                                        : 'text-gray-200 fill-gray-100'">
                                                </i>
                                            </button>
                                        @endfor
                                    </div>
                                    <input type="hidden" name="reviews[{{ $detail->menu_id }}][menu_id]" value="{{ $detail->menu_id }}">
                                    <input type="hidden" name="reviews[{{ $detail->menu_id }}][rating]" :value="rating">
                                    
                                    <div x-show="rating > 0" class="mt-2 text-sm font-medium text-yellow-600 animate-fade-in">
                                        <span x-text="rating === 5 ? 'Sempurna! 😍' : (rating >= 4 ? 'Suka banget! 😄' : (rating >= 3 ? 'Lumayan 🙂' : 'Kurang 😔'))"></span>
                                    </div>

                                    @error('reviews.' . $detail->menu_id . '.rating')
                                        <p class="text-red-500 text-xs mt-2 flex items-center gap-1 font-bold">
                                            <i data-lucide="alert-circle" class="w-3 h-3"></i> Wajib diisi
                                        </p>
                                    @enderror
                                </div>

                                {{-- Comment Input --}}
                                <div>
                                    <label for="komentar_{{ $detail->menu_id }}" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Komentar (Opsional)</label>
                                    <textarea id="komentar_{{ $detail->menu_id }}" 
                                              name="reviews[{{ $detail->menu_id }}][komentar]" 
                                              rows="3" 
                                              class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50 text-sm placeholder-gray-400 transition-all resize-none"
                                              placeholder="Ceritakan rasanya, porsinya, atau sarannya...">{{ old('reviews.' . $detail->menu_id . '.komentar') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Sticky/Floating Action Footer --}}
            <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)] z-40 sm:static sm:bg-transparent sm:border-0 sm:shadow-none sm:p-0 sm:mt-10">
                <div class="container mx-auto max-w-3xl flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('orders.index') }}" class="text-gray-500 hover:text-gray-900 font-medium text-sm hidden sm:block transition">
                        Batal, kembali ke Riwayat
                    </a>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-[#E3002B] hover:bg-red-700 text-white font-bold rounded-full shadow-lg shadow-red-200 transition-all transform active:scale-95 flex items-center justify-center gap-2">
                        <span>Kirim Semua Ulasan</span>
                        <i data-lucide="send" class="w-4 h-4"></i>
                    </button>
                </div>
            </div>
            
            {{-- Spacer untuk mobile agar tidak tertutup sticky footer --}}
            <div class="h-24 sm:hidden"></div>

        </form>
    </div>
</x-app-layout>