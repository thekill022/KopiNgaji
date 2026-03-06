<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-slate-800 leading-tight flex items-center gap-3">
            <i class="fa-solid fa-store text-indigo-500"></i>
            {{ __('Daftar UMKM') }}
        </h2>
    </x-slot>

    <!-- Hero Section / Search Bar -->
    <div class="relative bg-indigo-600 text-white overflow-hidden py-16 mb-10 shadow-lg rounded-b-3xl -mt-[1px]">
        <!-- Decorative bg -->
        <div class="absolute inset-0 z-0 opacity-20 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-white via-indigo-200 to-indigo-600 blur-2xl"></div>
        <div class="absolute inset-0 z-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight mb-4 drop-shadow-sm">Temukan Produk UMKM Terbaik</h1>
            <p class="text-indigo-100 text-lg md:text-xl font-medium max-w-2xl mx-auto mb-8">
                Dukung kemajuan ekonomi umat dengan berbelanja produk-produk berkualitas tinggi dari mitra UMKM KopiNgaji.
            </p>

            <form method="GET" class="max-w-3xl mx-auto">
                <div class="flex items-center bg-white p-2 md:p-3 rounded-full shadow-2xl transition-transform hover:-translate-y-1 duration-300">
                    <div class="flex-grow flex items-center px-4">
                        <i class="fa-solid fa-search text-slate-400 text-xl mr-3"></i>
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari UMKM atau produk favoritmu..." 
                            class="w-full bg-transparent border-0 focus:ring-0 text-slate-700 text-lg placeholder-slate-400 px-0 outline-none">
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-full font-bold transition-all shadow-md flex items-center gap-2">
                        <span>Cari</span>
                        <i class="fa-solid fa-arrow-right text-sm"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
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
                <span class="text-sm font-semibold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full"><i class="fa-solid fa-store mr-1"></i> {{ $umkms->count() }} Toko</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($umkms as $umkm)
                    <a href="{{ route('umkms.show', $umkm) }}" class="group block bg-white rounded-2xl p-6 shadow-sm hover:shadow-2xl border border-slate-100 transition-all duration-300 hover:-translate-y-2 relative overflow-hidden">
                        <!-- Decorative Header -->
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                        
                        <div class="flex items-start justify-between mb-4">
                            <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-50 to-purple-50 flex items-center justify-center text-indigo-600 shadow-inner group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-shop text-2xl drop-shadow-sm border border-indigo-100 rounded-xl w-full h-full flex items-center justify-center"></i>
                            </div>
                            <!-- Verified Badge -->
                            <span class="bg-emerald-50 text-emerald-600 text-[10px] uppercase font-bold px-2 py-1 rounded-full flex items-center gap-1 border border-emerald-100">
                                <i class="fa-solid fa-circle-check"></i> Mitra
                            </span>
                        </div>
                        
                        <h3 class="font-bold text-xl text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors">{{ $umkm->name }}</h3>
                        
                        @if ($umkm->description)
                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed h-10">
                                {{ $umkm->description }}
                            </p>
                        @endif

                        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="text-indigo-600 font-semibold group-hover:translate-x-1 transition-transform inline-block">Kunjungi Toko <i class="fa-solid fa-arrow-right ml-1"></i></span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $umkms->links() }}
            </div>
        @endif

        @if (isset($products) && $products->isNotEmpty())
            <div class="mt-16 pt-10 border-t border-slate-200">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="font-bold text-2xl text-slate-800 flex items-center gap-3"><i class="fa-solid fa-tags text-emerald-500"></i> {{ __('Produk yang cocok') }}</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        <div class="bg-white border text-center border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group">
                            <!-- Product Image Placeholder -->
                            <div class="aspect-square bg-slate-50 relative p-6 flex flex-col items-center justify-center border-b border-slate-100">
                                <i class="fa-solid fa-box text-6xl text-slate-200 group-hover:text-indigo-200 transition-colors mb-2"></i>
                                <span class="absolute top-3 left-3 bg-white/80 backdrop-blur-md text-xs font-bold text-slate-600 px-2 py-1 rounded-md shadow-sm">
                                    <i class="fa-solid fa-store mr-1"></i> {{ $product->umkm->name }}
                                </span>
                            </div>
                            
                            <div class="p-5 text-left">
                                <a href="{{ route('umkms.show', $product->umkm) }}" class="font-bold text-lg text-slate-800 hover:text-indigo-600 transition-colors block mb-1 truncate">
                                    {{ $product->name }}
                                </a>
                                <p class="text-sm text-slate-500 mb-3 truncate">{{ Str::limit($product->description ?? 'Deskripsi produk', 40) }}</p>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <p class="font-black text-indigo-600 text-lg">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                    <a href="{{ route('umkms.show', $product->umkm) }}" class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors">
                                        <i class="fa-solid fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
