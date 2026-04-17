<?php if (isset($component)) { $__componentOriginala3086a5efa12cddd37a6951435b5e715 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala3086a5efa12cddd37a6951435b5e715 = $attributes; } ?>
<?php $component = App\View\Components\SellerLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seller-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SellerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('seller.orders.index')); ?>" class="text-indigo-200 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-qrcode text-indigo-200"></i>
                <?php echo e(__('Scan QR Pesanan')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col items-center">
                    
                    <div class="mb-6 text-center max-w-lg">
                        <i class="fa-solid fa-qrcode text-5xl text-indigo-500 mb-4"></i>
                        <h3 class="text-2xl font-bold mb-2">Scan QR Pembeli</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            Arahkan kamera ke QR Code yang ditunjukkan oleh pembeli. Jika pesanan sesuai dan valid, akan secara otomatis masuk ke halaman rincian pesanan dan Anda bisa menekan tombol "Selesaikan Pesanan".
                        </p>
                    </div>

                    <!-- Reader Container -->
                    <div id="reader" class="w-full max-w-sm rounded-2xl overflow-hidden border-4 border-indigo-100 dark:border-indigo-900 shadow-md"></div>
                    
                    <!-- Result/Status Indicator -->
                    <div id="scan-status" class="mt-8 text-center hidden">
                        <div class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-100 text-emerald-700 font-bold rounded-full animate-pulse">
                            <i class="fa-solid fa-circle-check"></i> Mengalihkan...
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Include html5-qrcode library via CDN -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html5QrCode = new Html5Qrcode("reader");
            const config = { fps: 10, qrbox: { width: 250, height: 250 } };
            
            html5QrCode.start(
                { facingMode: "environment" }, 
                config, 
                (decodedText, decodedResult) => {
                    // Stop scanning on success
                    html5QrCode.stop().then((ignore) => {
                        // Show success message
                        document.getElementById('scan-status').classList.remove('hidden');
                        
                        // We expect the decodedText to be the valid URL route for the seller order show page
                        // Ensure it's somewhat valid before redirecting
                        if (decodedText.startsWith('http://') || decodedText.startsWith('https://')) {
                            window.location.href = decodedText;
                        } else {
                            alert("QR Code tidak valid atau bukan berasal dari aplikasi ini!");
                            // restart
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    }).catch((err) => {
                        console.error('Failed to stop scanner', err);
                    });
                },
                (errorMessage) => {
                    // parse error, ignore mostly
                }
            ).catch((err) => {
                console.error("Camera access denied or no camera found.", err);
                const readerElement = document.getElementById('reader');
                readerElement.innerHTML = `
                    <div class="p-6 text-center text-red-500 bg-red-50 dark:bg-red-900/20">
                        <i class="fa-solid fa-camera-viewfinder text-3xl mb-2"></i>
                        <p class="font-bold">Akses Kamera Ditolak / Tidak Ditemukan</p>
                        <p class="text-xs mt-1 text-gray-500">Silakan izinkan akses kamera di browser Anda untuk menggunakan fitur ini.</p>
                    </div>
                `;
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala3086a5efa12cddd37a6951435b5e715)): ?>
<?php $attributes = $__attributesOriginala3086a5efa12cddd37a6951435b5e715; ?>
<?php unset($__attributesOriginala3086a5efa12cddd37a6951435b5e715); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala3086a5efa12cddd37a6951435b5e715)): ?>
<?php $component = $__componentOriginala3086a5efa12cddd37a6951435b5e715; ?>
<?php unset($__componentOriginala3086a5efa12cddd37a6951435b5e715); ?>
<?php endif; ?>
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\seller\orders\scan.blade.php ENDPATH**/ ?>