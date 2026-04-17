<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-8">
            <i class="fa-solid fa-lock text-indigo-500 mr-2"></i> Pengiriman & Pembayaran
        </h1>

        <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Details -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Delivery Option -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <h2 class="text-xl font-bold text-slate-800 mb-4"><i class="fa-solid fa-truck-fast"></i> Metode Pengiriman</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="delivery_method" value="AMBIL_LOKASI" class="peer sr-only" checked onchange="toggleAddress(false)">
                                <div class="rounded-xl border-2 border-slate-200 p-4 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all text-center">
                                    <i class="fa-solid fa-store text-2xl text-slate-400 peer-checked:text-indigo-600 mb-2"></i>
                                    <div class="font-bold text-slate-800">Ambil di Lokasi Kopi Ngaji</div>
                                    <div class="text-xs text-slate-500 mt-1">Anda bisa datang dan mengambil pesanan langsung ke toko.</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="delivery_method" value="KIRIM_ALAMAT" class="peer sr-only" onchange="toggleAddress(true)">
                                <div class="rounded-xl border-2 border-slate-200 p-4 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all text-center">
                                    <i class="fa-solid fa-motorcycle text-2xl text-slate-400 peer-checked:text-indigo-600 mb-2"></i>
                                    <div class="font-bold text-slate-800">Kirim ke Alamat</div>
                                    <div class="text-xs text-slate-500 mt-1">Pesanan akan diantarkan ke alamat tujuan.</div>
                                </div>
                            </label>
                        </div>
                        
                        <!-- Address & Shipping Zone Field (hidden by default) -->
                        <div id="address-container" class="mt-6 hidden space-y-4">
                            <div>
                                <label for="shipping_zone_id" class="block text-sm font-medium text-slate-700 mb-2">Zona Pengiriman</label>
                                <select name="shipping_zone_id" id="shipping_zone_id" class="w-full rounded-xl border-slate-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="updateTotal()">
                                    <option value="">Pilih zona pengiriman</option>
                                    <?php $__currentLoopData = $shippingZones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($zone->id); ?>" data-cost="<?php echo e($zone->cost); ?>">
                                            <?php echo e($zone->name); ?> — Rp <?php echo e(number_format($zone->cost, 0, ',', '.')); ?>

                                            (<?php echo e($zone->areas->pluck('area_name')->implode(', ')); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['shipping_zone_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-slate-700 mb-2">Alamat Lengkap Pengiriman</label>
                                <textarea name="shipping_address" id="shipping_address" rows="3" class="w-full rounded-xl border-slate-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ketikkan alamat lengkap pengiriman Anda..."></textarea>
                                <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Option -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <h2 class="text-xl font-bold text-slate-800 mb-4"><i class="fa-solid fa-wallet"></i> Metode Pembayaran</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="CASH" class="peer sr-only" checked>
                                <div class="rounded-xl border-2 border-slate-200 p-4 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 transition-all text-center">
                                    <i class="fa-solid fa-money-bill-wave text-2xl text-slate-400 peer-checked:text-emerald-500 mb-2"></i>
                                    <div class="font-bold text-slate-800">Tunai (Bayar di Tempat)</div>
                                    <div class="text-xs text-slate-500 mt-1">Selesaikan pembayaran saat mengambil atau saat diantar.</div>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="payment_method" value="NON_CASH" class="peer sr-only">
                                <div class="rounded-xl border-2 border-slate-200 p-4 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all text-center">
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS6vAwQBTdaC7grL28G7kvTFbDYmMoN3HGlzA&s" alt="DOKU" class="h-6 mx-auto mb-2 grayscale peer-checked:grayscale-0 align-middle inline-block">
                                    <div class="font-bold text-slate-800">Non-Tunai (DokuPay)</div>
                                    <div class="text-xs text-slate-500 mt-1">Pembayaran aman dengan Virtual Account, QRIS, e-Wallet, dll.</div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- WhatsApp Number -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <h2 class="text-xl font-bold text-slate-800 mb-4"><i class="fa-brands fa-whatsapp"></i> Kontak (WhatsApp)</h2>
                        <p class="text-sm text-slate-500 mb-4">Nomor WhatsApp diperlukan untuk konfirmasi pesanan dari toko.</p>
                        <input type="tel" name="whatsapp" value="<?php echo e(old('whatsapp')); ?>" required inputmode="numeric" pattern="[0-9]*" class="w-full rounded-xl border-slate-200 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Contoh: 08123456789" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <?php $__errorArgs = ['whatsapp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <!-- Right Sidebar Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 sticky top-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-4">
                            Ringkasan Pesanan
                        </h3>
                        
                        <div class="space-y-4 mb-6 text-sm max-h-60 overflow-y-auto pr-2">
                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->product->umkm_id == $umkmId): ?>
                                    <div class="flex justify-between items-start gap-2 border-b border-slate-50 pb-2">
                                        <div>
                                            <p class="font-semibold text-slate-800"><?php echo e($item->product->name); ?></p>
                                            <p class="text-slate-500 text-xs"><?php echo e($item->quantity); ?> x Rp <?php echo e(number_format($item->product->price, 0, ',', '.')); ?></p>
                                        </div>
                                        <div class="font-medium text-slate-700">
                                            Rp <?php echo e(number_format($item->product->price * $item->quantity, 0, ',', '.')); ?>

                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        
                        <div class="border-t border-slate-200 pt-4 mb-2">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-slate-600">Subtotal</span>
                                <span class="font-medium text-slate-800">Rp <?php echo e(number_format($totalPrice, 0, ',', '.')); ?></span>
                            </div>
                            <div class="flex justify-between items-center mb-4" id="shipping-cost-row" style="display: none;">
                                <span class="text-slate-600">Ongkir</span>
                                <span class="font-medium text-slate-800" id="shipping-cost-display">Rp 0</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-800">Total Harga</span>
                                <span class="text-2xl font-black text-indigo-600" id="grand-total">Rp <?php echo e(number_format($totalPrice, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-center shadow-lg shadow-indigo-200 focus:ring-4 focus:ring-indigo-100 transition-all">
                            Selesaikan Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        const baseTotal = <?php echo e($totalPrice); ?>;

        function toggleAddress(show) {
            const container = document.getElementById('address-container');
            const textarea = document.getElementById('shipping_address');
            const zoneSelect = document.getElementById('shipping_zone_id');
            if (show) {
                container.classList.remove('hidden');
                textarea.setAttribute('required', 'required');
                zoneSelect.setAttribute('required', 'required');
            } else {
                container.classList.add('hidden');
                textarea.removeAttribute('required');
                textarea.value = '';
                zoneSelect.removeAttribute('required');
                zoneSelect.value = '';
                updateTotal();
            }
        }

        function formatRupiah(num) {
            return 'Rp ' + num.toLocaleString('id-ID');
        }

        function updateTotal() {
            const zoneSelect = document.getElementById('shipping_zone_id');
            const costRow = document.getElementById('shipping-cost-row');
            const costDisplay = document.getElementById('shipping-cost-display');
            const grandTotal = document.getElementById('grand-total');

            let shippingCost = 0;
            if (zoneSelect.value) {
                const option = zoneSelect.options[zoneSelect.selectedIndex];
                shippingCost = parseInt(option.getAttribute('data-cost')) || 0;
            }

            if (shippingCost > 0) {
                costRow.style.display = 'flex';
                costDisplay.textContent = formatRupiah(shippingCost);
            } else {
                costRow.style.display = 'none';
            }

            grandTotal.textContent = formatRupiah(baseTotal + shippingCost);
        }

        // Form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            document.querySelectorAll('.js-error').forEach(el => el.remove());
            let valid = true;
            function addError(el, msg) {
                const span = document.createElement('p');
                span.className = 'js-error text-red-500 text-sm mt-1';
                span.textContent = msg;
                el.parentElement.appendChild(span);
            }

            // WhatsApp
            const wa = document.querySelector('input[name="whatsapp"]');
            const waVal = wa.value.trim();
            if (!waVal) { addError(wa, 'Nomor WhatsApp wajib diisi.'); valid = false; }
            else if (!/^08\d{8,13}$/.test(waVal)) { addError(wa, 'Format nomor WhatsApp tidak valid. Contoh: 08123456789'); valid = false; }

            // Address & zone if KIRIM_ALAMAT
            const deliveryMethod = document.querySelector('input[name="delivery_method"]:checked');
            if (deliveryMethod && deliveryMethod.value === 'KIRIM_ALAMAT') {
                const address = document.getElementById('shipping_address');
                if (!address.value.trim()) { addError(address, 'Alamat pengiriman wajib diisi.'); valid = false; }
                const zone = document.getElementById('shipping_zone_id');
                if (!zone.value) { addError(zone, 'Zona pengiriman wajib dipilih.'); valid = false; }
            }

            if (!valid) e.preventDefault();
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\checkout\index.blade.php ENDPATH**/ ?>