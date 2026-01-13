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
            <div class="p-2 bg-blue-100 rounded-lg text-blue-700">
                
                <i data-lucide="shield-check" class="w-6 h-6"></i>
            </div>
            <div>
                <h2 class="font-black text-xl text-gray-800 leading-tight">
                    <?php echo e(__('Audit Blockchain')); ?>

                </h2>
                <p class="text-sm text-gray-500">Verifikasi integritas dan deteksi manipulasi data forensik.</p>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-3xl border border-gray-100">
                <div class="p-8">

                    
                    <?php if($status === 'AMAN'): ?>
                        
                        <div class="rounded-2xl bg-green-50 border border-green-100 p-6 text-center mb-8">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
                                <i data-lucide="check-circle" class="w-10 h-10"></i>
                            </div>
                            <h1 class="text-3xl font-black text-green-800 mb-2">DATA VALID & AMAN</h1>
                            <p class="text-green-700 font-medium">
                                Data di database 100% cocok dengan bukti digital yang tercatat di Blockchain.
                                <br>Tidak ada perubahan yang mencurigakan.
                            </p>
                        </div>
                    <?php else: ?>
                        
                        <div class="rounded-2xl bg-red-50 border border-red-100 p-6 text-center mb-8 animate-pulse">
                            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600">
                                <i data-lucide="alert-triangle" class="w-10 h-10"></i>
                            </div>
                            <h1 class="text-3xl font-black text-red-800 mb-2">PERINGATAN: DATA TIDAK VALID!</h1>
                            <p class="text-red-700 font-bold">
                                <?php echo e($pesan); ?>

                            </p>
                        </div>
                    <?php endif; ?>

                    
                    <?php if($status === 'BAHAYA' && isset($perubahan) && count($perubahan) > 0): ?>
                        <div class="bg-white border-2 border-red-500 rounded-xl overflow-hidden mb-8 shadow-xl">
                            <div class="bg-red-600 px-6 py-3 border-b border-red-700 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <h3 class="text-white font-bold text-lg flex items-center gap-2">
                                        <i data-lucide="search" class="w-5 h-5"></i> HASIL FORENSIK
                                    </h3>
                                    <span class="bg-red-800 text-white text-xs font-bold px-2 py-1 rounded border border-red-500">
                                        <?php echo e(count($perubahan)); ?> ITEM DIUBAH
                                    </span>
                                </div>

                                
                                <form action="<?php echo e(route('admin.transaksi.restore', $transaksi->id)); ?>" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin memulihkan data ini ke kondisi asli sesuai Snapshot Blockchain?');">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="bg-white text-red-700 hover:bg-red-50 text-xs font-black px-4 py-2 rounded-lg flex items-center gap-2 shadow-sm transition-all transform hover:scale-105">
                                        <i data-lucide="refresh-ccw" class="w-4 h-4"></i> PULIHKAN DATA
                                    </button>
                                </form>
                            </div>
                            
                            <div class="p-0">
                                <table class="w-full text-left">
                                    <thead class="bg-red-50 text-red-900 border-b border-red-100">
                                        <tr>
                                            <th class="px-6 py-3 text-xs font-bold uppercase w-1/3">Kolom Yang Dimanipulasi</th>
                                            <th class="px-6 py-3 text-xs font-bold uppercase text-green-700 w-1/3">Data Asli (Snapshot)</th>
                                            <th class="px-6 py-3 text-xs font-bold uppercase text-red-600 w-1/3">Data Palsu (Database)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-red-100">
                                        <?php $__currentLoopData = $perubahan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-red-50/50 transition-colors">
                                                <td class="px-6 py-4 font-bold text-gray-700 align-middle">
                                                    <?php echo e($item['kolom']); ?>

                                                </td>
                                                <td class="px-6 py-4 bg-green-50/30 align-middle">
                                                    <div class="flex items-center gap-2 text-green-700 font-mono font-bold">
                                                        <?php echo e($item['asli']); ?>

                                                        <i data-lucide="check" class="w-4 h-4"></i>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 bg-red-50/30 align-middle">
                                                    <div class="text-red-600 font-mono font-bold line-through decoration-2 decoration-red-400">
                                                        <?php echo e($item['palsu']); ?>

                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="bg-gray-50 px-6 py-3 text-xs text-gray-500 text-center border-t border-gray-100">
                                Sistem mendeteksi perbedaan ini dengan membandingkan data database saat ini melawan Snapshot Terenkripsi.
                            </div>
                        </div>
                    <?php endif; ?>

                    
                    <?php if(isset($snapshotValid) && !$snapshotValid): ?>
                        <div class="bg-red-600 text-white p-4 rounded-xl mb-6 shadow-lg text-center animate-bounce">
                            <div class="flex items-center justify-center gap-2 mb-1">
                                <i data-lucide="siren" class="w-6 h-6"></i>
                                <h3 class="font-bold text-lg">PERCOBAAN PENGHILANGAN JEJAK TERDETEKSI</h3>
                            </div>
                            <p>Pelaku mencoba mengubah Data Cadangan (Snapshot) agar sesuai dengan data palsu.</p>
                            <p class="text-sm mt-2 font-mono bg-red-700 inline-block px-2 py-1 rounded">System Security: Blockchain Hash Mismatch</p>
                        </div>
                    <?php endif; ?>

                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">ID Transaksi Internal</span>
                            <div class="text-xl font-bold text-gray-800 mt-1">TRX-<?php echo e($transaksi->id); ?></div>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Waktu Transaksi</span>
                            <div class="text-xl font-bold text-gray-800 mt-1">
                                <?php echo e(\Carbon\Carbon::parse($transaksi->created_at)->format('d M Y, H:i:s')); ?>

                            </div>
                        </div>
                    </div>

                    
                    <div class="space-y-4 mb-8">
                        <h3 class="font-bold text-gray-800 text-lg border-b pb-2">Detail Teknis Verifikasi (SHA-256)</h3>

                        
                        <div class="relative group">
                            <div class="flex justify-between items-end mb-1">
                                <label class="text-xs font-bold text-gray-500 uppercase">Hash Database (Kondisi Saat Ini)</label>
                                <?php if($status !== 'AMAN'): ?>
                                    <span class="text-xs font-bold text-red-600 bg-red-100 px-2 py-0.5 rounded">BERUBAH</span>
                                <?php endif; ?>
                            </div>
                            <div class="p-4 bg-gray-100 rounded-xl font-mono text-xs break-all text-gray-600 border <?php echo e($status !== 'AMAN' ? 'border-red-300 bg-red-50' : 'border-gray-200'); ?>">
                                <?php echo e($recalculatedHash); ?>

                            </div>
                        </div>

                        
                        <div class="relative group">
                            <div class="flex justify-between items-end mb-1">
                                <label class="text-xs font-bold text-gray-500 uppercase">Hash Tersimpan (Catatan Asli)</label>
                                <span class="text-xs font-bold text-blue-600 bg-blue-100 px-2 py-0.5 rounded">ORIGINAL</span>
                            </div>
                            <div class="p-4 bg-blue-50 rounded-xl font-mono text-xs break-all text-blue-800 border border-blue-200">
                                <?php echo e($transaksi->data_hash ?? 'BELUM TERCATAT KE BLOCKCHAIN'); ?>

                            </div>
                        </div>
                    </div>

                    
                    <div class="bg-gray-900 rounded-2xl p-6 text-white relative overflow-hidden">
                        
                        <div class="absolute top-0 right-0 p-4 opacity-10">
                            <i data-lucide="link" class="w-32 h-32"></i>
                        </div>

                        <h3 class="font-bold text-lg mb-4 relative z-10">Bukti Digital (Blockchain Receipt)</h3>
                        
                        <?php if($transaksi->tx_hash_blockchain): ?>
                            <div class="mb-4">
                                <label class="text-xs text-gray-400 block mb-1">Transaction Hash (Polygon Testnet)</label>
                                <div class="font-mono text-sm text-gray-300 break-all bg-gray-800 p-3 rounded-lg border border-gray-700">
                                    <?php echo e($transaksi->tx_hash_blockchain); ?>

                                </div>
                            </div>

                            <a href="https://amoy.polygonscan.com/tx/<?php echo e($transaksi->tx_hash_blockchain); ?>" 
                               target="_blank"
                               onclick="alert('PERHATIAN: Karena sedang dalam MODE DEMO/SIMULASI, link ini mungkin tidak menemukan transaksi di jaringan Polygon yang sesungguhnya. Namun format Hash sudah sesuai standar Ethereum.');"
                               class="inline-flex items-center justify-center gap-2 bg-[#8247E5] hover:bg-[#6e35d4] text-white px-5 py-3 rounded-xl font-bold transition-all w-full sm:w-auto relative z-10">
                                <i data-lucide="external-link" class="w-4 h-4"></i>
                                Cek Validitas di PolygonScan
                            </a>
                        <?php else: ?>
                            <div class="bg-yellow-500/20 border border-yellow-500/50 p-4 rounded-xl text-yellow-200 text-sm">
                                <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                                Transaksi ini belum memiliki bukti hash di Blockchain (Mungkin dibuat sebelum fitur ini aktif).
                            </div>
                        <?php endif; ?>
                    </div>

                    
                    <div class="mt-8 text-center">
                        <a href="<?php echo e(route('admin.transaksi.index')); ?>" class="text-gray-500 font-medium hover:text-gray-800 transition-colors inline-flex items-center gap-2">
                            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Riwayat Transaksi
                        </a>
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
<?php endif; ?><?php /**PATH D:\blocchain-burmin\resources\views/admin/transaksi/audit.blade.php ENDPATH**/ ?>