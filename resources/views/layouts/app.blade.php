<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Burjo Minang') }}</title>

    {{-- Script Tailwind dengan Konfigurasi Warna BURMIN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        burmin: {
                            red: '#D40000',    // Merah Minang
                            yellow: '#FFD700', // Kuning Emas
                            black: '#1a1a1a',  // Hitam Elegan
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    {{-- Menggunakan Font Inter agar lebih modern --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        [x-cloak] { display: none !important; }
        
        /* Custom Scrollbar untuk Admin Sidebar/Table */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-900 antialiased flex flex-col min-h-screen overflow-x-hidden" 
      x-data="{ sidebarOpen: false }">

    {{-- 
        NAVIGASI:
        Otomatis memilih navigasi berdasarkan Role
    --}}
    <div class="no-print relative z-50">
        @if(Auth::check() && Auth::user()->hasRole('admin'))
            @include('layouts.navigation-admin')
        @else
            @include('layouts.navigation')
        @endif
    </div>

    {{-- MAIN CONTENT --}}
    {{-- Padding top disesuaikan: Admin butuh pt-16 (tinggi topbar), User butuh pt-24 (tinggi nav user) --}}
    <main class="flex-grow transition-all duration-300 flex flex-col
        {{ Auth::check() && Auth::user()->hasRole('admin') ? 'pt-16 lg:pl-64 min-h-screen' : 'pt-24 pb-20' }}"> 
        
        {{-- 
            ===============================================================
            HEADER WRAPPER (LOGIKA KHUSUS)
            ===============================================================
            Jika Admin: Class kosong (transparan) agar menyatu dengan dashboard.
            Jika User:  Class 'bg-white shadow mb-6' agar terlihat standar.
        --}}
        @if (isset($header))
            <header class="{{ Auth::check() && Auth::user()->hasRole('admin') ? '' : 'bg-white shadow mb-6' }}">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        {{-- Slot Halaman Utama --}}
        <div class="flex-grow">
            {{ $slot }}
        </div>
        
        {{-- Footer Kecil Khusus Admin (Opsional, agar tidak kosong melompong di bawah) --}}
        @if(Auth::check() && Auth::user()->hasRole('admin'))
            <div class="mt-auto py-6 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Burjo Minang Admin Panel. All rights reserved.
            </div>
        @endif
    </main>
    
    {{-- 
        FOOTER BESAR:
        Hanya ditampilkan jika BUKAN admin.
        Admin biasanya tidak butuh footer besar di dashboard area.
    --}}
    @if(!Auth::check() || !Auth::user()->hasRole('admin'))
    <footer class="bg-burmin-black text-gray-400 py-10 mt-auto no-print border-t border-gray-800 transition-all duration-300">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-10">
                {{-- Brand --}}
                <div class="space-y-4">
                    <div class="bg-white p-2 rounded w-fit">
                         <img src="{{ asset('img/burmin_logo.jpg') }}" alt="Burmin Logo" class="h-12 w-auto object-contain">
                    </div>
                    <p class="text-sm leading-relaxed mt-4">
                        Cita rasa otentik Minang dalam setiap sajian warmindo.
                        <br><span class="block mt-2 text-gray-500">Jl. Bunga, Geblagan, Bantul, DIY</span>
                    </p>
                </div>

                {{-- Services --}}
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-b-2 border-burmin-red inline-block pb-1">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-burmin-red transition-colors">Dine-In</a></li>
                        <li><a href="#" class="hover:text-burmin-red transition-colors">Take Away</a></li>
                        <li><a href="#" class="hover:text-burmin-red transition-colors">Delivery</a></li>
                    </ul>
                </div>

                {{-- Info --}}
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-b-2 border-burmin-red inline-block pb-1">Informasi</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-burmin-red transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-burmin-red transition-colors">Hubungi Kami</a></li>
                        <li><a href="#" class="hover:text-burmin-red transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>

                {{-- Apps --}}
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-b-2 border-burmin-red inline-block pb-1">Download App</h4>
                    <div class="flex flex-col gap-3">
                        <a href="#" class="opacity-80 hover:opacity-100 transition-opacity w-36">
                            <img src="{{ asset('img/google-play.png') }}" alt="Google Play" class="w-full h-auto object-contain">
                        </a>
                        <a href="#" class="opacity-80 hover:opacity-100 transition-opacity w-36">
                            <img src="{{ asset('img/app-store.png') }}" alt="App Store" class="w-full h-auto object-contain">
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center text-sm">
                <p>&copy; {{ date('Y') }} Burjo Minang. All rights reserved.</p>
                <div class="flex gap-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition-colors"><i data-lucide="facebook" class="w-5 h-5"></i></a>
                    <a href="https://www.instagram.com/burjominang/" class="hover:text-white transition-colors"><i data-lucide="instagram" class="w-5 h-5"></i></a>
                    <a href="#" class="hover:text-white transition-colors"><i data-lucide="twitter" class="w-5 h-5"></i></a>
                </div>
            </div>
        </div>
    </footer>
    @endif

    <script>
        lucide.createIcons();
    </script>
    {{ $scripts ?? '' }}

</body>
</html>