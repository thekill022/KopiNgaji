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
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-slate-500 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-indigo-600 transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                        <?php if($product): ?>
                            <a href="<?php echo e(route('umkms.show', $product->umkm)); ?>" class="hover:text-indigo-600 transition-colors"><?php echo e($product->umkm->name); ?></a>
                        <?php elseif($umkm): ?>
                            <a href="<?php echo e(route('umkms.show', $umkm)); ?>" class="hover:text-indigo-600 transition-colors"><?php echo e($umkm->name); ?></a>
                        <?php endif; ?>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                        <span class="text-slate-800">Laporkan</span>
                    </div>
                </li>
            </ol>
        </nav>

        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Header -->
            <div class="p-6 border-b border-slate-100 bg-red-50 flex items-center gap-4">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-flag"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-800">Laporkan Konten</h1>
                    <p class="text-sm text-slate-500 mt-0.5">
                        <?php if($product): ?>
                            Produk: <span class="font-semibold text-slate-700"><?php echo e($product->name); ?></span> — <?php echo e($product->umkm->name); ?>

                        <?php elseif($umkm): ?>
                            UMKM: <span class="font-semibold text-slate-700"><?php echo e($umkm->name); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="<?php echo e(route('reports.store')); ?>" class="p-6 space-y-6">
                <?php echo csrf_field(); ?>
                <?php if($product): ?>
                    <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                    <input type="hidden" name="umkm_id" value="<?php echo e($product->umkm_id); ?>">
                <?php elseif($umkm): ?>
                    <input type="hidden" name="umkm_id" value="<?php echo e($umkm->id); ?>">
                <?php endif; ?>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Kategori Laporan <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" required
                        class="block w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-red-200 focus:border-red-400 transition-colors <?php echo e($errors->has('category') ? 'border-red-400' : ''); ?>">
                        <option value="">Pilih kategori...</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($key); ?>" <?php echo e(old('category') === $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-slate-700 mb-1.5">
                        Deskripsi Laporan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="5" required minlength="20" maxlength="1000"
                        placeholder="Jelaskan secara detail mengapa konten ini melanggar. Semakin detail, semakin mudah bagi tim kami untuk menindaklanjuti laporan Anda."
                        class="block w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 focus:ring-2 focus:ring-red-200 focus:border-red-400 transition-colors resize-none <?php echo e($errors->has('description') ? 'border-red-400' : ''); ?>"><?php echo e(old('description')); ?></textarea>
                    <div class="flex justify-between items-center mt-1">
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-xs"><?php echo e($message); ?></p>
                        <?php else: ?>
                            <p class="text-slate-400 text-xs">Minimal 20 karakter.</p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <p class="text-slate-400 text-xs ml-auto" id="char-count">0 / 1000</p>
                    </div>
                </div>

                <!-- Warning Notice -->
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl flex gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5 shrink-0"></i>
                    <p class="text-xs text-amber-700 leading-relaxed">
                        Laporan palsu atau penyalahgunaan fitur ini dapat mengakibatkan pemblokiran akun Anda. Pastikan laporan yang Anda ajukan memiliki alasan yang valid.
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between pt-2">
                    <?php if($product): ?>
                        <a href="<?php echo e(route('products.show', $product)); ?>" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                        </a>
                    <?php elseif($umkm): ?>
                        <a href="<?php echo e(route('umkms.show', $umkm)); ?>" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                            <i class="fa-solid fa-arrow-left mr-1"></i> Batal
                        </a>
                    <?php endif; ?>
                    <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl transition-colors shadow-sm shadow-red-200">
                        <i class="fa-solid fa-flag"></i> Kirim Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const textarea = document.getElementById('description');
        const counter = document.getElementById('char-count');
        textarea.addEventListener('input', () => {
            counter.textContent = `${textarea.value.length} / 1000`;
        });

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

            const category = document.getElementById('category');
            if (!category.value) { addError(category, 'Pilih kategori laporan.'); valid = false; }

            const desc = document.getElementById('description');
            if (!desc.value.trim()) { addError(desc, 'Deskripsi laporan wajib diisi.'); valid = false; }
            else if (desc.value.trim().length < 20) { addError(desc, 'Deskripsi minimal 20 karakter.'); valid = false; }
            else if (desc.value.trim().length > 1000) { addError(desc, 'Deskripsi maksimal 1000 karakter.'); valid = false; }

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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\reports\create.blade.php ENDPATH**/ ?>