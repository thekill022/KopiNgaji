<x-app-layout>
    <!-- Header Hero banner for the UMKM Store -->
    <div class="relative bg-white pt-10 pb-6 shadow-sm border-b border-slate-200">
        <!-- Abstract background pattern behind header text -->
        <div class="absolute inset-x-0 top-0 h-48 bg-gradient-to-br from-indigo-50/50 to-purple-50/50"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 flex flex-col md:flex-row items-center md:items-start gap-6 pt-6">
            <!-- UMKM Logo/Avatar -->
            <div class="w-32 h-32 rounded-2xl bg-white p-2 shadow-lg border border-slate-100 flex-shrink-0 z-20 -mt-2">
                <div class="w-full h-full rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-400 text-5xl">
                    <i class="fa-solid fa-store"></i>
                </div>
            </div>

            <!-- UMKM Info -->
            <div class="flex-grow text-center md:text-left pt-2 pb-4">
                <div class="flex items-center justify-center md:justify-start gap-3 mb-2">
                    <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">{{ $umkm->name }}</h1>
                    <span class="bg-emerald-100 text-emerald-700 text-xs px-2 py-1 rounded-full font-bold uppercase flex items-center gap-1">
                        <i class="fa-solid fa-check-circle"></i> Mitra Resmi
                    </span>
                </div>
                
                @if ($umkm->description)
                    <p class="text-slate-500 max-w-3xl leading-relaxed text-base">
                        {{ $umkm->description }}
                    </p>
                @else
                    <p class="text-slate-400 italic text-sm">Toko ini belum menambahkan deskripsi.</p>
                @endif
                
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-6 text-sm font-medium text-slate-600">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <span>{{ $products->total() }} Produk</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                            <i class="fa-solid fa-calendar-alt"></i>
                        </div>
                        <span>Bergabung {{ $umkm->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Store Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Store Navigation/Filters Area -->
        <div class="flex flex-col md:flex-row items-center justify-between mb-8 pb-6 border-b border-slate-200 gap-4">
            <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                <i class="fa-solid fa-boxes-stacked text-indigo-500"></i>
                Semua Produk
            </h2>

            <form method="GET" class="w-full md:w-auto relative group">
                <input type="text" name="productSearch" value="{{ request('productSearch') }}" placeholder="Cari di toko ini..." 
                    class="w-full md:w-80 pl-11 pr-4 py-2.5 bg-white border border-slate-300 rounded-full text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all shadow-sm">
                <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
            </form>
        </div>

        @if ($products->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-3xl p-16 text-center border border-slate-100 shadow-sm max-w-2xl mx-auto">
                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fa-solid fa-basket-shopping text-4xl text-slate-300"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-700 mb-2">Belum Ada Produk</h3>
                <p class="text-slate-500">
                    {{ request('productSearch') ? 'Tidak ada produk yang cocok dengan pencarian Anda.' : 'Toko ini belum menambahkan produk apapun untuk dijual.' }}
                </p>
                @if(request('productSearch'))
                    <a href="{{ route('umkms.show', $umkm) }}" class="inline-block mt-6 px-6 py-2 bg-indigo-50 text-indigo-600 font-semibold rounded-full hover:bg-indigo-100 transition-colors">
                        Bersihkan Pencarian
                    </a>
                @endif
            </div>
        @else
            <!-- E-Commerce Product Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6">
                @foreach ($products as $product)
                    <div class="bg-white border text-left border-slate-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 group flex flex-col h-full relative hover:-translate-y-1">
                        
                        <!-- Badges -->
                        <div class="absolute top-3 left-3 z-10 flex flex-col gap-2">
                            @if(isset($product->is_preorder) && $product->is_preorder)
                                <span class="bg-amber-100 text-amber-700 text-[10px] font-bold px-2 py-1 rounded shadow-sm">PRE-ORDER</span>
                            @endif
                        </div>

                        <!-- Product Image Placeholder -->
                        <a href="{{ route('products.show', $product) }}" class="aspect-square bg-slate-50 relative p-6 flex flex-col items-center justify-center border-b border-slate-100 overflow-hidden">
                            @if($product->image_url)
                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-image text-5xl text-slate-200 group-hover:scale-110 transition-transform duration-500"></i>
                            @endif
                            
                            <!-- Hover Action Overlay -->
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center backdrop-blur-[2px]">
                                <span class="bg-white text-indigo-600 font-bold px-4 py-2 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-lg text-sm">
                                    Lihat Detail
                                </span>
                            </div>
                        </a>
                        
                        <!-- Product Info -->
                        <div class="p-4 flex flex-col flex-grow">
                            <!-- Category tags could go here in DB, placeholder for now -->
                            <div class="text-[10px] uppercase font-bold text-slate-400 mb-1 tracking-wider">PRODUK UMKM</div>
                            
                            <a href="{{ route('products.show', $product) }}" class="font-bold text-[15px] leading-tight text-slate-800 hover:text-indigo-600 transition-colors mb-2 line-clamp-2">
                                {{ $product->name }}
                            </a>
                            
                            <!-- Push price to bottom using mt-auto -->
                            <div class="mt-auto pt-3 flex items-end justify-between">
                                <p class="font-black text-indigo-600 text-lg">
                                    <span class="text-sm font-semibold mr-0.5">Rp</span>{{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                
                                <form action="{{ route('cart.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" @disabled($product->stock < 1) class="w-8 h-8 rounded-full bg-slate-50 border border-slate-200 text-slate-500 flex items-center justify-center hover:bg-emerald-500 hover:border-emerald-500 hover:text-white transition-colors group/btn disabled:opacity-50 disabled:cursor-not-allowed">
                                        <i class="fa-solid fa-cart-shopping text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination Pagination UI -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
