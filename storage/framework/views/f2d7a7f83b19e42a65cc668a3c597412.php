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
    <div class="container mx-auto px-4 py-8 lg:py-12 max-w-4xl">
        
        <div class="flex items-center gap-3 mb-8">
            <a href="<?php echo e(route('dashboard')); ?>" class="p-2 rounded-full hover:bg-gray-100 transition text-gray-500 hover:text-[#E3002B]">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <div>
                <h1 class="text-2xl lg:text-3xl font-black text-gray-900 uppercase tracking-wide">
                    Riwayat <span class="text-[#E3002B]">Pesanan</span>
                </h1>
                <p class="text-sm text-gray-500 mt-1">Lacak semua pesananmu di sini</p>
            </div>
        </div>

        
        <?php if(session('success')): ?>
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm flex items-center gap-3 animate-fade-in-down">
                <i data-lucide="check-circle" class="w-5 h-5"></i>
                <span><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm flex items-center gap-3 animate-fade-in-down">
                <i data-lucide="alert-circle" class="w-5 h-5"></i>
                <span><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?>

        
        <div class="space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $pesanans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pesanan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition-shadow flex flex-col sm:flex-row justify-between gap-4">
                    
                    
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-3">
                            <span class="font-bold text-gray-900 text-lg">Order #<?php echo e($pesanan->id); ?></span>
                            
                            
                            <?php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                    'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'completed' => 'bg-green-100 text-green-700 border-green-200',
                                    'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                                ];
                                $colorClass = $statusColors[$pesanan->status] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                            ?>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wide border <?php echo e($colorClass); ?>">
                                <?php echo e(ucfirst($pesanan->status)); ?>

                            </span>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                            <span><?php echo e($pesanan->created_at->format('d M Y, H:i')); ?></span>
                        </div>
                        <div class="mt-2">
                            <span class="text-xs text-gray-400 font-bold uppercase tracking-wider">Total Bayar</span>
                            <p class="text-xl font-black text-[#E3002B]">Rp <?php echo e(number_format($pesanan->total_bayar, 0, ',', '.')); ?></p>
                        </div>
                    </div>

                    
                    <div class="flex flex-row sm:flex-col items-center sm:items-end gap-2 sm:gap-2 mt-2 sm:mt-0 border-t sm:border-0 border-gray-100 pt-4 sm:pt-0 w-full sm:w-auto">
                        
                        <a href="<?php echo e(route('orders.show', $pesanan->id)); ?>" class="flex-1 sm:flex-none w-full sm:w-auto text-center px-4 py-2 rounded-lg border border-gray-300 text-gray-700 text-sm font-bold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                            <i data-lucide="eye" class="w-4 h-4"></i> Detail
                        </a>

                        
                        <div class="flex gap-2 w-full sm:w-auto">
                            
                            <?php if($pesanan->status == 'completed' && $pesanan->reviews->isEmpty()): ?>
                                <a href="<?php echo e(route('reviews.create', $pesanan->id)); ?>" class="flex-1 sm:flex-none w-full sm:w-auto text-center px-4 py-2 rounded-lg bg-yellow-400 hover:bg-yellow-500 text-white text-sm font-bold transition flex items-center justify-center gap-2 shadow-sm">
                                    <i data-lucide="star" class="w-4 h-4"></i> Ulas
                                </a>
                            <?php elseif($pesanan->status == 'completed' && $pesanan->reviews->isNotEmpty()): ?>
                                <span class="flex-1 sm:flex-none w-full sm:w-auto text-center px-3 py-2 text-xs text-gray-400 font-medium flex items-center justify-center gap-1 border border-transparent">
                                    <i data-lucide="check" class="w-3 h-3"></i> Diulas
                                </span>
                            <?php endif; ?>

                            
                            <?php if($pesanan->status == 'completed' || $pesanan->status == 'cancelled'): ?>
                                <form action="<?php echo e(route('orders.reorder', $pesanan->id)); ?>" method="POST" class="flex-1 sm:flex-none w-full sm:w-auto">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="w-full px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-bold transition flex items-center justify-center gap-2 shadow-sm">
                                        <i data-lucide="rotate-cw" class="w-4 h-4"></i> Reorder
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
                <div class="flex flex-col items-center justify-center py-16 text-center bg-white rounded-3xl border border-dashed border-gray-300">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <i data-lucide="history" class="w-10 h-10 text-gray-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-1">Belum Ada Riwayat</h3>
                    <p class="text-gray-500 mb-6 text-sm">Kamu belum pernah memesan apapun. Yuk pesan sekarang!</p>
                    <a href="<?php echo e(route('dashboard')); ?>" class="px-6 py-2.5 bg-[#E3002B] text-white font-bold rounded-full shadow-lg hover:bg-red-700 transition">
                        Mulai Pesan
                    </a>
                </div>
            <?php endif; ?>
        </div>

        
        <div class="mt-8">
            <?php echo e($pesanans->links()); ?>

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
<?php endif; ?><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/my-orders.blade.php ENDPATH**/ ?>