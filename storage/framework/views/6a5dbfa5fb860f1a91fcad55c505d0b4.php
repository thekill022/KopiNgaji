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
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-map-location-dot text-indigo-200"></i>
                <?php echo e(__('Zona Pengiriman')); ?>

            </h2>
            <a href="<?php echo e(route('seller.shipping-zones.create')); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg hover:bg-indigo-50 transition">
                <i class="fa-solid fa-plus"></i> Tambah Zona
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <?php if($shippingZones->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nama Zona</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ongkir</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Area Cakupan</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <?php $__currentLoopData = $shippingZones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900 dark:text-gray-100"><?php echo e($zone->name); ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 dark:text-gray-300">Rp <?php echo e(number_format($zone->cost, 0, ',', '.')); ?></td>
                                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                                <div class="flex flex-wrap gap-1">
                                                    <?php $__currentLoopData = $zone->areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="inline-block px-2 py-1 bg-indigo-50 text-indigo-700 text-xs rounded">
                                                            <?php echo e($area->district->name ?? $area->area_name); ?>

                                                        </span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="<?php echo e(route('seller.shipping-zones.edit', $zone)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                                <form action="<?php echo e(route('seller.shipping-zones.destroy', $zone)); ?>" method="POST" class="inline" onsubmit="return confirm('Hapus zona ini?')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            <?php echo e($shippingZones->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <div class="text-gray-400 text-5xl mb-4"><i class="fa-solid fa-map"></i></div>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada zona pengiriman.</p>
                            <a href="<?php echo e(route('seller.shipping-zones.create')); ?>" class="inline-block mt-4 text-indigo-600 hover:underline font-medium">Buat zona pertama</a>
                        </div>
                    <?php endif; ?>
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\seller\shipping-zones\index.blade.php ENDPATH**/ ?>