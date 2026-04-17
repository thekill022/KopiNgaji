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
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-boxes-packing text-indigo-200"></i>
                <?php echo e(__('Pesanan')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 mb-6 gap-4">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">
                    Kelola Pesanan
                </h2>
                <a href="<?php echo e(route('seller.orders.scan')); ?>" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition-colors shadow-sm">
                    <i class="fa-solid fa-qrcode"></i> Scan QR Pembeli
                </a>
            </div>

            <!-- Status Tabs -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex flex-wrap border-b border-gray-200 dark:border-gray-700">
                    <a href="<?php echo e(route('seller.orders.index')); ?>"
                       class="px-5 py-3 text-sm font-medium border-b-2 transition-colors <?php echo e(!request('status') ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                        Semua <span class="ml-1 text-xs bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded-full"><?php echo e($statusCounts['all']); ?></span>
                    </a>
                    <a href="<?php echo e(route('seller.orders.index', ['status' => 'PENDING'])); ?>"
                       class="px-5 py-3 text-sm font-medium border-b-2 transition-colors <?php echo e(request('status') === 'PENDING' ? 'border-yellow-500 text-yellow-600' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                        Pending <span class="ml-1 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full"><?php echo e($statusCounts['PENDING']); ?></span>
                    </a>
                    <a href="<?php echo e(route('seller.orders.index', ['status' => 'PAID'])); ?>"
                       class="px-5 py-3 text-sm font-medium border-b-2 transition-colors <?php echo e(request('status') === 'PAID' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                        Paid <span class="ml-1 text-xs bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full"><?php echo e($statusCounts['PAID']); ?></span>
                    </a>
                    <a href="<?php echo e(route('seller.orders.index', ['status' => 'COMPLETED'])); ?>"
                       class="px-5 py-3 text-sm font-medium border-b-2 transition-colors <?php echo e(request('status') === 'COMPLETED' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                        Completed <span class="ml-1 text-xs bg-green-100 text-green-800 px-2 py-0.5 rounded-full"><?php echo e($statusCounts['COMPLETED']); ?></span>
                    </a>
                    <a href="<?php echo e(route('seller.orders.index', ['status' => 'CANCELLED'])); ?>"
                       class="px-5 py-3 text-sm font-medium border-b-2 transition-colors <?php echo e(request('status') === 'CANCELLED' ? 'border-red-500 text-red-600' : 'border-transparent text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200'); ?>">
                        Cancelled <span class="ml-1 text-xs bg-red-100 text-red-800 px-2 py-0.5 rounded-full"><?php echo e($statusCounts['CANCELLED']); ?></span>
                    </a>
                </div>

                <!-- Search -->
                <div class="p-4">
                    <form method="GET" action="<?php echo e(route('seller.orders.index')); ?>" id="order-search-form">
                        <?php if(request('status')): ?>
                            <input type="hidden" name="status" value="<?php echo e(request('status')); ?>">
                        <?php endif; ?>
                        <div class="relative">
                            <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['name' => 'search','id' => 'order-search','type' => 'text','class' => 'w-full pl-10','placeholder' => 'Cari nama pembeli...','value' => request('search'),'autocomplete' => 'off']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'search','id' => 'order-search','type' => 'text','class' => 'w-full pl-10','placeholder' => 'Cari nama pembeli...','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(request('search')),'autocomplete' => 'off']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                            <i class="fa-solid fa-search order-search-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <i class="fa-solid fa-spinner fa-spin order-search-spinner absolute left-3 top-1/2 -translate-y-1/2 text-indigo-500 hidden"></i>
                        </div>
                    </form>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    let debounceTimer;
                    const input = document.getElementById('order-search');
                    const form = document.getElementById('order-search-form');
                    const icon = form.querySelector('.order-search-icon');
                    const spinner = form.querySelector('.order-search-spinner');

                    input.addEventListener('input', function() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => {
                            icon.classList.add('hidden');
                            spinner.classList.remove('hidden');
                            form.submit();
                        }, 500);
                    });
                });
                </script>
            </div>

            <!-- Orders Table (Desktop) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hidden md:block">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Pembeli</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Items</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-28">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400 font-mono">#<?php echo e($order->id); ?></td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->buyer->name ?? '-'); ?></p>
                                    <?php if($order->whatsapp): ?>
                                        <p class="text-xs text-gray-500"><?php echo e($order->whatsapp); ?></p>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                                    <?php echo e($order->items->count()); ?> item
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?>

                                </td>
                                <td class="px-6 py-4 text-center">
                                    <?php if($order->status === 'COMPLETED'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Completed</span>
                                    <?php elseif($order->status === 'PAID'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Paid</span>
                                    <?php elseif($order->status === 'PENDING'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Cancelled</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($order->created_at->format('d M Y')); ?>

                                    <br><span class="text-xs"><?php echo e($order->created_at->format('H:i')); ?></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="<?php echo e(route('seller.orders.show', $order)); ?>" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-16 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Belum ada pesanan.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <?php if($orders->hasPages()): ?>
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <?php echo e($orders->links()); ?>

                    </div>
                <?php endif; ?>
            </div>

            <!-- Orders Cards (Mobile) -->
            <div class="md:hidden space-y-3">
                <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <a href="<?php echo e(route('seller.orders.show', $order)); ?>" class="block bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-2">
                            <div>
                                <span class="text-xs text-gray-500 font-mono">#<?php echo e($order->id); ?></span>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100"><?php echo e($order->buyer->name ?? '-'); ?></p>
                            </div>
                            <?php if($order->status === 'COMPLETED'): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Completed</span>
                            <?php elseif($order->status === 'PAID'): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Paid</span>
                            <?php elseif($order->status === 'PENDING'): ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelled</span>
                            <?php endif; ?>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="font-medium text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
                            <div class="flex items-center gap-3">
                                <span class="text-xs text-gray-500"><?php echo e($order->created_at->format('d M Y H:i')); ?></span>

                            </div>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-8 text-center">
                        <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada pesanan.</p>
                    </div>
                <?php endif; ?>

                <?php if($orders->hasPages()): ?>
                    <div class="mt-4"><?php echo e($orders->links()); ?></div>
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views/seller/orders/index.blade.php ENDPATH**/ ?>