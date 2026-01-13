<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tentang Kami - BURJO MINANG</title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- Alpine --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        'minang-red': '#C70024',
                        'minang-gold': '#FBB03B',
                        'minang-dark': '#1A1A1A',
                    },
                    boxShadow: {
                        'glow': '0 0 20px rgba(199,0,36,.3)'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white text-gray-800 antialiased"
      x-data="{ mobileMenuOpen: false, scrolled: false }"
      @scroll.window="scrolled = (window.pageYOffset > 20)">

<!-- ================= HEADER (SAMA DENGAN WELCOME) ================= -->
<header :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md py-2' : 'bg-transparent py-4'"
        class="fixed top-0 w-full z-50 transition-all duration-300">
    <nav class="container mx-auto px-4 lg:px-8 flex justify-between items-center">
        
        {{-- Logo --}}
        <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
            <div class="relative overflow-hidden rounded-full w-12 h-12 border-2 border-minang-red/20 bg-white">
                <img src="{{ asset('menu-images/Burmin_logo.jpg') }}" class="w-full h-full object-cover">
            </div>
            <span :class="scrolled ? 'text-gray-800' : 'text-white'"
                  class="font-extrabold text-xl tracking-tight hidden sm:block">
                BURJO <span class="text-minang-red">MINANG</span>
            </span>
        </a>

        {{-- Desktop Menu --}}
        <div class="hidden lg:flex items-center space-x-8">
            <a href="{{ route('welcome') }}"
               :class="scrolled ? 'text-gray-600 hover:text-minang-red' : 'text-white hover:text-minang-gold'"
               class="font-semibold text-sm uppercase tracking-wider transition">
                Home
            </a>

            <a href="{{ route('welcome') }}#menu"
               :class="scrolled ? 'text-gray-600 hover:text-minang-red' : 'text-white hover:text-minang-gold'"
               class="font-semibold text-sm uppercase tracking-wider transition">
                Menu
            </a>

            <a href="{{ route('about') }}"
               :class="scrolled ? 'text-minang-red' : 'text-minang-gold'"
               class="font-semibold text-sm uppercase tracking-wider transition">
                About
            </a>
        </div>

        {{-- Auth --}}
        <div class="hidden lg:flex items-center gap-3">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-6 py-2.5 bg-minang-red text-white rounded-full font-bold text-sm shadow-glow">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   :class="scrolled ? 'text-gray-700 hover:text-minang-red' : 'text-white hover:text-minang-gold'"
                   class="font-bold text-sm transition mr-2">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                   class="px-6 py-2.5 bg-minang-red text-white rounded-full font-bold text-sm shadow-glow">
                    Sign Up
                </a>
            @endauth
        </div>

        {{-- Mobile --}}
        <button @click="mobileMenuOpen = !mobileMenuOpen"
                :class="scrolled ? 'text-gray-800' : 'text-white'"
                class="lg:hidden">
            <i class="fas fa-bars text-2xl"></i>
        </button>
    </nav>
</header>

<!-- ================= HERO ================= -->
<section class="relative w-full h-[50vh] bg-minang-red overflow-hidden pt-24">
    <div class="absolute inset-0 bg-gradient-to-br from-[#b30000] to-[#660000]"></div>
    <div class="absolute inset-0 bg-black/30"></div>

    <div class="relative h-full flex items-center justify-center text-center text-white z-10">
        <div>
            <h1 class="text-5xl md:text-6xl font-extrabold mb-4">Tentang Kami</h1>
            <p class="text-xl md:text-2xl font-semibold text-minang-gold">
                Jagonya Rasa Original
            </p>
        </div>
    </div>
</section>

<!-- ================= CONTENT ================= -->
{{-- About Section --}}
<section class="py-16 bg-white relative overflow-hidden">
    {{-- Decorative Elements --}}
    <div class="absolute top-0 right-0 w-64 h-64 bg-red-100 rounded-full opacity-30 -mr-32 -mt-32"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-yellow-50 rounded-full opacity-50 -ml-48 -mb-48"></div>
    
    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <div class="text-center mb-12">
            <h2 class="text-4xl md:text-5xl font-extrabold text-gray-800 mb-3">Tentang Kami</h2>
            <p class="text-gray-600 text-lg">Kenali lebih dekat Burjo Minang</p>
            <div class="w-24 h-1 bg-gradient-to-r from-red-600 via-yellow-500 to-red-600 mx-auto mt-4"></div>
        </div>

        <div class="grid lg:grid-cols-2 gap-12 items-center max-w-6xl mx-auto">
            
            {{-- Left: Image Gallery --}}
            <div class="relative">
                <div class="grid grid-cols-2 gap-4">
                    {{-- Main Image --}}
                    <div class="col-span-2">
                        <div class="relative overflow-hidden rounded-3xl shadow-2xl transform hover:scale-105 transition-all duration-500">
                            <img src="{{ asset('menu-images/ikanbakar.jpg') }}" 
                                 alt="Burjo Minang Restaurant" 
                                 class="w-full h-72 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <p class="text-2xl font-bold">Sejak 2018</p>
                                <p class="text-sm">Melayani dengan Sepenuh Hati</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Small Images --}}
                    <div class="overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('menu-images/ikanbakar.jpg') }}" 
                             alt="Menu Special" 
                             class="w-full h-48 object-cover">
                    </div>
                    <div class="overflow-hidden rounded-2xl shadow-xl transform hover:scale-105 transition-all duration-300">
                        <img src="{{ asset('menu-images/ikanbakar.jpg') }}" 
                             alt="Suasana Restoran" 
                             class="w-full h-48 object-cover">
                    </div>
                </div>

                {{-- Floating Badge --}}
                <div class="absolute -top-6 -right-6 bg-gradient-to-br from-red-600 to-yellow-500 text-white rounded-full w-32 h-32 flex flex-col items-center justify-center shadow-2xl animate-pulse">
                    <div class="text-3xl font-bold">4.8</div>
                    <div class="text-xs">⭐⭐⭐⭐⭐</div>
                    <div class="text-xs mt-1">Rating</div>
                </div>
            </div>

            {{-- Right: Content --}}
            <div class="space-y-6">
                <div>
                
                    <p class="text-2xl font-bold text-red-600 mb-4">Jagonya Rasa Original</p>
                </div>

                <p class="text-gray-600 leading-relaxed text-justify">
                    <strong class="text-gray-800">Burjo Minang</strong> adalah restoran yang menghadirkan cita rasa autentik masakan Minang dengan sentuhan modern. Berdiri sejak tahun 2018, kami berkomitmen untuk menyajikan hidangan berkualitas tinggi dengan bahan-bahan pilihan yang fresh dan halal.
                </p>

                <p class="text-gray-600 leading-relaxed text-justify">
                    Dengan sistem <strong class="text-red-600">booking online</strong> yang mudah, Anda dapat memesan makanan favorit dan mengambilnya langsung di tempat tanpa perlu antri. Kami percaya bahwa makanan lezat harus mudah diakses oleh semua orang.
                </p>

                {{-- Features Grid --}}
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-xl border-2 border-red-200 hover:shadow-lg transition">
                        <div class="text-3xl mb-2">💰</div>
