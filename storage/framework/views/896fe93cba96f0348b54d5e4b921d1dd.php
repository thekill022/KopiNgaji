<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sesi Berakhir - <?php echo e(config('app.name', 'KopiNgaji')); ?></title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="max-w-md w-full text-center">
            <div class="w-20 h-20 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-clock-rotate-left text-amber-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 mb-2">Sesi Berakhir</h1>
            <p class="text-slate-600 mb-8 leading-relaxed">
                Halaman yang Anda akses memerlukan sesi yang aktif. Ini bisa terjadi karena Anda sudah logout, atau tidak aktif terlalu lama.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="<?php echo e(route('login')); ?>" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-md">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i> Masuk Kembali
                </a>
                <a href="<?php echo e(url('/')); ?>" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-slate-700 font-semibold rounded-xl border border-slate-200 hover:bg-slate-50 transition">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\errors\419.blade.php ENDPATH**/ ?>