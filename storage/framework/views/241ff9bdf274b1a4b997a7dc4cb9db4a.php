<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'KopiNgaji')); ?> - Seller</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body class="font-sans antialiased text-slate-800 bg-slate-50 selection:bg-indigo-500 selection:text-white">
    <div class="min-h-screen bg-[#f8fafc] flex flex-col">
        <!-- Main Navigation for Seller -->
        <?php echo $__env->make('layouts.seller-navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Page Heading w/ Enhanced Style -->
        <?php if(isset($header)): ?>
            <header class="bg-indigo-600 text-white shadow-md sticky top-0 z-30">
                <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

         <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-lg shadow-sm flex items-center shadow-[0_4px_15px_-5px_#10b98150] transition-all transform hover:-translate-y-1">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-xl mr-3"></i>
                    <p class="font-medium"><?php echo e(session('success')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-sm flex items-center shadow-[0_4px_15px_-5px_#ef444450] transition-all transform hover:-translate-y-1">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-xl mr-3"></i>
                    <p class="font-medium"><?php echo e(session('error')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('warning')): ?>
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-amber-50 border-l-4 border-amber-500 text-amber-800 p-4 rounded-lg shadow-sm flex items-center shadow-[0_4px_15px_-5px_#f59e0b50] transition-all transform hover:-translate-y-1">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 text-xl mr-3"></i>
                    <p class="font-medium"><?php echo e(session('warning')); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 mt-6">
                <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-sm">
                    <div class="flex items-center mb-2">
                        <i class="fa-solid fa-circle-exclamation text-red-500 text-xl mr-3"></i>
                        <p class="font-bold">Terdapat kesalahan pada input Anda:</p>
                    </div>
                    <ul class="list-disc list-inside text-sm space-y-1 ml-8">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <!-- Main Content -->
        <main class="flex-grow w-full relative z-10 pb-12 mt-4">
            <?php echo e($slot); ?>

        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200 mt-auto py-6 text-center text-slate-500 text-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <i class="fa-solid fa-mug-hot text-indigo-500 text-xl"></i>
                    <span class="font-semibold text-slate-700 text-lg">KopiNgaji <span class="text-indigo-600 text-sm ml-1">Seller</span></span>
                </div>
                <div>
                     &copy; <?php echo e(date('Y')); ?> KopiNgaji Platform. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views/layouts/seller.blade.php ENDPATH**/ ?>