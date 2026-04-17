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
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <i class="fa-solid fa-store text-indigo-500"></i>
            <?php echo e(__('Daftar UMKM')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <!-- Hero Section / Search Bar -->
    <div class="relative bg-indigo-600 text-white overflow-hidden py-16 mb-10 shadow-lg rounded-b-3xl -mt-[1px]">
        <div class="absolute inset-0 z-0 opacity-20 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white via-indigo-200 to-indigo-600 blur-2xl"></div>
        <div class="absolute inset-0 z-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 drop-shadow-sm">Temukan Produk UMKM Terbaik</h1>
            <p class="text-indigo-100 text-lg md:text-xl font-medium max-w-2xl mx-auto mb-8">
                Dukung kemajuan ekonomi umat dengan berbelanja produk-produk berkualitas tinggi dari mitra UMKM KopiNgaji.
            </p>

            <form id="search-form" class="max-w-3xl mx-auto" onsubmit="return false;">
                <div class="flex items-center bg-white p-2 md:p-3 rounded-full shadow-2xl transition-transform hover:-translate-y-1 duration-300">
                    <div class="flex-grow flex items-center px-4 relative">
                        <i class="fa-solid fa-search text-slate-400 text-xl mr-3 search-icon"></i>
                        <i class="fa-solid fa-spinner fa-spin text-indigo-500 text-xl mr-3 search-spinner hidden"></i>
                        <input type="text" name="search" id="search-input" value="<?php echo e($search ?? ''); ?>" placeholder="Cari UMKM atau produk favoritmu..." 
                            class="w-full bg-transparent border-0 focus:ring-0 text-slate-700 text-lg placeholder-slate-400 px-0 outline-none" autocomplete="off">
                        <button type="button" id="clear-btn" class="text-slate-400 hover:text-slate-600 transition-colors ml-2 flex-shrink-0 <?php echo e(empty($search) ? 'hidden' : ''); ?>">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="mt-6 max-w-3xl mx-auto flex flex-wrap items-center justify-center gap-3">
                <button type="button" id="nearby-btn" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-indigo-700 text-sm font-semibold rounded-full shadow-md hover:bg-indigo-50 hover:shadow-lg transition">
                    <i class="fa-solid fa-location-arrow"></i>
                    <span>Cari UMKM Terdekat</span>
                </button>
                <?php if($lat && $lng): ?>
                    <a href="<?php echo e(route('umkms.index', ['search' => $search])); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-full shadow-md hover:bg-indigo-700 hover:shadow-lg transition">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset Lokasi</span>
                    </a>
                <?php endif; ?>
            </div>
            <p id="nearby-error" class="mt-3 text-red-200 text-sm hidden"></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div id="umkm-section">
            <?php if($umkms->isEmpty()): ?>
                <div class="bg-white p-12 rounded-3xl shadow-sm text-center border text-slate-500 border-slate-100">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-sm">
                        <i class="fa-solid fa-box-open text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Tidak ada UMKM ditemukan</h3>
                    <p>
                        <?php if($lat && $lng): ?>
                            Belum ada UMKM mitra yang memiliki data lokasi di sekitar Anda.
                        <?php else: ?>
                            Coba gunakan kata kunci lain untuk mencari.
                        <?php endif; ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-slate-800 tracking-tight">
                        <?php echo e($lat && $lng ? 'UMKM Terdekat' : 'Eksplorasi UMKM'); ?>

                    </h3>
                    <span class="text-sm font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full"><i class="fa-solid fa-store mr-1"></i> <?php echo e($umkms->total()); ?> Toko</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $umkms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $umkm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('umkms.show', $umkm)); ?>" class="group block bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl border border-slate-100 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-indigo-600 shadow-inner group-hover:scale-110 transition-transform duration-300">
                                    <i class="fa-solid fa-shop text-2xl drop-shadow-sm border border-indigo-100 rounded-xl w-full h-full flex items-center justify-center"></i>
                                </div>
                                <span class="bg-emerald-50 text-emerald-600 text-[10px] uppercase font-bold px-2 py-1 rounded-full flex items-center gap-1 border border-emerald-100">
                                    <i class="fa-solid fa-circle-check"></i> Mitra
                                </span>
                            </div>
                            <h3 class="font-bold text-xl text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors"><?php echo e($umkm->name); ?></h3>
                            <?php if($umkm->description): ?>
                                <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed h-10"><?php echo e($umkm->description); ?></p>
                            <?php endif; ?>
                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-sm">
                                <span class="text-indigo-600 font-semibold group-hover:translate-x-1 transition-transform inline-block">Kunjungi Toko <i class="fa-solid fa-arrow-right ml-1"></i></span>
                                <?php if($lat && $lng && $umkm->distance !== null): ?>
                                    <span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded">
                                        <i class="fa-solid fa-location-dot mr-1"></i><?php echo e(number_format($umkm->distance, 1)); ?> km
                                    </span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="mt-10"><?php echo e($umkms->links()); ?></div>
            <?php endif; ?>
        </div>

        <div id="product-section">
            <?php if(isset($products) && $products->isNotEmpty()): ?>
                <div class="mt-16 pt-10 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-2xl text-slate-800 flex items-center gap-3"><i class="fa-solid fa-tags text-emerald-500"></i> Produk yang cocok</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white border text-center border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                                <a href="<?php echo e(route('products.show', $product)); ?>" class="aspect-square bg-slate-50 relative p-6 flex flex-col items-center justify-center border-b border-slate-100 overflow-hidden block">
                                    <?php if($product->image_url): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->image_url)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <i class="fa-solid fa-box text-6xl text-slate-200 group-hover:text-indigo-200 transition-colors mb-2"></i>
                                    <?php endif; ?>
                                    <span class="absolute top-3 left-3 bg-white/80 backdrop-blur-md text-xs font-bold text-slate-600 px-2 py-1 rounded-md shadow-sm">
                                        <i class="fa-solid fa-store mr-1"></i> <?php echo e($product->umkm->name); ?>

                                    </span>
                                </a>
                                <div class="p-5 text-left">
                                    <a href="<?php echo e(route('products.show', $product)); ?>" class="font-bold text-lg text-slate-800 hover:text-indigo-600 transition-colors block mb-1 truncate"><?php echo e($product->name); ?></a>
                                    <div class="flex items-center justify-between mt-4">
                                        <p class="font-black text-indigo-600 text-lg">Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?></p>
                                        <a href="<?php echo e(route('umkms.show', $product->umkm)); ?>" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-8"><?php echo e($products->links()); ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        let debounceTimer, abortCtrl;
        const input = document.getElementById('search-input');
        const form = document.getElementById('search-form');
        const icon = form.querySelector('.search-icon');
        const spinner = form.querySelector('.search-spinner');
        const clearBtn = document.getElementById('clear-btn');
        const umkmEl = document.getElementById('umkm-section');
        const prodEl = document.getElementById('product-section');
        const baseUrl = "<?php echo e(route('umkms.index')); ?>";

        const fmt = v => new Intl.NumberFormat('id-ID').format(Math.round(v));
        const latParam = <?php echo e(json_encode($lat)); ?>;
        const lngParam = <?php echo e(json_encode($lng)); ?>;

        function renderUmkms(list, count) {
            if (!list.length) {
                const nearbyMsg = latParam && lngParam
                    ? '<p>Belum ada UMKM mitra yang memiliki data lokasi di sekitar Anda.</p>'
                    : '<p>Coba gunakan kata kunci lain.</p>';
                return `<div class="bg-white p-12 rounded-3xl shadow-sm text-center border text-slate-500 border-slate-100">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fa-solid fa-box-open text-4xl text-slate-300"></i></div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Tidak ada UMKM ditemukan</h3>${nearbyMsg}</div>`;
            }
            const hasDistance = list.some(u => u.distance !== null && u.distance !== undefined);
            return `<div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-slate-800 tracking-tight">${hasDistance ? 'UMKM Terdekat' : 'Eksplorasi UMKM'}</h3>
                <span class="text-sm font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full"><i class="fa-solid fa-store mr-1"></i> ${count} Toko</span>
            </div><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">${list.map(u => {
                const distBadge = u.distance !== null && u.distance !== undefined
                    ? `<span class="text-xs text-slate-500 bg-slate-100 px-2 py-1 rounded"><i class="fa-solid fa-location-dot mr-1"></i>${parseFloat(u.distance).toFixed(1)} km</span>`
                    : '';
                return `<a href="${u.url}" class="group block bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl border border-slate-100 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-indigo-600 shadow-inner"><i class="fa-solid fa-shop text-2xl"></i></div>
                        <span class="bg-emerald-50 text-emerald-600 text-[10px] uppercase font-bold px-2 py-1 rounded-full flex items-center gap-1 border border-emerald-100"><i class="fa-solid fa-circle-check"></i> Mitra</span>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">${u.name}</h3>
                    ${u.description ? `<p class="text-sm text-slate-500 line-clamp-2 leading-relaxed h-10">${u.description}</p>` : ''}
                    <div class="mt-5 pt-4 border-t border-slate-100 text-sm flex items-center justify-between"><span class="text-indigo-600 font-semibold">Kunjungi Toko <i class="fa-solid fa-arrow-right ml-1"></i></span>${distBadge}</div>
                </a>`;
            }).join('')}</div>`;
        }

        function renderProducts(list) {
            if (!list.length) return '';
            return `<div class="mt-16 pt-10 border-t border-slate-200">
                <div class="mb-8"><h3 class="font-bold text-2xl text-slate-800 flex items-center gap-3"><i class="fa-solid fa-tags text-emerald-500"></i> Produk yang cocok</h3></div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">${list.map(p => `
                <div class="bg-white border text-center border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                    <a href="${p.url}" class="aspect-square bg-slate-50 relative p-6 flex flex-col items-center justify-center border-b border-slate-100 overflow-hidden block">
                        ${p.image_url ? `<img src="${p.image_url}" alt="${p.name}" class="w-full h-full object-cover">` : `<i class="fa-solid fa-box text-6xl text-slate-200"></i>`}
                        <span class="absolute top-3 left-3 bg-white/80 backdrop-blur-md text-xs font-bold text-slate-600 px-2 py-1 rounded-md shadow-sm"><i class="fa-solid fa-store mr-1"></i> ${p.umkm_name}</span>
                    </a>
                    <div class="p-5 text-left">
                        <a href="${p.url}" class="font-bold text-lg text-slate-800 hover:text-indigo-600 transition-colors block mb-1 truncate">${p.name}</a>
                        <div class="flex items-center justify-between mt-4">
                            <p class="font-black text-indigo-600 text-lg">Rp ${fmt(p.price)}</p>
                            <a href="${p.umkm_url}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors"><i class="fa-solid fa-plus"></i></a>
                        </div>
                    </div>
                </div>`).join('')}</div></div>`;
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

            const params = new URLSearchParams();
            if (q) params.set('search', q);
            if (latParam) params.set('lat', latParam);
            if (lngParam) params.set('lng', lngParam);
            const url = `${baseUrl}${params.toString() ? '?' + params.toString() : ''}`;
            window.history.replaceState({}, '', url);

            fetch(url, { headers: { 'Accept': 'application/json' }, signal: abortCtrl.signal })
                .then(r => r.json())
                .then(d => {
                    umkmEl.style.opacity = '0';
                    prodEl.style.opacity = '0';
                    renderTimer = setTimeout(() => {
                        umkmEl.innerHTML = renderUmkms(d.umkms, d.umkm_count);
                        prodEl.innerHTML = renderProducts(d.products);
                        umkmEl.style.opacity = '1';
                        prodEl.style.opacity = '1';
                    }, 150);
                    spinner.classList.add('hidden');
                    icon.classList.remove('hidden');
                })
                .catch(e => { if (e.name !== 'AbortError') { spinner.classList.add('hidden'); icon.classList.remove('hidden'); }});
        }

        const nearbyBtn = document.getElementById('nearby-btn');
        const nearbyError = document.getElementById('nearby-error');
        if (nearbyBtn) {
            nearbyBtn.addEventListener('click', function() {
                if (!navigator.geolocation) {
                    nearbyError.textContent = 'Browser Anda tidak mendukung geolokasi.';
                    nearbyError.classList.remove('hidden');
                    return;
                }
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const q = input.value || '';
                        const url = `${baseUrl}?lat=${pos.coords.latitude}&lng=${pos.coords.longitude}${q ? '&search=' + encodeURIComponent(q) : ''}`;
                        window.location.href = url;
                    },
                    (err) => {
                        nearbyError.textContent = 'Gagal mengambil lokasi: ' + err.message;
                        nearbyError.classList.remove('hidden');
                    }
                );
            });
        }

        // Add transition
        umkmEl.style.transition = 'opacity 0.15s ease';
        prodEl.style.transition = 'opacity 0.15s ease';

        // Cancel all pending search when user clicks a link (prevents content replacement during navigation)
        document.addEventListener('mousedown', function(e) {
            if (e.target.closest('#umkm-section a, #product-section a')) {
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
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views/umkms/index.blade.php ENDPATH**/ ?>