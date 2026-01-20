<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan - <?php echo e($filterLabel); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; margin: 0; }
            .print-break { page-break-inside: avoid; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-8 print:bg-white print:p-0">

    
    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="<?php echo e(route('admin.transaksi.index', request()->query())); ?>" class="text-sm font-semibold text-gray-600 hover:text-gray-900 flex items-center gap-2">
            &larr; Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="bg-gray-900 text-white px-5 py-2 rounded-lg font-bold text-sm hover:bg-black transition shadow-lg flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
            Cetak PDF
        </button>
    </div>

    
    <div class="max-w-4xl mx-auto bg-white p-10 rounded-xl shadow-sm print:shadow-none print:w-full print:max-w-none">
        
        
        <div class="border-b-2 border-gray-800 pb-6 mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Burjo Minang</h1>
                <p class="text-sm text-gray-500 mt-1">Jl. Bunga, Geblagan, Bantul, DIY</p>
                <p class="text-sm text-gray-500">Telp: 0812-3456-7890 | Email: admin@burjominang.com</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-800">LAPORAN PENDAPATAN</h2>
                <p class="text-sm text-gray-500 mt-1">Periode: <span class="font-semibold text-gray-900"><?php echo e($filterLabel); ?></span></p>
                <p class="text-xs text-gray-400 mt-1">Dicetak pada: <?php echo e(now()->format('d M Y, H:i')); ?></p>
            </div>
        </div>

        
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-8 flex justify-between items-center print:bg-white print:border-gray-300">
            <div>
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Transaksi</p>
                <p class="text-2xl font-bold text-gray-900"><?php echo e($transaksis->count()); ?> <span class="text-sm font-medium text-gray-400">Pesanan</span></p>
            </div>
            <div class="text-right">
                <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Pendapatan</p>
                <p class="text-3xl font-black text-gray-900">Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></p>
            </div>
        </div>

        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b-2 border-gray-800">
                    <th class="py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">ID TRX</th>
                    <th class="py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                    <th class="py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Metode</th>
                    <th class="py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-right">Nominal</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700">
                <?php $__empty_1 = true; $__currentLoopData = $transaksis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaksi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b border-gray-200 print-break">
                        <td class="py-3 font-mono font-medium text-xs">#<?php echo e($transaksi->id); ?></td>
                        <td class="py-3">
                            <?php echo e(\Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y')); ?>

                            <span class="text-gray-400 text-xs ml-1"><?php echo e(\Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('H:i')); ?></span>
                        </td>
                        <td class="py-3 font-medium"><?php echo e($transaksi->pesanan->user->name ?? 'Guest / Offline'); ?></td>
                        <td class="py-3"><?php echo e($transaksi->metode_pembayaran); ?></td>
                        <td class="py-3 font-bold text-right">Rp <?php echo e(number_format($transaksi->total_bayar, 0, ',', '.')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 italic">Tidak ada data transaksi untuk periode ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            <tfoot>
                <tr class="border-t-2 border-gray-800">
                    <td colspan="4" class="py-4 text-right font-bold uppercase text-sm">Grand Total</td>
                    <td class="py-4 text-right font-black text-lg">Rp <?php echo e(number_format($totalPendapatan, 0, ',', '.')); ?></td>
                </tr>
            </tfoot>
        </table>

        
        <div class="mt-16 flex justify-end print-break">
            <div class="text-center w-48">
                <p class="text-sm text-gray-600 mb-16">Yogyakarta, <?php echo e(now()->format('d M Y')); ?></p>
                <p class="font-bold text-gray-900 border-b border-gray-400 pb-1">Administrator</p>
                <p class="text-xs text-gray-500 mt-1">Burjo Minang Management</p>
            </div>
        </div>

    </div>

    
    

</body>
</html><?php /**PATH D:\blocchain-burmin\resources\views/admin/transaksi/cetak.blade.php ENDPATH**/ ?>