<h4 class="font-bold text-gray-800 mb-1">Harga Terjangkau</h4>
<p class="text-xs text-gray-600">Kualitas premium harga bersahabat</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-4 rounded-xl border-2 border-yellow-200 hover:shadow-lg transition">
                        <div class="text-3xl mb-2">🥘</div>
                        <h4 class="font-bold text-gray-800 mb-1">Menu Variatif</h4>
                        <p class="text-xs text-gray-600">30+ pilihan menu lezat</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border-2 border-green-200 hover:shadow-lg transition">
                        <div class="text-3xl mb-2">✅</div>
                        <h4 class="font-bold text-gray-800 mb-1">Halal & Higienis</h4>
                        <p class="text-xs text-gray-600">Jaminan kebersihan terjaga</p>
                    </div>
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border-2 border-blue-200 hover:shadow-lg transition">
                        <div class="text-3xl mb-2">⚡</div>
                        <h4 class="font-bold text-gray-800 mb-1">Layanan Cepat</h4>
                        <p class="text-xs text-gray-600">Booking & ambil dalam 15 menit</p>
                    </div>
                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-3 gap-4 pt-6 border-t-2 border-gray-200">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600">1000+</div>
                        <p class="text-sm text-gray-600 font-medium">Pelanggan Setia</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-500">30+</div>
                        <p class="text-sm text-gray-600 font-medium">Menu Pilihan</p>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">4.8</div>
                        <p class="text-sm text-gray-600 font-medium">Rating ⭐</p>
                    </div>
                </div>

                {{-- CTA Button --}}
                <div class="pt-4">
                
                </div>
            </div>

        </div>
  {{-- Vision & Mission --}}
        <div class="grid md:grid-cols-2 gap-8 mt-16 max-w-5xl mx-auto">
            <div class="bg-gradient-to-br from-red-600 to-red-700 text-white p-8 rounded-3xl shadow-2xl transform hover:scale-105 transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-eye text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold">Visi Kami</h4>
                </div>
                <p class="leading-relaxed">
                    Menjadi restoran pilihan utama yang menghadirkan cita rasa autentik Minang dengan pelayanan modern dan inovatif, serta memberikan pengalaman kuliner terbaik bagi setiap pelanggan.
                </p>
            </div>

            <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-8 rounded-3xl shadow-2xl transform hover:scale-105 transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-bullseye text-2xl"></i>
                    </div>
                    <h4 class="text-2xl font-bold">Misi Kami</h4>
                </div>
                <ul class="space-y-2 leading-relaxed">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>Menyajikan makanan berkualitas tinggi dengan harga terjangkau</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>Memberikan pelayanan terbaik dan ramah kepada pelanggan</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle mt-1"></i>
                        <span>Menggunakan bahan-bahan fresh dan halal</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
