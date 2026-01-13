{{-- 
    =========================================
    NAVIGASI ADMIN (SIDEBAR + TOPBAR)
    =========================================
--}}

{{-- 
    LOGIKA: Mengambil Data Notifikasi Pesanan 'Pending'
    (Langsung di View agar praktis tanpa mengubah Controller lain)
--}}
@php
    $notifOrders = collect([]);
    $notifCount = 0;
    try {
        if (class_exists(\App\Models\Pesanan::class)) {
            $notifOrders = \App\Models\Pesanan::where('status', 'pending')
                            ->latest()
                            // ->take(5)  <-- BAGIAN INI SUDAH DIHAPUS AGAR SEMUA MUNCUL
                            ->get();
            $notifCount = $notifOrders->count();
        }
    } catch (\Exception $e) {
        // Silent fail jika tabel belum siap
    }
@endphp

{{-- BACKDROP OVERLAY (UNTUK MOBILE) --}}
<div x-show="sidebarOpen" 
     @click="sidebarOpen = false"
     x-transition:enter="transition-opacity ease-linear duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity ease-linear duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 bg-gray-900/50 z-40 lg:hidden backdrop-blur-sm"
     x-cloak>
</div>

{{-- KONTAINER SIDEBAR --}}
<div class="fixed top-0 left-0 z-50 h-screen w-64 bg-white shadow-2xl border-r border-gray-100 flex flex-col transition-transform duration-300 ease-in-out font-sans"
     :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

    {{-- 1. HEADER SIDEBAR (LOGO) --}}
    <div class="h-16 flex items-center justify-between px-6 border-b border-gray-100 shrink-0">
        <div class="flex flex-col">
            <span class="text-2xl font-black text-[#D40000] uppercase tracking-tighter leading-none">BURMIN</span>
            <span class="text-[10px] font-bold text-gray-400 tracking-[0.2em] uppercase mt-0.5">Admin Panel</span>
        </div>
        {{-- Tombol Tutup (Hanya di Mobile) --}}
        <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-[#D40000] transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>

    {{-- 2. PROFIL ADMIN MINI --}}
    <div class="p-5 border-b border-gray-50 bg-gray-50/30">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-[#D40000] text-white flex items-center justify-center font-bold text-sm shadow-md ring-2 ring-white">
                {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-xs font-medium text-green-600">Online</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. MENU NAVIGASI --}}
    <nav class="flex-grow px-4 py-4 space-y-1 overflow-y-auto custom-scrollbar">
        
        {{-- Grup: UTAMA --}}
        <div class="mb-2 px-3">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Utama</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" 
           class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('admin.dashboard') 
              ? 'bg-red-50 text-[#D40000]' 
              : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            
            @if(request()->routeIs('admin.dashboard'))
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#D40000] rounded-r-full"></span>
            @endif

            <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-[#D40000]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
            <span>Dashboard</span>
        </a>

        {{-- Grup: OPERASIONAL --}}
        <div class="mt-6 mb-2 px-3">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Operasional</p>
        </div>

        <a href="{{ route('admin.pesanan.index') }}" 
           class="group relative flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('admin.pesanan.*') ? 'bg-red-50 text-[#D40000]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            
            @if(request()->routeIs('admin.pesanan.*'))
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#D40000] rounded-r-full"></span>
            @endif

            <div class="flex items-center gap-3">
                <i data-lucide="shopping-bag" class="w-5 h-5 {{ request()->routeIs('admin.pesanan.*') ? 'text-[#D40000]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
                <span>Pesanan Masuk</span>
            </div>
            
            @if($notifCount > 0)
                <span class="bg-[#D40000] text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm shadow-red-200">{{ $notifCount }}</span>
            @endif
        </a>

        <a href="{{ route('admin.transaksi.index') }}" 
           class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('admin.transaksi.*') ? 'bg-red-50 text-[#D40000]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            @if(request()->routeIs('admin.transaksi.*'))
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#D40000] rounded-r-full"></span>
            @endif
            <i data-lucide="receipt" class="w-5 h-5 {{ request()->routeIs('admin.transaksi.*') ? 'text-[#D40000]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
            <span>Laporan Transaksi</span>
        </a>

        <a href="{{ route('admin.menus.index') }}" 
           class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('admin.menus.*') ? 'bg-red-50 text-[#D40000]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            @if(request()->routeIs('admin.menus.*'))
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#D40000] rounded-r-full"></span>
            @endif
            <i data-lucide="utensils-crossed" class="w-5 h-5 {{ request()->routeIs('admin.menus.*') ? 'text-[#D40000]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
            <span>Manajemen Menu</span>
        </a>

        {{-- Grup: SISTEM --}}
        <div class="mt-6 mb-2 px-3">
            <p class="text-[10px] font-extrabold text-gray-400 uppercase tracking-wider">Sistem</p>
        </div>

        <a href="{{ route('admin.users.index') }}" 
           class="group relative flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
           {{ request()->routeIs('admin.users.*') ? 'bg-red-50 text-[#D40000]' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
            @if(request()->routeIs('admin.users.*'))
                <span class="absolute left-0 top-1/2 -translate-y-1/2 w-1 h-8 bg-[#D40000] rounded-r-full"></span>
            @endif
            <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-[#D40000]' : 'text-gray-400 group-hover:text-gray-600' }}"></i>
            <span>Data Pengguna</span>
        </a>
    </nav>

    {{-- 4. FOOTER SIDEBAR (LOGOUT) --}}
    <div class="p-4 border-t border-gray-100 bg-white">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white border border-gray-200 text-red-600 text-sm font-bold rounded-xl hover:bg-red-50 hover:border-red-100 transition-all shadow-sm group">
                <i data-lucide="log-out" class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform"></i>
                <span>Keluar</span>
            </button>
        </form>
    </div>
</div>


{{-- 
    =========================================
    HEADER ADMIN (TOPBAR)
    =========================================
--}}
<header class="fixed top-0 left-0 w-full z-30 bg-white/90 backdrop-blur-sm border-b border-gray-200 h-16 transition-all duration-300 lg:pl-64">
    <div class="container mx-auto px-4 h-full flex items-center justify-between">
        
        {{-- KIRI: Hamburger (Mobile) --}}
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = true" class="lg:hidden p-2 hover:bg-gray-100 rounded-lg text-gray-600 transition-colors">
                <i data-lucide="menu" class="w-6 h-6"></i>
            </button>
        </div>

        {{-- KANAN: Notifikasi & Profil --}}
        <div class="flex items-center gap-3 sm:gap-5">
            
            {{-- DROPDOWN NOTIFIKASI --}}
            <div class="relative" x-data="{ notifOpen: false }">
                <button @click="notifOpen = !notifOpen" 
                        class="relative p-2.5 rounded-full transition-all duration-200 outline-none"
                        :class="notifOpen ? 'bg-red-50 text-[#D40000]' : 'text-gray-400 hover:text-[#D40000] hover:bg-gray-50'">
                    
                    <i data-lucide="bell" class="w-5 h-5"></i>
                    
                    {{-- Titik Merah (Pulse) jika ada notif --}}
                    @if($notifCount > 0)
                        <span class="absolute top-2 right-2 flex h-2.5 w-2.5">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-[#D40000] border-2 border-white"></span>
                        </span>
                    @endif
                </button>

                {{-- Isi Dropdown --}}
                <div x-show="notifOpen" 
                     @click.outside="notifOpen = false"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     class="absolute right-0 top-14 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-50 overflow-hidden ring-1 ring-black/5"
                     x-cloak>
                    
                    <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
                        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Notifikasi</span>
                        @if($notifCount > 0)
                            <span class="bg-red-100 text-[#D40000] text-[10px] font-bold px-2 py-0.5 rounded-full">{{ $notifCount }} Baru</span>
                        @endif
                    </div>

                    {{-- LIST NOTIFIKASI (TANPA BATAS JUMLAH) --}}
                    <div class="max-h-[300px] overflow-y-auto custom-scrollbar">
                        @forelse($notifOrders as $order)
                            <a href="{{ route('admin.pesanan.index') }}" class="block px-4 py-3 hover:bg-gray-50 transition border-b border-gray-50 last:border-0 group">
                                <div class="flex gap-3">
                                    <div class="mt-1 bg-yellow-100 text-yellow-600 w-9 h-9 rounded-full flex items-center justify-center shrink-0 group-hover:bg-[#D40000] group-hover:text-white transition-colors">
                                        <i data-lucide="shopping-bag" class="w-4 h-4"></i>
                                    </div>
                                    <div class="flex-grow overflow-hidden">
                                        <div class="flex justify-between items-start mb-0.5">
                                            <p class="text-sm font-bold text-gray-800 truncate">Pesanan #{{ $order->id }}</p>
                                            <span class="text-[10px] text-gray-400 whitespace-nowrap">{{ $order->created_at->diffForHumans(null, true) }}</span>
                                        </div>
                                        <p class="text-xs text-gray-500 truncate">
                                            Menunggu konfirmasi <span class="font-bold text-gray-700">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="text-[10px] font-bold text-[#D40000] mt-1 uppercase tracking-wide">Pending</p>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="px-4 py-8 text-center flex flex-col items-center">
                                <div class="bg-gray-50 w-12 h-12 rounded-full flex items-center justify-center mb-3 text-gray-300">
                                    <i data-lucide="bell-off" class="w-6 h-6"></i>
                                </div>
                                <p class="text-sm font-bold text-gray-700">Tidak ada notifikasi</p>
                                <p class="text-xs text-gray-400">Semua aman terkendali.</p>
                            </div>
                        @endforelse
                    </div>

                    @if($notifCount > 0)
                        <div class="border-t border-gray-100 bg-gray-50 p-2">
                            <a href="{{ route('admin.pesanan.index') }}" class="flex items-center justify-center gap-1 w-full py-2 text-xs font-bold text-[#D40000] hover:bg-white rounded-lg transition-colors border border-transparent hover:border-gray-200">
                                Lihat Semua Pesanan <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            {{-- DROPDOWN PROFIL ADMIN --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 hover:bg-gray-50 rounded-full p-1 pr-3 transition border border-transparent hover:border-gray-200">
                    <div class="w-9 h-9 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 text-xs font-bold border border-gray-200">
                        {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                    </div>
                    <span class="hidden md:block text-sm font-bold text-gray-700">Hi, Admin</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="open" @click.outside="open = false" 
                     class="absolute right-0 top-14 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 ring-1 ring-black/5" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     x-cloak>
                    
                    <div class="px-4 py-3 border-b border-gray-50">
                        <p class="text-xs text-gray-400 font-bold uppercase">Masuk sebagai</p>
                        <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#D40000] transition-colors">
                            <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan
                        </a>
                    </div>

                    <div class="border-t border-gray-100 my-1"></div>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex w-full items-center gap-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors font-medium">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>