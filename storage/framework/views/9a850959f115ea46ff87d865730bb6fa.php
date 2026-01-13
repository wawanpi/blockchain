

<?php if(auth()->guard()->check()): ?>
    <?php if(Auth::user()->hasRole('admin')): ?>
        
        <?php echo $__env->make('layouts.navigation-admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php else: ?>
        
        <?php echo $__env->make('layouts.navigation-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>
<?php else: ?>
    
    <?php echo $__env->make('layouts.navigation-user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/layouts/navigation.blade.php ENDPATH**/ ?>