</section>
 {{-- Footer --}}
    <footer class="bg-minang-dark text-gray-400 py-16 relative overflow-hidden mt-12 rounded-t-[3rem]">
        {{-- FIX: Menghapus elemen dekorasi merah footer sesuai permintaan --}}
        
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="space-y-4">
                    <h3 class="text-white font-extrabold text-2xl tracking-tight flex items-center gap-2">
                         <span class="bg-white text-minang-dark px-2 rounded">BURJO</span> <span class="text-minang-red">MINANG</span>
                    </h3>
                    <p class="text-sm leading-relaxed text-gray-500">Menghadirkan cita rasa masakan Padang otentik dengan sentuhan modern dan higienis.</p>
                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-minang-red hover:text-white transition-all hover:-translate-y-1"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all hover:-translate-y-1"><i class="fab fa-facebook-f"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm border-b border-gray-800 pb-2 inline-block">Hubungi Kami</h4>
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-center gap-3"><i class="fas fa-phone-alt text-minang-red"></i><span class="font-mono text-white">14022</span></li>
                        <li class="flex items-center gap-3"><i class="fas fa-envelope text-minang-red"></i><span>hello@burjominang.com</span></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm border-b border-gray-800 pb-2 inline-block">Jam Operasional</h4>
                    <ul class="space-y-3 text-sm">
                        <li class="flex justify-between border-b border-gray-800 pb-2"><span>Senin - Jumat</span><span class="text-white font-mono">08:00 - 20:00</span></li>
                        <li class="flex justify-between border-b border-gray-800 pb-2"><span>Sabtu - Minggu</span><span class="text-white font-mono">10:00 - 22:00</span></li>
                    </ul>
                </div>
                 <div>
                    <h4 class="text-white font-bold mb-6 uppercase tracking-wider text-sm border-b border-gray-800 pb-2 inline-block">Lokasi</h4>
                     <p class="text-sm">Jl. Bunga, Geblagan, Tamantirto, Kec. Kasihan, Kabupaten Bantul, DIY</p>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-16 pt-8 text-center text-xs text-gray-600">
                <p>&copy; {{ date('Y') }} Burjo Minang. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>