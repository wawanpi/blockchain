<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BURJO MINANG - Cita Rasa Otentik</title>

    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    
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
                        'soft': '0 10px 40px -10px rgba(0,0,0,0.08)',
                        'glow': '0 0 20px rgba(199, 0, 36, 0.3)',
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #C70024; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #a3001e; }
        
        /* Pattern Overlay */
        .bg-pattern {
            background-image: radial-gradient(#C70024 0.5px, transparent 0.5px), radial-gradient(#C70024 0.5px, #fff 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased relative selection:bg-minang-red selection:text-white" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    
    <header :class="scrolled ? 'bg-white/95 backdrop-blur-md shadow-md py-2' : 'bg-transparent py-4'" class="fixed top-0 w-full z-50 transition-all duration-300">
        <nav class="container mx-auto px-4 lg:px-8 flex justify-between items-center">
            
            <a href="<?php echo e(route('welcome')); ?>" class="flex items-center gap-2 group">
                <div class="relative overflow-hidden rounded-full w-12 h-12 border-2 border-minang-red/20 group-hover:border-minang-red transition-colors bg-white">
                    <img src="<?php echo e(asset('menu-images/Burmin_logo.jpg')); ?>" alt="Logo" class="w-full h-full object-cover">
                </div>
                <span :class="scrolled ? 'text-gray-800' : 'text-white lg:text-white'" class="font-extrabold text-xl tracking-tight hidden sm:block text-shadow-sm">
                    BURJO <span class="text-minang-red">MINANG</span>
                </span>
            </a>

            
            <div class="hidden lg:flex items-center space-x-8">
                
                <a href="<?php echo e(route('welcome')); ?>" :class="scrolled ? 'text-gray-600 hover:text-minang-red' : 'text-white hover:text-minang-gold'" class="font-semibold text-sm uppercase tracking-wider transition-colors shadow-sm">Home</a>
                
                <a href="#menu" :class="scrolled ? 'text-gray-600 hover:text-minang-red' : 'text-white hover:text-minang-gold'" class="font-semibold text-sm uppercase tracking-wider transition-colors shadow-sm">Menu</a>
                
                
                <a href="<?php echo e(route('about')); ?>" :class="scrolled ? 'text-gray-600 hover:text-minang-red' : 'text-white hover:text-minang-gold'" class="font-semibold text-sm uppercase tracking-wider transition-colors shadow-sm">About</a>
            </div>

            
            <div class="hidden lg:flex items-center gap-3">
                <?php if(Route::has('login')): ?>
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="px-6 py-2.5 bg-minang-red hover:bg-red-700 text-white rounded-full font-bold text-sm shadow-glow transition-transform hover:-translate-y-0.5">
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" :class="scrolled ? 'text-gray-700 hover:text-minang-red' : 'text-white hover:text-minang-gold'" class="font-bold text-sm transition-colors mr-2 shadow-sm">
                            Sign In
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="px-6 py-2.5 bg-minang-red hover:bg-red-700 text-white rounded-full font-bold text-sm shadow-glow transition-transform hover:-translate-y-0.5 border border-white/20">
                            Sign Up
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            
            <button @click="mobileMenuOpen = !mobileMenuOpen" :class="scrolled ? 'text-gray-800' : 'text-white'" class="lg:hidden focus:outline-none">
                <i class="fas fa-bars text-2xl drop-shadow-md"></i>
            </button>
        </nav>
    </header>

    
    <div x-show="mobileMenuOpen" x-transition.opacity class="fixed inset-0 z-50 bg-black/50 lg:hidden backdrop-blur-sm" @click="mobileMenuOpen = false"></div>
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transform transition ease-out duration-300" 
         x-transition:enter-start="translate-x-full" 
         x-transition:enter-end="translate-x-0" 
         x-transition:leave="transform transition ease-in duration-300" 
         x-transition:leave-start="translate-x-0" 
         x-transition:leave-end="translate-x-full" 
         class="fixed inset-y-0 right-0 z-50 w-64 bg-white shadow-2xl lg:hidden flex flex-col">
        <div class="p-5 flex justify-between items-center border-b">
            <span class="font-bold text-lg text-gray-800">Menu</span>
            <button @click="mobileMenuOpen = false" class="text-gray-500 hover:text-minang-red">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-5 space-y-4">
            <a href="<?php echo e(route('welcome')); ?>" class="block text-gray-700 font-semibold hover:text-minang-red">Home</a>
            <a href="#menu" class="block text-gray-700 font-semibold hover:text-minang-red">Menu Pilihan</a>
            
            
            <a href="<?php echo e(route('about')); ?>" class="block text-gray-700 font-semibold hover:text-minang-red">Tentang Kami</a>

            <div class="border-t pt-4 mt-4 space-y-3">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('dashboard')); ?>" class="block w-full text-center bg-minang-red text-white py-3 rounded-lg font-bold shadow-lg">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="block w-full text-center border border-gray-300 text-gray-700 py-2.5 rounded-lg font-bold">Sign In</a>
                    <a href="<?php echo e(route('register')); ?>" class="block w-full text-center bg-minang-red text-white py-2.5 rounded-lg font-bold shadow-md">Sign Up</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <main>
        
        
        <section class="relative w-full h-[90vh] min-h-[600px] flex items-center justify-center overflow-hidden bg-gray-900">
            
            <div class="absolute inset-0 z-0">
                <img src="<?php echo e(asset('menu-images/ikanbakar.jpg')); ?>" alt="Hero Background" class="w-full h-full object-cover opacity-80">
                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/40 to-transparent"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-transparent to-transparent"></div>
            </div>

            
            
            <div class="container mx-auto px-6 relative z-30 pt-16">
                <div class="max-w-3xl text-white">
                    <span class="inline-block py-1.5 px-4 rounded-full bg-minang-gold/20 border border-minang-gold text-minang-gold text-xs font-bold uppercase tracking-widest mb-6 backdrop-blur-sm animate-pulse">
                        New Authentic Taste
                    </span>
                    <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6 drop-shadow-2xl">
                        Jagonya <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-minang-gold to-yellow-300">Rasa Original</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 mb-8 leading-relaxed max-w-lg drop-shadow-md">
                        Nikmati kelezatan masakan Minang modern dengan sistem booking praktis. 
                        <span class="text-white font-bold border-b-2 border-minang-red">Pesan online, ambil tanpa antri.</span>
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#menu" class="px-8 py-4 bg-minang-red hover:bg-red-700 text-white rounded-full font-bold shadow-[0_0_20px_rgba(199,0,36,0.5)] transition-all hover:scale-105 flex items-center gap-2">
                            <span>Pesan Sekarang</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            
        </section>

        
        
        <section class="relative z-40 -mt-16 md:-mt-24 px-4 pb-16">
            <div class="container mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl text-center group hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                        <div class="w-16 h-16 mx-auto bg-red-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-minang-red transition-colors duration-300">
                            <i class="fas fa-clock text-2xl text-minang-red group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Booking Cepat</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Pesan makanan favoritmu dari rumah, kami siapkan tepat waktu.</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl text-center group hover:-translate-y-2 transition-transform duration-300 border-2 border-minang-gold/20 relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-minang-gold text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg">POPULER</div>
                        <div class="w-16 h-16 mx-auto bg-yellow-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-minang-gold transition-colors duration-300">
                            <i class="fas fa-store text-2xl text-minang-gold group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Ambil di Tempat</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Skip antrian panjang. Datang, tunjukkan pesanan, langsung makan.</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2rem] shadow-xl text-center group hover:-translate-y-2 transition-transform duration-300 border border-gray-100">
                        <div class="w-16 h-16 mx-auto bg-green-50 rounded-2xl flex items-center justify-center mb-4 group-hover:bg-green-600 transition-colors duration-300">
                            <i class="fas fa-leaf text-2xl text-green-600 group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Bahan Segar</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Kami menggunakan rempah asli Minang dan bahan baku kualitas terbaik.</p>
                    </div>
                </div>
            </div>
        </section>

        
        <section id="menu" class="py-16 relative">
             <div class="absolute inset-0 bg-pattern opacity-50 pointer-events-none"></div>
             
            <div class="container mx-auto px-4 lg:px-8 relative z-10">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <span class="text-minang-red font-bold uppercase tracking-wider text-sm bg-red-50 px-3 py-1 rounded-full">Pilihan Favorit</span>
                    <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 mt-4 mb-4">Menu Andalan Kami</h2>
                    <div class="w-24 h-1.5 bg-minang-red mx-auto rounded-full mb-6"></div>
                    <p class="text-gray-600 text-lg">Setiap hidangan dimasak dengan resep warisan turun temurun.</p>
                </div>

                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                    <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group bg-white rounded-[2rem] shadow-md hover:shadow-2xl transition-all duration-300 flex flex-col overflow-hidden border border-gray-100 relative h-full">
                            
                            
                            <div class="relative w-full aspect-[4/3] overflow-hidden bg-gray-200">
                                <img src="<?php echo e(asset($menu->gambar)); ?>" 
                                     alt="<?php echo e($menu->namaMenu); ?>" 
                                     class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-110 relative z-10"
                                     loading="lazy">
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-60 group-hover:opacity-80 transition-opacity duration-300 z-20 pointer-events-none"></div>
                                
                                <span class="absolute top-4 left-4 bg-white/95 backdrop-blur-md px-3 py-1 rounded-full text-xs font-bold text-gray-900 shadow-md uppercase tracking-wide z-30">
                                    <?php echo e($menu->kategori); ?>

                                </span>
                            </div>

                            <div class="p-6 flex flex-col flex-grow relative">
                                <div class="absolute -top-8 right-6 bg-minang-red text-white w-16 h-16 rounded-full flex items-center justify-center font-bold text-sm shadow-glow border-4 border-white z-30 transform group-hover:scale-110 transition-transform">
                                    <div class="text-center leading-tight">
                                        <span class="text-[10px] block font-normal opacity-80">IDR</span>
                                        <?php echo e(number_format($menu->harga / 1000, 0)); ?>K
                                    </div>
                                </div>

                                <div class="mb-4 pt-2">
                                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-minang-red transition-colors line-clamp-1" title="<?php echo e($menu->namaMenu); ?>"><?php echo e($menu->namaMenu); ?></h3>
                                    <div class="flex items-center gap-1 mt-1">
                                        <?php for($i=0; $i<5; $i++): ?>
                                            <i class="fas fa-star text-xs <?php echo e($i < 4 ? 'text-minang-gold' : 'text-gray-300'); ?>"></i>
                                        <?php endfor; ?>
                                        <span class="text-xs text-gray-400 ml-2">(<?php echo e(rand(10, 100)); ?> reviews)</span>
                                    </div>
                                </div>
                                
                                <p class="text-gray-500 text-sm line-clamp-2 mb-6 flex-grow">
                                    <?php echo e($menu->deskripsi); ?>

                                </p>

                                <div class="mt-auto">
                                    <a href="<?php echo e(route('dashboard')); ?>" class="w-full block text-center py-3 rounded-xl border-2 border-minang-red text-minang-red font-bold hover:bg-minang-red hover:text-white transition-all duration-300 group-hover:shadow-lg">
                                        Tambah ke Pesanan
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full py-16 text-center bg-white rounded-[2rem] shadow-sm border border-dashed border-gray-300">
                            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-4">
                                <i class="fas fa-utensils text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800">Menu Sedang Disiapkan</h3>
                            <p class="text-gray-500">Silakan kembali lagi nanti untuk menu spesial kami.</p>
                        </div>
                    <?php endif; ?>
                </div>

                
                <div class="mt-24">
                    <a href="<?php echo e(route('dashboard')); ?>" class="group relative block w-full max-w-4xl mx-auto overflow-hidden rounded-[2.5rem] bg-minang-red shadow-2xl hover:shadow-[0_20px_50px_rgba(199,0,36,0.3)] transition-all duration-300 transform hover:-translate-y-1">
                        
                        <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/food.png')]"></div>
                        
                        <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent pointer-events-none"></div>

                        <div class="relative px-8 py-16 text-center sm:px-12 md:py-20 z-10">
                            <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-2 drop-shadow-md">
                                Lapar tapi malas antri?
                            </h2>
                            <p class="text-minang-gold font-bold text-lg mb-8">Pesan lewat Dashboard sekarang, langsung ambil!</p>
                            
                            <div class="inline-flex items-center rounded-full bg-white px-8 py-4 text-base font-bold text-minang-red shadow-lg hover:bg-gray-50 group-hover:scale-105 transition-transform">
                                Mulai Pesan
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </main>

    
    <footer class="bg-minang-dark text-gray-400 py-16 relative overflow-hidden mt-12 rounded-t-[3rem]">
        
        
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
                <p>&copy; <?php echo e(date('Y')); ?> Burjo Minang. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/welcome.blade.php ENDPATH**/ ?>