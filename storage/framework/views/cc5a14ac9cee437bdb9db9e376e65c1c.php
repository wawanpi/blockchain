<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <?php
        $categories = [];
        if(isset($bestSellers) && $bestSellers->isNotEmpty()) {
            $categories[] = ['id' => 'best-seller', 'name' => '🔥 Paling Laris', 'items' => $bestSellers];
        }
        if(isset($allFood) && $allFood->isNotEmpty()) {
            $categories[] = ['id' => 'makanan', 'name' => '🍜 Makanan', 'items' => $allFood];
        }
        if(isset($allDrinks) && $allDrinks->isNotEmpty()) {
            $categories[] = ['id' => 'minuman', 'name' => '🥤 Minuman', 'items' => $allDrinks];
        }
    ?>

    
    <div x-data="{ 
            activeSection: '<?php echo e($categories[0]['id'] ?? ''); ?>', 
            searchQuery: '',
            modalOpen: false,
            isLoading: false,
            selectedItem: { id: null, name: '', price: 0, image: '', desc: '', stok: 0, rating: 0 },
            quantity: 1,
            totalPrice: 0,

            openModal(item) {
                this.selectedItem = item;
                this.quantity = 1;
                this.totalPrice = item.price;
                this.modalOpen = true;
                this.isLoading = true;
                setTimeout(() => { this.isLoading = false; }, 300);
            },
            closeModal() { this.modalOpen = false; },
            increment() { if (this.quantity < this.selectedItem.stok) { this.quantity++; this.updateTotal(); } },
            decrement() { if (this.quantity > 1) { this.quantity--; this.updateTotal(); } },
            updateTotal() { this.totalPrice = this.selectedItem.price * this.quantity; },
            formatPrice(value) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(value); }
         }" 
         x-init="
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) activeSection = entry.target.id;
                });
            }, { rootMargin: '-20% 0px -70% 0px' });
            document.querySelectorAll('.menu-section').forEach(section => observer.observe(section));
         "
         class="min-h-screen relative pb-32">

        
        <div class="relative pt-12 pb-20 px-4 rounded-b-[3rem] shadow-2xl overflow-hidden min-h-[400px] flex items-center">
            
            
            
            <div class="absolute inset-0 z-0">
                
                <img src="https://images.unsplash.com/photo-1544025162-d76694265947?q=80&w=2069&auto=format&fit=crop" 
                     alt="Hero Background" 
                     class="w-full h-full object-cover object-center transform scale-105">
            </div>

            
            
            <div class="absolute inset-0 bg-gradient-to-r from-black/95 via-black/70 to-black/30 z-0"></div>
            
            
            <div class="container mx-auto relative z-10 w-full">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                    
                    
                    <div class="text-white max-w-xl">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="bg-burmin-red text-white text-[10px] font-bold px-2 py-1 rounded shadow-lg shadow-red-900/50 tracking-wider">MEMBER SETIA</span>
                            <p class="text-gray-300 text-sm font-medium">Halo, <?php echo e(Auth::user()->name ?? 'Sobat Burmin'); ?>! 👋</p>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight text-white drop-shadow-lg mb-4">
                            Mau makan enak <br> 
                            <span class="text-burmin-yellow italic">apa hari ini?</span>
                        </h1>
                        <p class="text-gray-400 text-sm md:text-base leading-relaxed hidden md:block border-l-4 border-burmin-red pl-4">
                            Nikmati cita rasa otentik Minang dalam setiap sajian warmindo. <br>
                            Pesan online, ambil tanpa antri.
                        </p>
                    </div>
                    
                    
                    <div class="w-full md:w-[28rem] relative group mt-4 md:mt-0">
                        
                        <div class="absolute -inset-1 bg-gradient-to-r from-burmin-red to-burmin-yellow rounded-2xl blur opacity-20 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                        
                        <div class="relative">
                            <input type="text" x-model="searchQuery" placeholder="Cari menu favoritmu (ex: Nila Bakar)..." 
                                class="w-full pl-14 pr-4 py-5 rounded-2xl border-none shadow-2xl bg-white/95 backdrop-blur-sm text-gray-800 placeholder-gray-400 focus:ring-4 focus:ring-burmin-yellow/50 transition-all font-medium">
                            
                            <div class="absolute left-5 top-5 text-gray-400 group-focus-within:text-burmin-red transition-colors">
                                <i data-lucide="search" class="w-6 h-6"></i>
                            </div>
                            
                            <button x-show="searchQuery.length > 0" @click="searchQuery = ''" class="absolute right-5 top-5 text-gray-400 hover:text-red-500 transition-colors" x-transition>
                                <i data-lucide="x" class="w-6 h-6"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        
        <div class="sticky top-20 z-30 -mt-8 mb-8">
            <div class="container mx-auto px-4">
                <nav class="flex overflow-x-auto no-scrollbar gap-3 pb-4 snap-x scroll-pl-4">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="#<?php echo e($cat['id']); ?>" 
                           @click.prevent="document.getElementById('<?php echo e($cat['id']); ?>').scrollIntoView({behavior: 'smooth'})"
                           class="whitespace-nowrap px-6 py-3 rounded-full text-sm font-bold shadow-lg transition-all duration-300 snap-start border border-white/50 backdrop-blur-md"
                           :class="activeSection === '<?php echo e($cat['id']); ?>' 
                                ? 'bg-burmin-black text-white ring-2 ring-burmin-yellow scale-105' 
                                : 'bg-white/90 text-gray-500 hover:bg-burmin-red hover:text-white'">
                            <?php echo e($cat['name']); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>
            </div>
        </div>

        
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <section id="<?php echo e($category['id']); ?>" class="menu-section scroll-mt-48 transition-all duration-500">
                    <div class="flex items-center gap-3 mb-5">
                        
                        <div class="w-1.5 h-8 bg-burmin-red rounded-full"></div>
                        <h2 class="text-xl font-black text-gray-900 uppercase tracking-wide">
                            <?php echo e($category['name']); ?>

                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        <?php $__currentLoopData = $category['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $stok = $item->ketersediaanHariIni->jumlah_saat_ini ?? 0;
                                $itemData = [
                                    'id' => $item->id,
                                    'name' => $item->namaMenu,
                                    'price' => $item->harga,
                                    'image' => asset($item->gambar),
                                    'desc' => $item->deskripsi,
                                    'stok' => $stok,
                                    'rating' => round($item->reviews_avg_rating ?? 0, 1)
                                ];
                            ?>

                            
                            <div class="group bg-white rounded-2xl p-3 shadow-sm border border-gray-100 hover:shadow-xl hover:border-burmin-yellow transition-all duration-300 cursor-pointer flex flex-row md:flex-col gap-4 h-32 md:h-auto relative overflow-hidden"
                                 x-show="!searchQuery || '<?php echo e(strtolower($item->namaMenu)); ?>'.includes(searchQuery.toLowerCase())"
                                 x-transition
                                 @click="openModal(<?php echo e(json_encode($itemData)); ?>)">
                                
                                
                                <div class="w-28 md:w-full h-full md:h-48 rounded-xl overflow-hidden relative shrink-0 bg-gray-100">
                                    <img src="<?php echo e(asset($item->gambar)); ?>" alt="<?php echo e($item->namaMenu); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                                         onerror="this.src='https://placehold.co/400x300/f3f4f6/a3a3a3?text=No+Image'">
                                    
                                    <?php if($stok <= 0): ?>
                                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center">
                                            <span class="text-white font-bold text-xs px-2 py-1 border border-white rounded transform -rotate-12">HABIS</span>
                                        </div>
                                    <?php elseif($stok < 10): ?>
                                        <div class="absolute top-2 left-2 bg-burmin-yellow text-black text-[10px] font-bold px-2 py-0.5 rounded-full shadow-md">
                                            Sisa <?php echo e($stok); ?>

                                        </div>
                                    <?php endif; ?>
                                </div>

                                
                                <div class="flex flex-col justify-between flex-grow py-1">
                                    <div>
                                        <div class="flex justify-between items-start gap-2">
                                            <h3 class="font-bold text-gray-800 text-base md:text-lg leading-tight line-clamp-2 group-hover:text-burmin-red transition-colors">
                                                <?php echo e($item->namaMenu); ?>

                                            </h3>
                                            <?php if(($item->reviews_avg_rating ?? 0) > 0): ?>
                                                <div class="flex items-center gap-1 bg-gray-50 px-1.5 py-0.5 rounded text-[10px] font-bold text-gray-600 shrink-0">
                                                    <i data-lucide="star" class="w-3 h-3 text-burmin-yellow fill-burmin-yellow"></i>
                                                    <?php echo e(round($item->reviews_avg_rating, 1)); ?>

                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <p class="text-xs text-gray-400 mt-1 line-clamp-2"><?php echo e($item->deskripsi); ?></p>
                                    </div>

                                    <div class="flex items-center justify-between mt-2 md:mt-4">
                                        <span class="font-black text-gray-900 text-base md:text-lg">
                                            Rp <?php echo e(number_format($item->harga, 0, ',', '.')); ?>

                                        </span>
                                        
                                        <button class="w-8 h-8 md:w-10 md:h-10 rounded-full flex items-center justify-center transition-all active:scale-90 shadow-sm"
                                                :class="<?php echo e($stok <= 0 ? '!bg-gray-100 !text-gray-300 cursor-not-allowed' : 'bg-gray-100 text-gray-900 group-hover:bg-burmin-red group-hover:text-white'); ?>"
                                                :disabled="<?php echo e($stok <= 0 ? 'true' : 'false'); ?>">
                                            <i data-lucide="plus" class="w-4 h-4 md:w-5 md:h-5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
        <div x-show="<?php echo e(\Cart::getTotalQuantity() > 0 ? 'true' : 'false'); ?>" 
             class="fixed bottom-6 left-4 right-4 z-40 md:max-w-md md:left-auto md:right-8"
             x-transition:enter="transform transition ease-out duration-300"
             x-transition:enter-start="translate-y-20 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-cloak>
             
            <a href="<?php echo e(route('cart.list')); ?>" class="flex items-center justify-between bg-burmin-black/95 backdrop-blur-md text-white p-4 rounded-2xl shadow-2xl shadow-gray-400/50 border border-burmin-yellow/50 hover:bg-black transition-all group">
                <div class="flex items-center gap-4">
                    <div class="bg-white text-black w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg shadow-inner relative border border-burmin-yellow">
                        <?php echo e(\Cart::getTotalQuantity()); ?>

                        <span class="absolute -top-1 -right-1 flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-burmin-red opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-burmin-red"></span>
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Total Bayar</span>
                        <span class="font-bold text-xl leading-none">Rp <?php echo e(number_format(\Cart::getTotal(), 0, ',', '.')); ?></span>
                    </div>
                </div>
                <div class="flex items-center gap-2 pr-2">
                    <span class="font-bold text-sm text-burmin-yellow group-hover:mr-2 transition-all">Checkout</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 text-burmin-yellow"></i>
                </div>
            </a>
        </div>
        <?php endif; ?>

        
        <template x-teleport="body">
            <div x-show="modalOpen" class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center sm:px-4" x-cloak>
                <div x-show="modalOpen" @click="closeModal()" x-transition.opacity class="fixed inset-0 bg-black/70 backdrop-blur-sm"></div>

                <div x-show="modalOpen"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-10 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-10 sm:scale-95"
                     class="relative bg-white w-full max-w-lg h-[85vh] sm:h-auto sm:max-h-[90vh] flex flex-col rounded-t-3xl sm:rounded-3xl shadow-2xl overflow-hidden border-t-4 border-burmin-red">
                    
                    
                    <button @click="closeModal()" class="absolute top-4 right-4 z-20 bg-black/20 hover:bg-black/40 text-white p-2 rounded-full backdrop-blur-md transition">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>

                    <div class="flex-1 overflow-y-auto no-scrollbar">
                        
                        <div class="relative h-64 sm:h-72 bg-gray-100">
                            <img :src="selectedItem.image" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-6 w-full">
                                <h2 class="text-3xl font-black text-white leading-tight drop-shadow-md" x-text="selectedItem.name"></h2>
                                <p class="text-2xl font-bold text-burmin-yellow mt-1 drop-shadow-md" x-text="formatPrice(selectedItem.price)"></p>
                            </div>
                        </div>

                        <div class="p-6">
                            
                            <div class="flex items-center gap-4 mb-6 text-sm text-gray-600">
                                <div class="flex items-center gap-1 bg-yellow-50 px-2 py-1 rounded-lg text-yellow-700 font-bold border border-burmin-yellow">
                                    <i data-lucide="star" class="w-4 h-4 fill-burmin-yellow text-burmin-yellow"></i>
                                    <span x-text="selectedItem.rating"></span>
                                </div>
                                <div class="flex items-center gap-1" :class="selectedItem.stok > 0 ? 'text-green-600' : 'text-red-600'">
                                    <i data-lucide="package" class="w-4 h-4"></i>
                                    <span x-text="selectedItem.stok > 0 ? 'Stok: ' + selectedItem.stok : 'Habis'"></span>
                                </div>
                            </div>

                            <p class="text-gray-600 leading-relaxed mb-8 text-sm" x-text="selectedItem.desc || 'Belum ada deskripsi untuk menu ini.'"></p>

                            
                            <form action="<?php echo e(route('cart.store')); ?>" method="POST" class="mt-auto">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="id" :value="selectedItem.id">
                                <input type="hidden" name="quantity" :value="quantity">

                                <div class="flex items-center gap-4">
                                    
                                    <div class="flex items-center bg-gray-100 rounded-full px-2 py-2" :class="selectedItem.stok <= 0 ? 'opacity-50 pointer-events-none' : ''">
                                        <button type="button" @click="decrement()" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow text-gray-700 hover:text-burmin-red transition disabled:opacity-50" :disabled="quantity <= 1">
                                            <i data-lucide="minus" class="w-4 h-4"></i>
                                        </button>
                                        <span class="w-12 text-center font-bold text-lg" x-text="quantity"></span>
                                        <button type="button" @click="increment()" class="w-10 h-10 flex items-center justify-center bg-white rounded-full shadow text-gray-700 hover:text-burmin-red transition disabled:opacity-50" :disabled="quantity >= selectedItem.stok">
                                            <i data-lucide="plus" class="w-4 h-4"></i>
                                        </button>
                                    </div>

                                    
                                    <button type="submit" 
                                            :disabled="selectedItem.stok <= 0"
                                            :class="selectedItem.stok <= 0 ? 'bg-gray-300 cursor-not-allowed text-gray-500' : 'bg-burmin-red hover:bg-red-800 text-white shadow-lg shadow-red-200'"
                                            class="flex-1 h-14 rounded-full font-bold transition-all flex items-center justify-center gap-2 active:scale-95">
                                        <span x-text="selectedItem.stok <= 0 ? 'Stok Habis' : 'Tambah - ' + formatPrice(totalPrice)"></span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/dashboard.blade.php ENDPATH**/ ?>