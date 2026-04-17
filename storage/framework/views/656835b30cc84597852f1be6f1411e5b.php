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
            <i class="fa-solid fa-chart-line text-indigo-200"></i>
            <?php echo e(__('Laporan Keuangan')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Filter -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="GET" action="<?php echo e(route('seller.finance.index')); ?>" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-1 w-full">
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari Tanggal</label>
                        <input type="date" name="start_date" id="start_date" value="<?php echo e($startDate); ?>"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>
                    <div class="flex-1 w-full">
                        <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai Tanggal</label>
                        <input type="date" name="end_date" id="end_date" value="<?php echo e($endDate); ?>"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>
                    <div class="w-full sm:w-auto">
                        <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['type' => 'submit','class' => 'w-full justify-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full justify-center']); ?>
                            <i class="fa-solid fa-filter mr-2"></i> Filter
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Revenue -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                            <i class="fa-solid fa-sack-dollar"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Pendapatan</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($revenue, 0, ',', '.')); ?></p>
                </div>

                <!-- COGS -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Harga Pokok (COGS)</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($cogs, 0, ',', '.')); ?></p>
                </div>

                <!-- Refunds -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600">
                            <i class="fa-solid fa-rotate-left"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengembalian Dana</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($refunds, 0, ',', '.')); ?></p>
                </div>

                <!-- Net Profit -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-indigo-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Laba Bersih</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($netProfit, 0, ',', '.')); ?></p>
                </div>

                <!-- Withdrawals -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <i class="fa-solid fa-money-bill-transfer"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Total Penarikan</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($withdrawals, 0, ',', '.')); ?></p>
                </div>

                <!-- Available Balance -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-500">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                            <i class="fa-solid fa-vault"></i>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Saldo Tersedia (Real-time)</p>
                    </div>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($availableBalance, 0, ',', '.')); ?></p>
                </div>
            </div>

            <!-- Daily Cash Flow Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Arus Kas Harian</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <?php $__empty_1 = true; $__currentLoopData = $dailyRevenue; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <?php echo e(\Carbon\Carbon::parse($row->date)->format('d M Y')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100 text-right font-medium">
                                        Rp <?php echo e(number_format($row->total, 0, ',', '.')); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="2" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Tidak ada data transaksi pada periode ini.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\seller\finance\index.blade.php ENDPATH**/ ?>