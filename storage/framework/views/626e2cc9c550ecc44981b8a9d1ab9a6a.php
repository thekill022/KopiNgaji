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
                <i class="fa-solid fa-receipt text-indigo-200"></i>
                Pesanan #<?php echo e($order->id); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Order Info & Status -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Pesanan</h3>
                        <div class="mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                            <p>Tanggal: <span class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->created_at->format('d M Y, H:i')); ?></span></p>
                            <p>Metode Pembayaran: <span class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->payment_method ?? '-'); ?></span></p>
                        </div>
                    </div>
                    <div class="text-right">
                        <?php if($order->status === 'COMPLETED'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Completed</span>
                        <?php elseif($order->status === 'PAID'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Paid</span>
                        <?php elseif($order->status === 'PENDING'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                        <?php elseif($order->status === 'REFUNDED'): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200">Refunded</span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Cancelled</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Buyer Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Informasi Pembeli</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Nama</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->buyer->name ?? '-'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">WhatsApp</p>
                        <?php if($order->whatsapp): ?>
                            <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $order->whatsapp)); ?>" target="_blank"
                               class="font-medium text-green-600 hover:underline"><?php echo e($order->whatsapp); ?></a>
                        <?php else: ?>
                            <p class="text-gray-900 dark:text-gray-100">-</p>
                        <?php endif; ?>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Email</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100"><?php echo e($order->buyer->email ?? '-'); ?></p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 pb-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Daftar Item</h3>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase w-20">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100"><?php echo e($item->product->name ?? 'Produk dihapus'); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center"><?php echo e($item->quantity); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-right">Rp <?php echo e(number_format($item->price, 0, ',', '.')); ?></td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 text-right">Rp <?php echo e(number_format($item->price * $item->quantity, 0, ',', '.')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <!-- Financial Summary -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                    <div class="max-w-xs ml-auto space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                            <span class="text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($order->subtotal_amount, 0, ',', '.')); ?></span>
                        </div>
                        <?php if($order->discount_amount > 0): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Diskon</span>
                                <span class="text-red-500">- Rp <?php echo e(number_format($order->discount_amount, 0, ',', '.')); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Platform Fee</span>
                            <span class="text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($order->platform_fee_amount, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700 font-semibold">
                            <span class="text-gray-900 dark:text-gray-100">Total</span>
                            <span class="text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between text-green-600 font-medium">
                            <span>Pendapatan Bersih</span>
                            <span>Rp <?php echo e(number_format($order->net_amount, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Refund History -->
            <?php if($order->refunds->count() > 0): ?>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Riwayat Refund</h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $order->refunds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refund): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($refund->amount, 0, ',', '.')); ?></p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><?php echo e($refund->reason); ?></p>
                                    </div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-medium
                                        <?php echo e($refund->status === 'APPROVED' ? 'bg-green-100 text-green-800' : ($refund->status === 'REJECTED' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800')); ?>">
                                        <?php echo e($refund->status); ?>

                                    </span>
                                </div>
                                <?php if($refund->refunded_at): ?>
                                    <p class="text-xs text-gray-400 mt-2">Diproses pada <?php echo e($refund->refunded_at->format('d M Y, H:i')); ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Action Buttons -->
            <?php if(in_array($order->status, ['PENDING', 'PAID'])): ?>
                <?php
                    $canNotifyComplete = $order->status === 'PAID' || ($order->status === 'PENDING' && $order->payment_method === 'CASH');
                    $canCancel = $order->payment_method === 'CASH' && $order->status === 'PENDING';
                ?>
                
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi Pesanan</h3>
                    <div class="flex flex-wrap gap-3">
                        <?php if(request('scanned') === 'true' && $canNotifyComplete): ?>
                            <form method="POST" action="<?php echo e(route('seller.orders.update-status', $order)); ?>" id="qr-complete-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="COMPLETED">
                                <input type="hidden" name="source" value="qr">
                                <button type="button" onclick="document.getElementById('confirm-qr-complete-modal').classList.remove('hidden')"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider hover:bg-green-700 transition shadow-sm shadow-green-200">
                                    <i class="fa-solid fa-circle-check"></i> Selesaikan Pesanan
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if($canNotifyComplete): ?>
                            <form method="POST" action="<?php echo e(route('seller.orders.notify-complete', $order)); ?>" id="notify-complete-form">
                                <?php echo csrf_field(); ?>
                                <button type="button" onclick="document.getElementById('confirm-notify-complete-modal').classList.remove('hidden')"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider hover:bg-blue-700 transition shadow-sm shadow-blue-200">
                                    <i class="fa-solid fa-paper-plane"></i> Kirim Notifikasi Selesai
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if($canCancel): ?>
                            <form method="POST" action="<?php echo e(route('seller.orders.update-status', $order)); ?>" id="cancel-form">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <input type="hidden" name="status" value="CANCELLED">
                                <button type="button" onclick="document.getElementById('confirm-cancel-modal').classList.remove('hidden')"
                                    class="inline-flex items-center gap-2 px-6 py-3 bg-red-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider hover:bg-red-700 transition shadow-sm shadow-red-200">
                                    <i class="fa-solid fa-circle-xmark"></i> Batalkan Pesanan
                                </button>
                            </form>
                        <?php endif; ?>

                        <?php if(in_array($order->status, ['PAID', 'COMPLETED'])): ?>
                            <button type="button" onclick="document.getElementById('refund-modal').classList.remove('hidden')"
                                class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wider hover:bg-purple-700 transition shadow-sm shadow-purple-200">
                                <i class="fa-solid fa-rotate-left"></i> Proses Refund
                            </button>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Confirm Notify Complete Modal -->
                <?php if($canNotifyComplete): ?>
                <div id="confirm-notify-complete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-sm w-full mx-4 p-6">
                        <div class="text-center">
                            <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-paper-plane text-blue-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Kirim Notifikasi Selesai?</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Pembeli akan menerima notifikasi untuk menyelesaikan pesanan #<?php echo e($order->id); ?>.</p>
                            <div class="flex gap-3 justify-center">
                                <button onclick="document.getElementById('confirm-notify-complete-modal').classList.add('hidden')"
                                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-300 font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Batal
                                </button>
                                <button onclick="document.getElementById('notify-complete-form').submit()"
                                    class="px-5 py-2.5 rounded-lg bg-blue-600 text-white font-bold text-sm hover:bg-blue-700 transition">
                                    Ya, Kirim
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Confirm QR Complete Modal -->
                <?php if(request('scanned') === 'true' && $canNotifyComplete): ?>
                <div id="confirm-qr-complete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-sm w-full mx-4 p-6">
                        <div class="text-center">
                            <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-circle-check text-green-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Selesaikan Pesanan?</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Pesanan #<?php echo e($order->id); ?> akan diselesaikan setelah scan QR.</p>
                            <div class="flex gap-3 justify-center">
                                <button onclick="document.getElementById('confirm-qr-complete-modal').classList.add('hidden')"
                                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-300 font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Batal
                                </button>
                                <button onclick="document.getElementById('qr-complete-form').submit()"
                                    class="px-5 py-2.5 rounded-lg bg-green-600 text-white font-bold text-sm hover:bg-green-700 transition">
                                    Ya, Selesai
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Confirm Cancel Modal -->
                <?php if($canCancel): ?>
                <div id="confirm-cancel-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-sm w-full mx-4 p-6">
                        <div class="text-center">
                            <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-circle-xmark text-red-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-2">Batalkan Pesanan?</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Pesanan #<?php echo e($order->id); ?> akan dibatalkan. Tindakan ini tidak dapat dibatalkan.</p>
                            <div class="flex gap-3 justify-center">
                                <button onclick="document.getElementById('confirm-cancel-modal').classList.add('hidden')"
                                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-300 font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Kembali
                                </button>
                                <button onclick="document.getElementById('cancel-form').submit()"
                                    class="px-5 py-2.5 rounded-lg bg-red-600 text-white font-bold text-sm hover:bg-red-700 transition">
                                    Ya, Batalkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Refund Modal -->
                <?php if(in_array($order->status, ['PAID', 'COMPLETED'])): ?>
                <div id="refund-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl max-w-md w-full mx-4 p-6">
                        <div class="text-center mb-4">
                            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-rotate-left text-purple-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100">Proses Refund</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                <?php if($order->payment_method === 'CASH'): ?>
                                    Refund tunai akan langsung diproses dan stok dikembalikan.
                                <?php else: ?>
                                    Refund non-tunai akan diajukan ke Admin untuk diproses manual via DOKU.
                                <?php endif; ?>
                            </p>
                        </div>
                        <form method="POST" action="<?php echo e(route('seller.orders.refund', $order)); ?>" id="refund-form">
                            <?php echo csrf_field(); ?>
                            <div class="mb-4 text-left">
                                <label for="refund-amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Jumlah Refund (Rp)</label>
                                <input type="number" name="amount" id="refund-amount" step="0.01" min="1" max="<?php echo e($order->net_amount); ?>" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 focus:ring-purple-500">
                                <p class="text-xs text-gray-400 mt-1">Maksimal Rp <?php echo e(number_format($order->net_amount, 0, ',', '.')); ?></p>
                            </div>
                            <div class="mb-6 text-left">
                                <label for="refund-reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Alasan Refund</label>
                                <textarea name="reason" id="refund-reason" rows="3" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-purple-500 focus:ring-purple-500"></textarea>
                            </div>
                            <div class="flex gap-3 justify-center">
                                <button type="button" onclick="document.getElementById('refund-modal').classList.add('hidden')"
                                    class="px-5 py-2.5 rounded-lg border border-gray-300 text-gray-700 dark:text-gray-300 font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 rounded-lg bg-purple-600 text-white font-bold text-sm hover:bg-purple-700 transition">
                                    Ajukan Refund
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?>
            <?php endif; ?>
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views/seller/orders/show.blade.php ENDPATH**/ ?>