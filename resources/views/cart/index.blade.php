<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <i class="fa-solid fa-cart-shopping text-indigo-500"></i>
                Keranjang Belanja
            </h1>
            <a href="{{ route('umkms.index') }}" class="text-indigo-600 hover:text-indigo-700 font-medium text-sm flex items-center gap-1 transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
                Lanjut Belanja
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <p class="font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if ($cart && $cart->items->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items List -->
                <div class="lg:col-span-2 space-y-4">
                    @php $totalPrice = 0; @endphp
                    @foreach ($cart->items as $item)
                        @php 
                            $itemTotal = $item->product->price * $item->quantity;
                            $totalPrice += $itemTotal; 
                        @endphp
                        
                        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-6 relative group transition-all hover:shadow-md">
                            
                            <!-- Product Image -->
                            <div class="w-full sm:w-32 h-32 rounded-xl bg-slate-50 flex items-center justify-center flex-shrink-0 border border-slate-100 overflow-hidden">
                                @if($item->product->image_url)
                                    <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-image text-4xl text-slate-300"></i>
                                @endif
                            </div>

                            <!-- Product Info -->
                            <div class="flex-grow flex flex-col justify-between">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <div class="text-[10px] uppercase font-bold text-slate-400 mb-1 flex items-center gap-1">
                                            <i class="fa-solid fa-store"></i> {{ $item->product->umkm->name }}
                                        </div>
                                        <a href="{{ route('products.show', $item->product) }}" class="text-lg font-bold text-slate-800 hover:text-indigo-600 transition-colors line-clamp-1">
                                            {{ $item->product->name }}
                                        </a>
                                        <p class="text-indigo-600 font-black mt-1">
                                            Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-red-50 text-red-500 hover:bg-red-500 hover:text-white flex items-center justify-center transition-colors" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-sm"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Quantity Controls -->
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                                    <p class="text-sm font-semibold text-slate-500">Total: <span class="text-slate-800 font-bold">Rp {{ number_format($itemTotal, 0, ',', '.') }}</span></p>
                                    
                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex items-center w-28 bg-white border border-slate-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-100">
                                            <button type="submit" name="quantity" value="{{ $item->quantity - 1 }}" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 bg-slate-50 transition-colors" @disabled($item->quantity <= 1)>
                                                <i class="fa-solid fa-minus text-[10px]"></i>
                                            </button>
                                            
                                            <input type="number" readonly value="{{ $item->quantity }}" class="w-12 h-8 text-center border-none text-sm font-bold text-slate-700 p-0 focus:ring-0">
                                            
                                            <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 bg-slate-50 transition-colors" @disabled($item->quantity >= $item->product->stock)>
                                                <i class="fa-solid fa-plus text-[10px]"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                                <span>Total Harga ({{ $cart->items->sum('quantity') }} barang)</span>
                                <span class="text-slate-700 font-medium">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                            <!-- Future tax or discount can go here -->
                        </div>
                        
                        <div class="border-t border-slate-100 pt-4 mb-8">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-800">Total Belanja</span>
                                <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <!-- Note about checkout -->
                        <a href="{{ route('checkout.index') }}" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-center shadow-lg shadow-indigo-200 focus:ring-4 focus:ring-indigo-100 transition-all flex justify-center items-center gap-2">
                            Lanjut ke Pembayaran
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        
                        <p class="text-center text-xs text-slate-400 mt-4 flex items-center justify-center gap-1 outline-none">
                            <i class="fa-solid fa-lock text-[10px]"></i> Transaksi aman
                        </p>
                    </div>
                </div>
            </div>
        @else
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
                <a href="{{ route('umkms.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition-all shadow-[0_8px_30px_rgb(79,70,229,0.2)] hover:shadow-[0_8px_30px_rgb(79,70,229,0.3)] transform hover:-translate-y-0.5">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
