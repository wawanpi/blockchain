<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?></title>

        <script src="https://cdn.tailwindcss.com"></script>
        
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <style>
            .bg-minang-red { background-color: #E3002B; }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-white">        
        <?php echo e($slot); ?>

    </body>
</html><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/layouts/guest.blade.php ENDPATH**/ ?>