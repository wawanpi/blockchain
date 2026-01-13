
<div 
    x-show="sidebarOpen" 
    @click="sidebarOpen = false"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-black/60 z-[45]"
    x-cloak
></div>


<div 
    x-show="sidebarOpen"
    x-transition:enter="transform ease-out duration-300"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform ease-in duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed top-0 left-0 h-full w-80 bg-white z-50 shadow-2xl flex flex-col"
    x-cloak
>
    
    <div class="flex justify-between items-center p-6 border-b border-gray-100">
        <div class="flex items-center gap-3">
             
             <img src="<?php echo e(asset('img/burmin_logo.jpg')); ?>" alt="Burmin" class="h-10 w-auto object-contain">
             <span class="font-black text-xl text-gray-800 tracking-tighter">BURMIN</span>
        </div>
        <button @click="sidebarOpen = false" class="p-2 hover:bg-red-50 text-gray-500 hover:text-burmin-red rounded-full transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    
    <div class="p-6 bg-gray-50 border-b border-gray-100">
        <?php if(auth()->guard()->check()): ?>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-burmin-black text-white flex items-center justify-center border-2 border-burmin-yellow shadow-sm">
                    <span class="font-bold text-lg"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                </div>
                <div>
                    <p class="font-bold text-gray-900 text-lg leading-tight"><?php echo e(Auth::user()->name); ?></p>
                    <p class="text-xs text-burmin-red font-bold uppercase tracking-wide mt-1">Member Setia</p>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center">
                <p class="text-gray-500 text-sm mb-3">Nikmati fitur lengkap dengan akun</p>
                <a href="<?php echo e(route('login')); ?>" class="block w-full bg-burmin-red text-white py-3 rounded-xl font-bold shadow-lg shadow-red-200 active:scale-95 transition-all">
                    Login / Register
                </a>
            </div>
        <?php endif; ?>
    </div>

    
    <nav class="flex-grow p-6 space-y-2 overflow-y-auto">
        <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-4 p-3 rounded-xl font-medium transition-all <?php echo e(request()->routeIs('dashboard') ? 'bg-red-50 text-burmin-red' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
            <i data-lucide="utensils" class="w-5 h-5"></i>
            <span>Menu Makanan</span>
        </a>
        
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('cart.list')); ?>" class="flex items-center justify-between p-3 rounded-xl font-medium transition-all <?php echo e(request()->routeIs('cart.list') ? 'bg-red-50 text-burmin-red' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <div class="flex items-center gap-4">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <span>Keranjang</span>
                </div>
                <?php if(\Cart::getTotalQuantity() > 0): ?>
                    <span class="bg-burmin-red text-white text-[10px] font-bold px-2 py-0.5 rounded-full"><?php echo e(\Cart::getTotalQuantity()); ?></span>
                <?php endif; ?>
            </a>

            <a href="<?php echo e(route('orders.index')); ?>" class="flex items-center gap-4 p-3 rounded-xl font-medium transition-all <?php echo e(request()->routeIs('orders.*') ? 'bg-red-50 text-burmin-red' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <i data-lucide="history" class="w-5 h-5"></i>
                <span>Riwayat Pesanan</span>
            </a>

            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-4 p-3 rounded-xl font-medium transition-all <?php echo e(request()->routeIs('profile.edit') ? 'bg-red-50 text-burmin-red' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                <i data-lucide="user-cog" class="w-5 h-5"></i>
                <span>Pengaturan Akun</span>
            </a>
            
            <div class="border-t border-gray-100 my-4"></div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="flex w-full items-center gap-4 p-3 rounded-xl text-red-600 hover:bg-red-50 font-bold transition-colors">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span>Keluar Aplikasi</span>
                </button>
            </form>
        <?php endif; ?>
    </nav>
</div>



<header class="bg-burmin-black text-white shadow-xl fixed w-full top-0 left-0 z-40 h-20 transition-all duration-300 border-b-4 border-burmin-red">
    <div class="container mx-auto px-4 lg:px-8 h-full flex justify-between items-center">
        
        
        <div class="flex items-center gap-4 md:gap-6">
            
            <button @click="sidebarOpen = true" class="md:hidden p-2 hover:bg-white/10 rounded-lg transition text-white">
                <i data-lucide="menu" class="w-7 h-7"></i>
            </button>

            
            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 group">
                
                <div class="relative w-10 h-10 md:w-12 md:h-12 bg-white rounded-full flex items-center justify-center p-1 shadow-lg shadow-white/10 group-hover:scale-105 transition-transform duration-300">
                    <img src="<?php echo e(asset('img/burmin_logo.jpg')); ?>" alt="Burmin" class="w-full h-full object-contain rounded-full">
                </div>
                
                
                <div class="flex flex-col">
                    <span class="text-lg md:text-2xl font-black tracking-tighter leading-none text-white group-hover:text-burmin-yellow transition-colors">
                        BURMIN
                    </span>
                    <span class="text-[10px] md:text-xs font-medium text-gray-400 tracking-widest uppercase">
                        Jagonya Warmindo
                    </span>
                </div>
            </a>
        </div>

        
        <nav class="hidden md:flex items-center gap-8">
            <a href="<?php echo e(route('dashboard')); ?>" class="text-sm font-bold text-white hover:text-burmin-yellow transition-colors relative py-2 group">
                BERANDA
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-burmin-yellow transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?php echo e(route('dashboard')); ?>#makanan" class="text-sm font-bold text-gray-300 hover:text-burmin-yellow transition-colors relative py-2 group">
                MAKANAN
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-burmin-yellow transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?php echo e(route('dashboard')); ?>#minuman" class="text-sm font-bold text-gray-300 hover:text-burmin-yellow transition-colors relative py-2 group">
                MINUMAN
                <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-burmin-yellow transition-all duration-300 group-hover:w-full"></span>
            </a>
            
            
            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('orders.index')); ?>" class="text-sm font-bold <?php echo e(request()->routeIs('orders.*') ? 'text-burmin-yellow' : 'text-gray-300'); ?> hover:text-burmin-yellow transition-colors relative py-2 group">
                    RIWAYAT
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-burmin-yellow transition-all duration-300 group-hover:w-full <?php echo e(request()->routeIs('orders.*') ? 'w-full' : ''); ?>"></span>
                </a>
            <?php else: ?>
                <a href="#" class="text-sm font-bold text-gray-300 hover:text-burmin-yellow transition-colors relative py-2 group">
                    TENTANG KAMI
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-burmin-yellow transition-all duration-300 group-hover:w-full"></span>
                </a>
            <?php endif; ?>
        </nav>

        
        <div class="flex items-center gap-4 md:gap-6">
            <?php if(auth()->guard()->check()): ?>
            
            <button class="md:hidden p-2 text-white hover:text-burmin-yellow">
                <i data-lucide="search" class="w-6 h-6"></i>
            </button>

            
            <a href="<?php echo e(route('cart.list')); ?>" class="flex items-center gap-2 group focus:outline-none">
                
                <div class="relative w-9 h-9 md:w-10 md:h-10 bg-white/10 rounded-full flex items-center justify-center group-hover:bg-burmin-yellow group-hover:text-burmin-black text-white transition-all">
                    <i data-lucide="shopping-bag" class="w-5 h-5"></i>
                    <?php if(\Cart::getTotalQuantity() > 0): ?>
                        <span class="absolute -top-1 -right-1 bg-burmin-red text-white text-[10px] font-bold h-4 w-4 rounded-full flex items-center justify-center border-2 border-burmin-black">
                            <?php echo e(\Cart::getTotalQuantity()); ?>

                        </span>
                    <?php endif; ?>
                </div>
                
                <div class="hidden lg:flex flex-col items-start text-left">
                    <span class="text-xs text-gray-400 leading-none group-hover:text-burmin-yellow transition-colors">Checkout</span>
                    <span class="text-sm font-bold text-white leading-none group-hover:text-burmin-yellow transition-colors">Keranjang</span>
                </div>
            </a>
            <?php endif; ?>

            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 focus:outline-none group">
                    
                    <div class="w-9 h-9 md:w-10 md:h-10 bg-white text-burmin-black rounded-full flex items-center justify-center shadow-lg border-2 border-transparent group-hover:border-burmin-yellow transition-all overflow-hidden">
                        <?php if(auth()->guard()->check()): ?>
                            <span class="font-bold"><?php echo e(substr(Auth::user()->name, 0, 1)); ?></span>
                        <?php else: ?>
                            <i data-lucide="user" class="w-5 h-5"></i>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(auth()->guard()->check()): ?>
                    <div class="hidden lg:flex flex-col items-start text-left">
                        <span class="text-xs text-gray-400 leading-none">Halo,</span>
                        <span class="text-sm font-bold text-white leading-none max-w-[80px] truncate"><?php echo e(strtok(Auth::user()->name, " ")); ?></span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-500 hidden lg:block transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    <?php endif; ?>
                </button>

                
                <div 
                    x-show="open"
                    @click.outside="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 translate-y-2"
                    class="absolute right-0 top-14 z-50 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 overflow-hidden"
                    x-cloak
                >
                    <?php if(auth()->guard()->check()): ?>
                        <div class="p-4 bg-gray-900 text-white bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
                            <p class="font-bold truncate text-lg"><?php echo e(Auth::user()->name); ?></p>
                            <p class="text-xs text-burmin-yellow mt-1">Member Level: Gold</p>
                        </div>
                        <div class="p-2 space-y-1">
                            
                            <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 rounded-lg text-sm text-gray-700 hover:text-burmin-red transition-colors">
                                <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan Akun
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-red-50 text-red-600 rounded-lg text-sm text-left font-semibold transition-colors">
                                    <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                                </button>
                            </form>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-center">
                            <p class="text-gray-600 text-sm mb-3">Belum punya akun?</p>
                            <a href="<?php echo e(route('login')); ?>" class="block w-full py-2 bg-burmin-red text-white rounded-lg font-bold hover:bg-red-800 transition">Masuk / Daftar</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</header><?php /**PATH D:\blocchain-burmin\resources\views/layouts/navigation-user.blade.php ENDPATH**/ ?>