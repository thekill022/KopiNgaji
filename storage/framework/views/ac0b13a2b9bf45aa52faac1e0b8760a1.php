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
        
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-cart-shopping text-indigo-500"></i>
                Keranjang Belanja
            </h1>
            <a href="<?php echo e(route('umkms.index')); ?>" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-1 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                Lanjut Belanja
            </a>
        </div>

        <?php if($cart && $cart->items->count() > 0): ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items List -->
                <div class="lg:col-span-2 space-y-4">
                    <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-6 relative group transition-all hover:shadow-md cart-item"
                             data-item-id="<?php echo e($item->id); ?>"
                             data-price="<?php echo e($item->product->price); ?>"
                             data-stock="<?php echo e($item->product->stock); ?>"
                             data-original-qty="<?php echo e($item->quantity); ?>">
                            
                            <!-- Product Image -->
                            <div class="w-full sm:w-32 h-32 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0 border border-slate-100 overflow-hidden">
                                <?php if($item->product->image_url): ?>
                                    <img src="<?php echo e(asset('storage/' . $item->product->image_url)); ?>" alt="<?php echo e($item->product->name); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="fa-solid fa-image text-4xl text-slate-300"></i>
                                <?php endif; ?>
                            </div>

                            <!-- Product Info -->
                            <div class="flex-grow flex flex-col justify-between">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <div class="text-[10px] uppercase font-bold text-slate-400 mb-1 flex items-center gap-1">
                                            <i class="fa-solid fa-store"></i> <?php echo e($item->product->umkm->name); ?>

                                        </div>
                                        <a href="<?php echo e(route('products.show', $item->product)); ?>" class="text-lg font-bold text-slate-800 hover:text-indigo-600 transition-colors line-clamp-1">
                                            <?php echo e($item->product->name); ?>

                                        </a>
                                        <p class="text-indigo-600 font-black mt-1">
                                            Rp <?php echo e(number_format($item->product->price, 0, ',', '.')); ?>

                                        </p>
                                    </div>
                                    
                                    <!-- Delete Button -->
                                    <form action="<?php echo e(route('cart.destroy', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Quantity Controls (JS-only, no form submit) -->
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                                    <p class="text-sm font-semibold text-slate-500">Total: <span class="text-slate-800 font-bold item-total">Rp <?php echo e(number_format($item->product->price * $item->quantity, 0, ',', '.')); ?></span></p>
                                    
                                    <div class="flex items-center w-28 bg-white border border-slate-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-100">
                                        <button type="button" class="qty-btn qty-minus w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-minus text-[10px]"></i>
                                        </button>
                                        
                                        <input type="number" readonly value="<?php echo e($item->quantity); ?>" class="qty-input w-12 h-8 text-center border-none text-sm font-bold text-slate-700 p-0 focus:ring-0">
                                        
                                        <button type="button" class="qty-btn qty-plus w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 sticky top-6">
                        <h3 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <i class="fa-solid fa-receipt text-indigo-500"></i>
                            Ringkasan Belanja
                        </h3>
                        
                        <div class="space-y-4 mb-6 text-sm">
                            <div class="flex justify-between items-center text-slate-500">
                                <span>Total Harga (<span id="total-items"><?php echo e($cart->items->sum('quantity')); ?></span> barang)</span>
                                <span class="text-slate-700 font-medium" id="summary-price">Rp <?php echo e(number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', '.')); ?></span>
                            </div>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-4 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-800">Total Belanja</span>
                                <span class="text-2xl font-black text-indigo-600" id="grand-total">Rp <?php echo e(number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', '.')); ?></span>
                            </div>
                        </div>

                        <button type="button" id="checkout-btn" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-center shadow-lg shadow-indigo-200 focus:ring-4 focus:ring-indigo-100 transition-all flex justify-center items-center gap-2">
                            Lanjut ke Pembayaran
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        
                        <p class="text-center text-xs text-slate-400 mt-4 flex items-center justify-center gap-1 outline-none">
                            <i class="fa-solid fa-lock text-[10px]"></i> Transaksi aman
                        </p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm max-w-2xl mx-auto mt-10">
                <div class="w-32 h-32 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 relative">
                    <i class="fa-solid fa-cart-shopping text-5xl text-slate-300"></i>
                    <div class="absolute -top-1 -right-1 w-8 h-8 bg-white rounded-full flex items-center justify-center p-1 border border-slate-100 shadow-sm">
                        <i class="fa-solid fa-question text-slate-400 text-xs"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-3 tracking-tight">Keranjang Anda Masih Kosong</h3>
                <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">
                    Ayo temukan berbagai produk menarik dari beragam UMKM lokal sekarang juga. Jangan sampai kehabisan!
                </p>
                <a href="<?php echo e(route('umkms.index')); ?>" class="inline-flex items-center gap-2 px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition-all shadow-[0_8px_30px_rgb(79,70,229,0.2)] hover:shadow-[0_8px_30px_rgb(79,70,229,0.3)] transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Mulai Belanja
                </a>
            </div>
        <?php endif; ?>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const checkoutBtn = document.getElementById('checkout-btn');
        let hasChanges = false;

        function formatRupiah(num) {
            return 'Rp ' + Math.round(num).toLocaleString('id-ID');
        }

        function recalcSummary() {
            let grandTotal = 0;
            let totalItems = 0;

            document.querySelectorAll('.cart-item').forEach(el => {
                const price = parseFloat(el.dataset.price);
                const qty = parseInt(el.querySelector('.qty-input').value);
                const itemTotal = price * qty;
                grandTotal += itemTotal;
                totalItems += qty;

                el.querySelector('.item-total').textContent = formatRupiah(itemTotal);
            });

            document.getElementById('summary-price').textContent = formatRupiah(grandTotal);
            document.getElementById('grand-total').textContent = formatRupiah(grandTotal);
            document.getElementById('total-items').textContent = totalItems;
        }

        function checkChanges() {
            hasChanges = false;
            document.querySelectorAll('.cart-item').forEach(el => {
                const originalQty = parseInt(el.dataset.originalQty);
                const currentQty = parseInt(el.querySelector('.qty-input').value);
                if (originalQty !== currentQty) {
                    hasChanges = true;
                }
            });
        }

        // Quantity buttons
        document.querySelectorAll('.qty-minus').forEach(btn => {
            btn.addEventListener('click', function () {
                const item = this.closest('.cart-item');
                const input = item.querySelector('.qty-input');
                let val = parseInt(input.value);
                if (val > 1) {
                    input.value = val - 1;
                    recalcSummary();
                    checkChanges();
                }
            });
        });

        document.querySelectorAll('.qty-plus').forEach(btn => {
            btn.addEventListener('click', function () {
                const item = this.closest('.cart-item');
                const input = item.querySelector('.qty-input');
                const stock = parseInt(item.dataset.stock);
                let val = parseInt(input.value);
                if (val < stock) {
                    input.value = val + 1;
                    recalcSummary();
                    checkChanges();
                }
            });
        });

        // Checkout button — auto-save quantities then redirect
        checkoutBtn.addEventListener('click', function () {
            if (!hasChanges) {
                window.location.href = '<?php echo e(route("checkout.index")); ?>';
                return;
            }

            const items = {};
            document.querySelectorAll('.cart-item').forEach(el => {
                items[el.dataset.itemId] = parseInt(el.querySelector('.qty-input').value);
            });

            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

            fetch('<?php echo e(route("cart.bulk-update")); ?>', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ items: items })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '<?php echo e(route("checkout.index")); ?>';
                }
            })
            .catch(() => {
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = 'Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right"></i>';
                showToast('Gagal menyimpan perubahan. Coba lagi.', true);
            });
        });

        function showToast(message, isError = false) {
            const toast = document.createElement('div');
            toast.className = `fixed top-6 right-6 z-50 px-6 py-3 rounded-xl font-medium shadow-lg flex items-center gap-2 transition-all transform translate-x-0 ${isError ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white'}`;
            toast.innerHTML = `<i class="fa-solid ${isError ? 'fa-circle-exclamation' : 'fa-circle-check'}"></i> ${message}`;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2500);
        }
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\cart\index.blade.php ENDPATH**/ ?>