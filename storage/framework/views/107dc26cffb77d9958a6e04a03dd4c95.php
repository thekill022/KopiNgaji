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
        <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
            <i class="fa-solid fa-money-bill-transfer text-indigo-200"></i>
            <?php echo e(__('Penarikan Dana')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Balance Card -->
            <div class="bg-indigo-600 dark:bg-indigo-800 rounded-lg shadow-lg overflow-hidden flex flex-col md:flex-row items-center justify-between p-8 text-white relative">
                <div class="relative z-10 flex flex-col mb-6 md:mb-0">
                    <span class="text-indigo-200 uppercase tracking-widest text-sm font-semibold mb-1">Saldo Penarikan Tersedia</span>
                    <h3 class="text-4xl md:text-5xl font-bold font-mono">Rp <?php echo e(number_format($availableBalance, 0, ',', '.')); ?></h3>
                    <p class="text-indigo-200 text-sm mt-3 max-w-md">Saldo ini khusus berasal dari pesanan pembayaran <strong>Non-Tunai (Online)</strong> yang berstatus <strong>Completed</strong> dikurangi total penarikan. Minimum penarikan Rp 50.000.</p>
                </div>
                <div class="relative z-10">
                    <a href="<?php echo e(route('seller.withdrawals.create')); ?>" class="inline-block bg-white text-indigo-700 font-bold px-8 py-3 rounded-full hover:bg-gray-100 transition-colors shadow-sm hover:shadow">
                        <i class="fa-solid fa-money-bill-transfer mr-2"></i> Tarik Dana
                    </a>
                </div>
                <!-- decoration -->
                <div class="absolute right-0 top-0 opacity-10 pointer-events-none transform translate-x-1/4 -translate-y-1/4">
                    <i class="fa-solid fa-wallet text-[15rem]"></i>
                </div>
            </div>

            <!-- History Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">Riwayat Penarikan</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                        <thead class="bg-gray-50 dark:bg-gray-700 text-xs uppercase text-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-3">Tanggal Pengajuan</th>
                                <th scope="col" class="px-6 py-3">Tujuan Pengiriman</th>
                                <th scope="col" class="px-6 py-3 text-right">Nominal</th>
                                <th scope="col" class="px-6 py-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php echo e($withdrawal->created_at->format('d M Y')); ?>

                                        <div class="text-xs text-gray-400"><?php echo e($withdrawal->created_at->format('H:i')); ?></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($withdrawal->bank_name); ?></p>
                                        <p class="font-mono text-xs text-gray-500"><?php echo e($withdrawal->bank_account); ?></p>
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap font-medium text-gray-900 dark:text-gray-100">
                                        Rp <?php echo e(number_format($withdrawal->amount, 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <?php if($withdrawal->status === 'APPROVED'): ?>
                                            <span class="inline-flex items-center gap-1 bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300">
                                                <i class="fa-solid fa-check"></i> Disetujui
                                            </span>
                                        <?php elseif($withdrawal->status === 'REJECTED'): ?>
                                            <span class="inline-flex items-center gap-1 bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300">
                                                <i class="fa-solid fa-xmark"></i> Ditolak
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1 bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-yellow-900 dark:text-yellow-300">
                                                <i class="fa-solid fa-clock"></i> Pending
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <i class="fa-solid fa-money-bill-transfer text-4xl mb-4 text-gray-300 dark:text-gray-600"></i>
                                        <p>Belum ada riwayat penarikan dana.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if($withdrawals->hasPages()): ?>
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <?php echo e($withdrawals->links()); ?>

                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\seller\withdrawals\index.blade.php ENDPATH**/ ?>