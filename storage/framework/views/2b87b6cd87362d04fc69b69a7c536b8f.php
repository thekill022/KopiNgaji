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
    <!-- Header Hero banner for the UMKM Store -->
    <div class="relative bg-white pt-10 pb-6 shadow-sm border-b border-slate-200">
        <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-br from-indigo-50/50 to-purple-50/50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6 pt-6">
            <div class="w-32 h-32 rounded-2xl bg-white p-2 shadow-lg border border-slate-100 flex-shrink-0 z-20 -mt-2">
                <div class="w-full h-full rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-400 text-5xl">
                    <i class="fa-solid fa-store"></i>
                </div>
            </div>

            <div class="flex-grow text-center md:text-left pt-2 pb-4">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight"><?php echo e($umkm->name); ?></h1>
                    <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full font-bold uppercase flex items-center gap-1">
                        <i class="fa-solid fa-check-circle"></i> Mitra Resmi
                    </span>
                </div>
                
                <?php if($umkm->description): ?>
                    <p class="text-slate-500 max-w-3xl leading-relaxed text-base"><?php echo e($umkm->description); ?></p>
                <?php else: ?>
                    <p class="text-slate-400 italic text-sm">Toko ini belum menambahkan deskripsi.</p>
                <?php endif; ?>
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-6 text-sm font-medium text-slate-600">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <span id="product-total-count"><?php echo e($products->total()); ?> Produk</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <i class="fa-solid fa-calendar-alt"></i>
                        </div>
                        <span>Bergabung <?php echo e($umkm->created_at->diffForHumans()); ?></span>
                    </div>
                </div>
            </div>
            <div class="pb-4 pt-2 self-end">
                <a href="<?php echo e(route('reports.create', ['umkm_id' => $umkm->id])); ?>"
                   class="inline-flex items-center gap-2 text-xs text-slate-400 hover:text-red-500 transition-colors font-medium">
                    <i class="fa-solid fa-flag"></i> Laporkan UMKM ini
                </a>
            </div>
        </div>
    </div>

    <!-- Main Store Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 pb-6 border-b border-slate-200 gap-4">
            <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked text-indigo-500"></i>
                Semua Produk
            </h2>

            <form id="store-search-form" class="w-full md:w-auto relative group" onsubmit="return false;">
                <input type="text" name="productSearch" id="store-search-input" value="<?php echo e($productSearch ?? ''); ?>" placeholder="Cari di toko ini..." 
                    class="w-full md:w-80 pl-11 pr-10 py-2.5 bg-white border border-slate-300 rounded-full text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm" autocomplete="off">
                <i class="fa-solid fa-search store-search-icon absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                <i class="fa-solid fa-spinner fa-spin store-search-spinner absolute left-4 top-1/2 -translate-y-1/2 text-indigo-500 hidden"></i>
                <button type="button" id="store-clear-btn" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 <?php echo e(empty($productSearch) ? 'hidden' : ''); ?>">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </form>
        </div>

        <div id="products-container" style="transition: opacity 0.15s ease;">
            <?php if($products->isEmpty()): ?>
                <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm max-w-2xl mx-auto">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-basket-shopping text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-700 mb-2">Belum Ada Produk</h3>
                    <p class="text-slate-500">
                        <?php echo e($productSearch ? 'Tidak ada produk yang cocok dengan pencarian Anda.' : 'Toko ini belum menambahkan produk apapun untuk dijual.'); ?>

                    </p>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white border text-left border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 group flex flex-col h-full relative hover:-translate-y-1">
                            <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
                                <?php if(isset($product->is_preorder) && $product->is_preorder): ?>
                                    <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded shadow-sm">PRE-ORDER</span>
                                <?php endif; ?>
                            </div>
                            <a href="<?php echo e(route('products.show', $product)); ?>" class="aspect-square bg-slate-50 relative p-6 flex flex-col items-center justify-center border-b border-slate-100 overflow-hidden">
                                <?php if($product->image_url): ?>
                                    <img src="<?php echo e(asset('storage/' . $product->image_url)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <i class="fa-solid fa-image text-5xl text-slate-200 group-hover:scale-110 transition-transform duration-500"></i>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                    <span class="bg-white text-indigo-600 font-bold px-4 py-2 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-lg text-sm">Lihat Detail</span>
                                </div>
                            </a>
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="text-[10px] uppercase font-bold text-slate-400 mb-1 tracking-wider">PRODUK UMKM</div>
                                <a href="<?php echo e(route('products.show', $product)); ?>" class="font-bold text-[15px] leading-tight text-slate-800 hover:text-indigo-600 transition-colors mb-2 line-clamp-2"><?php echo e($product->name); ?></a>
                                <div class="mt-auto pt-3 flex items-end justify-between">
                                    <p class="font-black text-indigo-600 text-lg">
                                        <span class="text-sm font-semibold mr-0.5">Rp</span><?php echo e(number_format($product->price, 0, ',', '.')); ?>

                                    </p>
                                    <form action="<?php echo e(route('cart.store')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" <?php if($product->stock < 1): echo 'disabled'; endif; ?> class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-emerald-500 hover:border-emerald-500 hover:text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                            <i class="fa-solid fa-cart-shopping text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="mt-12"><?php echo e($products->links()); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let debounceTimer, abortCtrl;
        const input = document.getElementById('store-search-input');
        const form = document.getElementById('store-search-form');
        const icon = form.querySelector('.store-search-icon');
        const spinner = form.querySelector('.store-search-spinner');
        const clearBtn = document.getElementById('store-clear-btn');
        const container = document.getElementById('products-container');
        const countEl = document.getElementById('product-total-count');
        const baseUrl = "<?php echo e(route('umkms.show', $umkm)); ?>";
        const cartUrl = "<?php echo e(route('cart.store')); ?>";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const fmt = v => new Intl.NumberFormat('id-ID').format(Math.round(v));

        function renderProducts(products, total, query) {
            if (products.length === 0) {
                return `<div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm max-w-2xl mx-auto">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6"><i class="fa-solid fa-basket-shopping text-4xl text-slate-300"></i></div>
                    <h3 class="text-2xl font-bold text-slate-700 mb-2">Belum Ada Produk</h3>
                    <p class="text-slate-500">${query ? 'Tidak ada produk yang cocok dengan pencarian Anda.' : 'Toko ini belum menambahkan produk apapun untuk dijual.'}</p>
                </div>`;
            }

            return `<div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">${products.map(p => `
                <div class="bg-white border text-left border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 group flex flex-col h-full relative hover:-translate-y-1">
                    ${p.is_preorder ? '<div class="absolute top-3 left-3 z-10"><span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded shadow-sm">PRE-ORDER</span></div>' : ''}
                    <a href="${p.url}" class="aspect-square bg-slate-50 relative p-6 flex flex-col items-center justify-center border-b border-slate-100 overflow-hidden">
                        ${p.image_url ? `<img src="${p.image_url}" alt="${p.name}" class="w-full h-full object-cover">` : '<i class="fa-solid fa-image text-5xl text-slate-200"></i>'}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                            <span class="bg-white text-indigo-600 font-bold px-4 py-2 rounded-full shadow-lg text-sm">Lihat Detail</span>
                        </div>
                    </a>
                    <div class="p-4 flex flex-col flex-grow">
                        <div class="text-[10px] uppercase font-bold text-slate-400 mb-1 tracking-wider">PRODUK UMKM</div>
                        <a href="${p.url}" class="font-bold text-[15px] leading-tight text-slate-800 hover:text-indigo-600 transition-colors mb-2 line-clamp-2">${p.name}</a>
                        <div class="mt-auto pt-3 flex items-end justify-between">
                            <p class="font-black text-indigo-600 text-lg"><span class="text-sm font-semibold mr-0.5">Rp</span>${fmt(p.price)}</p>
                            <form action="${cartUrl}" method="POST">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <input type="hidden" name="product_id" value="${p.id}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" ${p.stock < 1 ? 'disabled' : ''} class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-emerald-500 hover:border-emerald-500 hover:text-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <i class="fa-solid fa-cart-shopping text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>`).join('')}</div>`;
        }

        let renderTimer;

        function cancelSearch() {
            clearTimeout(debounceTimer);
            clearTimeout(renderTimer);
            if (abortCtrl) abortCtrl.abort();
            spinner.classList.add('hidden');
            icon.classList.remove('hidden');
        }

        function doSearch(q) {
            cancelSearch();
            abortCtrl = new AbortController();
            icon.classList.add('hidden');
            spinner.classList.remove('hidden');

            const url = q ? `${baseUrl}?productSearch=${encodeURIComponent(q)}` : baseUrl;
            window.history.replaceState({}, '', url);

            fetch(url, { headers: { 'Accept': 'application/json' }, signal: abortCtrl.signal })
                .then(r => r.json())
                .then(d => {
                    container.style.opacity = '0';
                    renderTimer = setTimeout(() => {
                        container.innerHTML = renderProducts(d.products, d.total, q);
                        countEl.textContent = d.total + ' Produk';
                        container.style.opacity = '1';
                    }, 150);
                    spinner.classList.add('hidden');
                    icon.classList.remove('hidden');
                })
                .catch(e => { if (e.name !== 'AbortError') { spinner.classList.add('hidden'); icon.classList.remove('hidden'); }});
        }

        // Cancel all pending search when user clicks a link (prevents content replacement during navigation)
        document.addEventListener('mousedown', function(e) {
            if (e.target.closest('#products-container a')) {
                cancelSearch();
            }
        });

        input.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            clearBtn.classList.toggle('hidden', !this.value);
            debounceTimer = setTimeout(() => doSearch(this.value), 400);
        });

        clearBtn.addEventListener('click', function() {
            input.value = '';
            clearBtn.classList.add('hidden');
            doSearch('');
            input.focus();
        });
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\umkms\show.blade.php ENDPATH**/ ?>