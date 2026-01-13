<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <style>
        /* Override autofill browser */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px white inset !important;
            -webkit-text-fill-color: #1f2937 !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="w-full min-h-screen flex flex-col lg:flex-row relative overflow-hidden">

        <div class="relative w-full lg:w-[45%] bg-[#990000] text-white flex flex-col justify-center items-center p-8 lg:p-12 z-10">
            
            <div class="absolute inset-0 bg-gradient-to-br from-[#b30000] to-[#660000] z-0"></div>

            <div class="relative z-30 flex flex-col items-center text-center mb-16 lg:mb-0 lg:pr-16">
                <div class="bg-white rounded-full p-2 mb-6 shadow-xl w-40 h-40 flex items-center justify-center transform hover:scale-105 transition duration-500 overflow-hidden border-4 border-red-900/10">
                    <img src="<?php echo e(asset('img/Burmin_logo.jpg')); ?>" alt="Logo Burjo Minang" class="w-full h-full object-cover rounded-full">
                </div>
    
                <h1 class="text-4xl lg:text-5xl font-extrabold tracking-wider mb-3 drop-shadow-md whitespace-nowrap">
                    BURJO MINANG
                </h1>
                
                <p class="text-base text-yellow-400 font-medium tracking-wide opacity-90 px-4">
                    Cita rasa otentik dalam setiap sajian.
                </p>
            </div>

            <div class="hidden lg:block absolute top-0 right-[-1px] h-full w-28 z-20 pointer-events-none text-white">
                 <svg viewBox="0 0 100 800" preserveAspectRatio="none" class="h-full w-full fill-current">
                    <path d="M100,0 H0 
                             C20,150 60,250 30,400 
                             C0,550 60,680 20,800 
                             H100 Z"></path>
                </svg>
            </div>
            
            <div class="absolute bottom-[-1px] left-0 w-full lg:hidden z-20 leading-[0] text-white">
                <svg viewBox="0 0 1440 320" class="w-full h-auto fill-current">
                    <path d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,208C1248,192,1344,192,1392,192L1440,192L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
                </svg>
            </div>
        </div>

        <div class="w-full lg:w-[55%] bg-white flex flex-col justify-center relative z-0 px-8 sm:px-12 lg:px-24 py-12">
            
            <div class="w-full max-w-md mx-auto">
                <h2 class="text-4xl font-bold text-gray-800 mb-2 text-center lg:text-left">Masuk Akun</h2>
                <p class="text-gray-400 mb-12 text-sm text-center lg:text-left">Selamat datang kembali! Silakan login data Anda.</p>

                <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-6">
                    <?php echo csrf_field(); ?>

                    <div class="relative group">
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                            class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-200 focus:border-red-600 focus:ring-0 px-0 py-3 bg-transparent text-gray-900 placeholder-gray-300 transition-colors text-lg"
                            value="muhaguskurniawan@gmail.com">
                        
                        <div class="absolute right-0 bottom-4 text-red-500">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="relative group mt-8">
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full border-b-2 border-t-0 border-l-0 border-r-0 border-gray-200 focus:border-red-600 focus:ring-0 px-0 py-3 bg-transparent text-gray-900 placeholder-gray-300 transition-colors text-lg"
                            placeholder="••••••••">
                        
                        <div class="absolute right-0 bottom-4 text-gray-300">
                             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('password'),'class' => 'mt-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('password')),'class' => 'mt-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                    </div>

                    <div class="flex items-center justify-between mt-8">
                        <label class="flex items-center cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500 h-4 w-4" name="remember">
                            <span class="ml-2 text-sm text-gray-500">Ingat saya</span>
                        </label>
                        <div class="text-sm">
                            <span class="text-gray-400">Setuju dengan</span> 
                            <a href="#" class="text-red-600 font-bold hover:underline">Ketentuan & Syarat</a>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mt-10">
                        <button type="submit" class="flex-1 px-6 py-3 bg-[#c70024] hover:bg-[#a3001e] text-white rounded-full font-bold shadow-lg hover:shadow-red-500/30 hover:-translate-y-1 transition-all duration-300 text-base">
                            <?php echo e(__('Masuk')); ?>

                        </button>
                        
                        <?php if(Route::has('register')): ?>
                            <a href="<?php echo e(route('register')); ?>" class="flex-1 px-6 py-3 bg-white border border-gray-200 text-gray-600 rounded-full font-bold text-center shadow-md hover:shadow-lg hover:bg-gray-50 hover:text-gray-900 hover:-translate-y-1 transition-all duration-300 text-base">
                                Daftar
                            </a>
                        <?php endif; ?>
                    </div>
                     
                    <?php if(Route::has('password.request')): ?>
                        <div class="mt-8 w-full text-center">
                            <a class="text-sm text-gray-400 hover:text-red-600 transition-colors" href="<?php echo e(route('password.request')); ?>">
                                <?php echo e(__('Lupa password anda?')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                </form>

                <div class="mt-12 text-xs text-gray-400 text-center">
                    &copy; 2025 Burjo Minang. All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH D:\Kuliah\S7\capstonne\CapstoneProject\resources\views/auth/login.blade.php ENDPATH**/ ?>