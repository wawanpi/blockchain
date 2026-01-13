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
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-black text-2xl text-gray-800 tracking-tight flex items-center gap-2">
                    Dashboard <span class="text-[#D40000]">Overview</span>
                </h2>
                <p class="text-sm text-gray-500 mt-1">Pantau performa bisnis Burjo Minang secara real-time.</p>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center gap-2 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                    <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                    <span class="text-xs font-bold text-gray-600 uppercase tracking-wide">Live Data</span>
                </div>
                <div class="text-sm font-medium text-gray-600 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100 flex items-center gap-2">
                    <i data-lucide="calendar" class="w-4 h-4 text-[#D40000]"></i>
                    <?php echo e(now()->format('d M Y')); ?>

                </div>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-8 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-red-100 text-[#D40000] rounded-2xl">
                                <i data-lucide="wallet" class="w-6 h-6"></i>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Pendapatan Hari Ini</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1">Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></h3>
                    </div>
                </div>

                
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-50 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-yellow-100 text-yellow-700 rounded-2xl">
                                <i data-lucide="shopping-cart" class="w-6 h-6"></i>
                            </div>
                            <?php if($jumlahPesananBaru > 0): ?>
                                <span class="flex items-center text-xs font-bold text-white bg-red-500 px-2 py-1 rounded-lg animate-pulse shadow-sm shadow-red-200">
                                    New
                                </span>
                            <?php endif; ?>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Pesanan Baru</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1"><?php echo e($jumlahPesananBaru); ?></h3>
                        <p class="text-xs text-gray-400 mt-1">Perlu konfirmasi segera</p>
                    </div>
                </div>

                
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-blue-100 text-blue-600 rounded-2xl">
                                <i data-lucide="package-check" class="w-6 h-6"></i>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Total Porsi Terjual</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1"><?php echo e($totalUnitTerjual); ?> <span class="text-sm font-normal text-gray-400">Porsi</span></h3>
                    </div>
                </div>

                
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-lg transition-all duration-300">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-full -mr-10 -mt-10 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-purple-100 text-purple-600 rounded-2xl">
                                <i data-lucide="users" class="w-6 h-6"></i>
                            </div>
                        </div>
                        <p class="text-sm font-medium text-gray-500">Pengguna Baru</p>
                        <h3 class="text-2xl font-black text-gray-800 mt-1"><?php echo e($jumlahPenggunaBaru); ?></h3>
                    </div>
                </div>
            </div>
            
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                
                <div class="lg:col-span-2 bg-white shadow-sm rounded-3xl border border-gray-100 p-8">
                    <div class="flex justify-between items-center mb-8">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                                <i data-lucide="bar-chart-2" class="w-5 h-5 text-gray-400"></i>
                                Stok Menipis
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Monitoring real-time ketersediaan menu harian</p>
                        </div>
                        <div class="flex items-center gap-2 bg-red-50 px-3 py-1.5 rounded-lg border border-red-100">
                            <div class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></div>
                            <span class="text-xs font-bold text-red-700">Perlu Restock</span>
                        </div>
                    </div>
                    <div class="relative h-80 w-full">
                        <canvas id="jumlahChart"></canvas>
                    </div>
                </div>

                
                <div class="bg-white shadow-sm rounded-3xl border border-gray-100 flex flex-col h-full overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/30">
                        <h3 class="text-lg font-bold text-gray-800">Menu Segera Habis</h3>
                        <p class="text-sm text-gray-500">Prioritas restock hari ini</p>
                    </div>
                    
                    <div class="flex-1 overflow-y-auto max-h-[400px] p-4">
                        <div class="space-y-3">
                            <?php $__empty_1 = true; $__currentLoopData = $menuHampirHabis->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-white border border-gray-100 hover:border-red-100 hover:shadow-sm transition-all group">
                                    <div class="flex items-center gap-4">
                                        
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-lg
                                            <?php echo e(strtolower($item->menu->kategori) == 'makanan' ? 'bg-orange-100 text-orange-600' : 'bg-blue-100 text-blue-600'); ?>">
                                            <?php echo e(substr($item->menu->namaMenu, 0, 1)); ?>

                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-[#D40000] transition-colors"><?php echo e($item->menu->namaMenu); ?></h4>
                                            <p class="text-xs text-gray-500"><?php echo e($item->menu->kategori ?? '-'); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wide">Sisa</p>
                                        <p class="text-xl font-black <?php echo e($item->jumlah_saat_ini <= 5 ? 'text-[#D40000]' : 'text-yellow-500'); ?>">
                                            <?php echo e($item->jumlah_saat_ini); ?>

                                        </p>
                                    </div>
                                    
                                    <a href="<?php echo e(route('admin.menus.editKuota', $item->menu->id)); ?>" 
                                       class="ml-2 p-2 rounded-lg bg-gray-50 text-gray-400 hover:bg-[#D40000] hover:text-white transition-colors"
                                       title="Tambah Kuota">
                                        <i data-lucide="plus" class="w-5 h-5"></i>
                                    </a>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="flex flex-col items-center justify-center h-64 text-center p-6">
                                    <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center text-green-500 mb-4 animate-bounce">
                                        <i data-lucide="check-circle" class="w-8 h-8"></i>
                                    </div>
                                    <p class="text-base font-bold text-gray-800">Stok Aman!</p>
                                    <p class="text-sm text-gray-500 mt-1">Tidak ada menu yang menipis saat ini.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        <a href="<?php echo e(route('admin.menus.index')); ?>" class="flex items-center justify-center gap-2 w-full py-3 text-sm font-bold text-gray-600 hover:text-[#D40000] bg-white rounded-xl border border-gray-200 hover:border-red-100 transition-all shadow-sm">
                            Lihat Semua Menu <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <?php $__env->slot('scripts', null, []); ?> 
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                lucide.createIcons();

                const chartData = <?php echo json_encode($menuHampirHabis, 15, 512) ?>;
                const labels = chartData.length 
                    ? chartData.map(item => item.menu ? item.menu.namaMenu : 'Item Terhapus') 
                    : ['Belum ada data'];
                
                const data = chartData.length 
                    ? chartData.map(item => item.jumlah_saat_ini) 
                    : [0];
                
                // Palette Warna Modern
                const backgroundColors = data.map(val => {
                    if (val <= 5) return '#EF4444'; // Red-500
                    if (val <= 10) return '#F59E0B'; // Amber-500
                    return '#10B981'; // Emerald-500
                });

                const ctx = document.getElementById('jumlahChart').getContext('2d');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels, 
                        datasets: [{
                            label: 'Sisa Porsi',
                            data: data, 
                            backgroundColor: backgroundColors,
                            borderRadius: 8, // Bar lebih bulat
                            borderSkipped: false,
                            barThickness: 40,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#1F2937',
                                titleColor: '#F3F4F6',
                                bodyColor: '#F3F4F6',
                                padding: 12,
                                cornerRadius: 8,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                suggestedMax: 15,
                                grid: {
                                    color: '#F3F4F6',
                                    borderDash: [5, 5]
                                },
                                ticks: {
                                    font: { family: "'Inter', sans-serif", size: 11 },
                                    color: '#6B7280'
                                },
                                border: { display: false }
                            },
                            x: {
                                grid: { display: false },
                                ticks: {
                                    font: { family: "'Inter', sans-serif", size: 11, weight: 'bold' },
                                    color: '#374151'
                                },
                                border: { display: false }
                            }
                        }
                    }
                });
            });
        </script>
     <?php $__env->endSlot(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>