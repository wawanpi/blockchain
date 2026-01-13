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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('admin.menus.index')); ?>" class="p-2 bg-white rounded-full text-gray-500 hover:text-gray-900 shadow-sm border border-gray-100 transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    <?php echo e(__('Detail Menu')); ?>

                </h2>
                <p class="text-sm text-gray-500"><?php echo e($menu->namaMenu); ?></p>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                
                <div class="md:col-span-1 space-y-6">
                    
                    
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative group">
                        
                        
                        <div class="relative h-64 w-full bg-gray-100">
                            <?php if($menu->gambar): ?>
                                <img src="<?php echo e(asset($menu->gambar)); ?>" 
                                     alt="<?php echo e($menu->namaMenu); ?>" 
                                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                                     onerror="this.src='https://placehold.co/400x300/f1f5f9/94a3b8?text=No+Image'">
                            <?php else: ?>
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <i data-lucide="image" class="w-12 h-12"></i>
                                </div>
                            <?php endif; ?>

                            
                            <?php
                                $sisa = $menu->jumlah_saat_ini;
                                $statusClass = $sisa <= 0 ? 'bg-red-600 text-white' : ($sisa <= 10 ? 'bg-orange-500 text-white' : 'bg-green-500 text-white');
                                $statusText = $sisa <= 0 ? 'Habis' : ($sisa <= 10 ? 'Menipis' : 'Tersedia');
                            ?>
                            <div class="absolute top-4 right-4 px-3 py-1 rounded-full text-xs font-bold uppercase shadow-md <?php echo e($statusClass); ?>">
                                <?php echo e($statusText); ?>

                            </div>
                        </div>

                        <div class="p-6">
                            
                            <div class="flex justify-between items-start mb-2">
                                <h1 class="text-2xl font-black text-gray-800 leading-tight"><?php echo e($menu->namaMenu); ?></h1>
                            </div>
                            
                            <div class="flex items-center gap-2 mb-6">
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider
                                    <?php echo e($menu->kategori == 'makanan' ? 'bg-orange-50 text-orange-700' : 'bg-blue-50 text-blue-700'); ?>">
                                    <?php echo e(ucfirst($menu->kategori)); ?>

                                </span>
                                <span class="px-2.5 py-1 rounded-lg text-xs font-bold bg-gray-100 text-gray-600 flex items-center gap-1">
                                    <i data-lucide="box" class="w-3 h-3"></i> Stok: <?php echo e($sisa); ?>

                                </span>
                            </div>

                            
                            <div class="flex items-baseline gap-1 mb-6">
                                <span class="text-sm text-gray-500 font-medium">Harga</span>
                                <span class="text-3xl font-black text-[#D40000]">Rp <?php echo e(number_format($menu->harga, 0, ',', '.')); ?></span>
                            </div>

                            
                            <div class="mb-8">
                                <h4 class="text-sm font-bold text-gray-900 mb-2 flex items-center gap-2">
                                    <i data-lucide="file-text" class="w-4 h-4 text-gray-400"></i> Deskripsi
                                </h4>
                                <p class="text-sm text-gray-600 leading-relaxed">
                                    <?php echo e($menu->deskripsi ?? 'Tidak ada deskripsi tersedia untuk menu ini.'); ?>

                                </p>
                            </div>

                            
                            <div class="space-y-3">
                                <a href="<?php echo e(route('admin.menus.edit', $menu->id)); ?>" 
                                   class="flex items-center justify-center w-full px-4 py-3 bg-gray-900 text-white rounded-xl font-bold text-sm hover:bg-black transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i data-lucide="edit-3" class="w-4 h-4 mr-2"></i> Edit Menu
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
                
                
                <div class="md:col-span-2 space-y-6">
                    
                    
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 flex items-center gap-6">
                        <div class="text-center px-4 border-r border-gray-100">
                            <p class="text-5xl font-black text-gray-900"><?php echo e(number_format($menu->average_rating, 1)); ?></p>
                            <div class="flex items-center justify-center gap-1 text-yellow-400 my-2">
                                <?php for($i=1; $i<=5; $i++): ?>
                                    <i data-lucide="star" class="w-4 h-4 <?php echo e($menu->average_rating >= $i ? 'fill-current' : 'text-gray-200'); ?>"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="text-xs text-gray-500 font-medium"><?php echo e($menu->ratings_count); ?> Ulasan</p>
                        </div>
                        
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Analitik Ulasan</h3>
                            <p class="text-sm text-gray-500">Ringkasan kepuasan pelanggan terhadap menu ini.</p>
                        </div>
                    </div>

                    
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Ulasan Pelanggan</h3>
                        </div>

                        <div class="divide-y divide-gray-50 max-h-[600px] overflow-y-auto custom-scrollbar p-6 space-y-6">
                            <?php $__empty_1 = true; $__currentLoopData = $menu->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="flex gap-4">
                                    
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-sm font-bold text-gray-600 border border-gray-200">
                                            <?php echo e(substr($review->user->name, 0, 1)); ?>

                                        </div>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="text-sm font-bold text-gray-900"><?php echo e($review->user->name); ?></h4>
                                                <div class="flex items-center gap-1 mt-0.5">
                                                    <?php for($i=1; $i<=5; $i++): ?>
                                                        <i data-lucide="star" class="w-3 h-3 <?php echo e($review->rating >= $i ? 'text-yellow-400 fill-current' : 'text-gray-200'); ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-400"><?php echo e($review->created_at->diffForHumans()); ?></span>
                                        </div>
                                        
                                        <div class="mt-3 bg-gray-50 rounded-xl p-3 text-sm text-gray-600 italic border border-gray-100">
                                            "<?php echo e($review->komentar ?? 'Tidak ada komentar tertulis.'); ?>"
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-12">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                                        <i data-lucide="message-square-off" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada ulasan untuk menu ini.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
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
<?php endif; ?><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/admin/menus/show.blade.php ENDPATH**/ ?>