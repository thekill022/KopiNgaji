<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Breadcrumb -->
        <nav class="flex mb-8 text-sm text-slate-500 font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                        <a href="{{ route('umkms.index') }}" class="hover:text-indigo-600 transition-colors">UMKM</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                        <a href="{{ route('umkms.show', $product->umkm) }}" class="hover:text-indigo-600 transition-colors">{{ $product->umkm->name }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fa-solid fa-chevron-right text-xs mx-2"></i>
                        <span class="text-slate-800">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0">
                
                <!-- Product Image Section -->
                <div class="bg-slate-50 relative min-h-[400px] md:min-h-full overflow-hidden">
                    @if($product->is_preorder)
                        <div class="absolute top-6 left-6 z-10">
                            <span class="bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">PRE-ORDER</span>
                        </div>
                    @endif
                    
                    @if($product->image_url)
                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover object-center transform hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="absolute inset-0 w-full h-full flex flex-col items-center justify-center text-slate-300 bg-slate-100">
                            <i class="fa-solid fa-image text-8xl mb-4"></i>
                            <span class="text-lg font-medium">Gambar Tidak Tersedia</span>
                        </div>
                    @endif
                </div>

                <!-- Product Details Section -->
                <div class="p-8 md:p-12 flex flex-col justify-center">
                    <div class="mb-2">
                        <a href="{{ route('umkms.show', $product->umkm) }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-700 transition-colors group">
                            <div class="w-6 h-6 rounded-full bg-indigo-50 flex items-center justify-center group-hover:bg-indigo-100 transition-colors">
                                <i class="fa-solid fa-store text-xs"></i>
                            </div>
                            {{ $product->umkm->name }}
                        </a>
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4 leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                        <div class="text-3xl font-black text-indigo-600">
                            <span class="text-xl font-bold mr-1">Rp</span>{{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        @if($product->stock > 0)
                            <span class="bg-emerald-50 text-emerald-600 text-sm font-bold px-3 py-1 rounded-full border border-emerald-100">
                                Stok: {{ $product->stock }}
                            </span>
                        @else
                            <span class="bg-red-50 text-red-600 text-sm font-bold px-3 py-1 rounded-full border border-red-100">
                                Stok Habis
                            </span>
                        @endif
                    </div>
                    
                    <div class="prose prose-sm sm:prose text-slate-600 mb-8 max-w-none">
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Deskripsi Produk</h3>
                        <p class="leading-relaxed">
                            {{ $product->description ?: 'Toko ini belum menambahkan deskripsi untuk produk ini.' }}
                        </p>
                    </div>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.store') }}" method="POST" class="mt-auto pt-6 border-t border-slate-100">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            <div class="w-full sm:w-1/3">
                                <label for="quantity" class="block text-sm font-medium text-slate-700 mb-1">Jumlah</label>
                                <div class="relative flex items-center">
                                    <button type="button" id="decrement-btn" class="absolute left-0 w-10 h-full flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors bg-slate-50 border border-slate-200 rounded-l-lg">
                                        <i class="fa-solid fa-minus text-xs"></i>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock > 0 ? $product->stock : 1 }}" 
                                        class="w-full text-center pl-10 pr-10 py-3 bg-white border-y border-x-0 border-slate-200 text-slate-800 font-bold focus:ring-0 focus:border-slate-200">
                                    <button type="button" id="increment-btn" class="absolute right-0 w-10 h-full flex items-center justify-center text-slate-400 hover:text-indigo-600 transition-colors bg-slate-50 border border-slate-200 rounded-r-lg">
                                        <i class="fa-solid fa-plus text-xs"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="w-full sm:w-2/3 flex flex-col gap-3 sm:pt-6">
                                <button type="submit" name="action" value="cart" @disabled($product->stock < 1) class="w-full flex items-center justify-center gap-2 bg-white text-indigo-600 border-2 border-indigo-600 font-bold py-3.5 px-6 rounded-xl hover:bg-indigo-50 focus:ring-4 focus:ring-indigo-100 transition-all shadow-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                    Tambah ke Keranjang
                                </button>
                                <button type="submit" name="action" value="buy_now" @disabled($product->stock < 1) class="w-full flex items-center justify-center gap-2 bg-indigo-600 text-white font-bold py-3.5 px-6 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-100 transition-all shadow-md shadow-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                    Belanja Sekarang
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Report Link -->
                    <div class="mt-6 pt-4 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('reports.create', ['product_id' => $product->id]) }}" 
                           class="inline-flex items-center gap-2 text-xs text-slate-400 hover:text-red-500 transition-colors font-medium">
                            <i class="fa-solid fa-flag"></i>
                            Laporkan produk ini
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Script for Quantity Buttons -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decrementBtn = document.getElementById('decrement-btn');
            const incrementBtn = document.getElementById('increment-btn');
            const quantityInput = document.getElementById('quantity');
            const maxStock = parseInt(quantityInput.getAttribute('max'));

            decrementBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value > 1) {
                    quantityInput.value = value - 1;
                }
            });

            incrementBtn.addEventListener('click', () => {
                let value = parseInt(quantityInput.value);
                if (value < maxStock) {
                    quantityInput.value = value + 1;
                }
            });
        });
    </script>
</x-app-layout>
