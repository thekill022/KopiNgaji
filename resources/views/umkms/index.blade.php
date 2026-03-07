<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <i class="fa-solid fa-store text-indigo-500"></i>
            {{ __('Daftar UMKM') }}
        </h2>
    </x-slot>

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
                        <input type="text" name="search" id="search-input" value="{{ $search ?? '' }}" placeholder="Cari UMKM atau produk favoritmu..." 
                            class="w-full bg-transparent border-0 focus:ring-0 text-slate-700 text-lg placeholder-slate-400 px-0 outline-none" autocomplete="off">
                        <button type="button" id="clear-btn" class="text-slate-400 hover:text-slate-600 transition-colors ml-2 flex-shrink-0 {{ empty($search) ? 'hidden' : '' }}">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
        <div id="umkm-section">
            @if ($umkms->isEmpty())
                <div class="bg-white p-12 rounded-3xl shadow-sm text-center border text-slate-500 border-slate-100">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100 shadow-sm">
                        <i class="fa-solid fa-box-open text-4xl text-slate-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Tidak ada UMKM ditemukan</h3>
                    <p>Coba gunakan kata kunci lain untuk mencari.</p>
                </div>
            @else
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Eksplorasi UMKM</h3>
                    <span class="text-sm font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full"><i class="fa-solid fa-store mr-1"></i> {{ $umkms->total() }} Toko</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($umkms as $umkm)
                        <a href="{{ route('umkms.show', $umkm) }}" class="group block bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl border border-slate-100 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-indigo-600 shadow-inner group-hover:scale-110 transition-transform duration-300">
                                    <i class="fa-solid fa-shop text-2xl drop-shadow-sm border border-indigo-100 rounded-xl w-full h-full flex items-center justify-center"></i>
                                </div>
                                <span class="bg-emerald-50 text-emerald-600 text-[10px] uppercase font-bold px-2 py-1 rounded-full flex items-center gap-1 border border-emerald-100">
                                    <i class="fa-solid fa-circle-check"></i> Mitra
                                </span>
                            </div>
                            <h3 class="font-bold text-xl text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">{{ $umkm->name }}</h3>
                            @if ($umkm->description)
                                <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed h-10">{{ $umkm->description }}</p>
                            @endif
                            <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-sm">
                                <span class="text-indigo-600 font-semibold group-hover:translate-x-1 transition-transform inline-block">Kunjungi Toko <i class="fa-solid fa-arrow-right ml-1"></i></span>
                            </div>
                        </a>
                    @endforeach
                </div>
                <div class="mt-10">{{ $umkms->links() }}</div>
            @endif
        </div>

        <div id="product-section">
            @if (isset($products) && $products->isNotEmpty())
                <div class="mt-16 pt-10 border-t border-slate-200">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="font-bold text-2xl text-slate-800 flex items-center gap-3"><i class="fa-solid fa-tags text-emerald-500"></i> Produk yang cocok</h3>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($products as $product)
                            <div class="bg-white border text-center border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                                <a href="{{ route('products.show', $product) }}" class="aspect-square bg-slate-50 relative p-6 flex flex-col items-center justify-center border-b border-slate-100 overflow-hidden block">
                                    @if($product->image_url)
                                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-box text-6xl text-slate-200 group-hover:text-indigo-200 transition-colors mb-2"></i>
                                    @endif
                                    <span class="absolute top-3 left-3 bg-white/80 backdrop-blur-md text-xs font-bold text-slate-600 px-2 py-1 rounded-md shadow-sm">
                                        <i class="fa-solid fa-store mr-1"></i> {{ $product->umkm->name }}
                                    </span>
                                </a>
                                <div class="p-5 text-left">
                                    <a href="{{ route('products.show', $product) }}" class="font-bold text-lg text-slate-800 hover:text-indigo-600 transition-colors block mb-1 truncate">{{ $product->name }}</a>
                                    <div class="flex items-center justify-between mt-4">
                                        <p class="font-black text-indigo-600 text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <a href="{{ route('umkms.show', $product->umkm) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                                            <i class="fa-solid fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $products->links() }}</div>
                </div>
            @endif
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
        const baseUrl = "{{ route('umkms.index') }}";

        const fmt = v => new Intl.NumberFormat('id-ID').format(Math.round(v));

        function renderUmkms(list, count) {
            if (!list.length) return `<div class="bg-white p-12 rounded-3xl shadow-sm text-center border text-slate-500 border-slate-100">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4"><i class="fa-solid fa-box-open text-4xl text-slate-300"></i></div>
                <h3 class="text-xl font-bold text-slate-700 mb-2">Tidak ada UMKM ditemukan</h3><p>Coba gunakan kata kunci lain.</p></div>`;
            return `<div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Eksplorasi UMKM</h3>
                <span class="text-sm font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full"><i class="fa-solid fa-store mr-1"></i> ${count} Toko</span>
            </div><div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">${list.map(u => `
                <a href="${u.url}" class="group block bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl border border-slate-100 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-indigo-600 shadow-inner"><i class="fa-solid fa-shop text-2xl"></i></div>
                        <span class="bg-emerald-50 text-emerald-600 text-[10px] uppercase font-bold px-2 py-1 rounded-full flex items-center gap-1 border border-emerald-100"><i class="fa-solid fa-circle-check"></i> Mitra</span>
                    </div>
                    <h3 class="font-bold text-xl text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">${u.name}</h3>
                    ${u.description ? `<p class="text-sm text-slate-500 line-clamp-2 leading-relaxed h-10">${u.description}</p>` : ''}
                    <div class="mt-5 pt-4 border-t border-slate-100 text-sm"><span class="text-indigo-600 font-semibold">Kunjungi Toko <i class="fa-solid fa-arrow-right ml-1"></i></span></div>
                </a>`).join('')}</div>`;
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

            const url = q ? `${baseUrl}?search=${encodeURIComponent(q)}` : baseUrl;
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
</x-app-layout>
