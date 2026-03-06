<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
            <i class="fa-solid fa-chart-line text-indigo-200"></i>
            {{ __('Beranda Seller') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <!-- Dashboard Header Card -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 mb-8 relative overflow-hidden transition-all hover:shadow-md group">
            <div class="absolute right-0 top-0 w-64 h-64 bg-indigo-50 rounded-full translate-x-1/2 -translate-y-1/2 group-hover:scale-110 transition-transform duration-700 pointer-events-none blur-3xl opacity-50"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between">
                <div>
                    <h3 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-2">Halo, {{ Auth::user()->name }}! 👋</h3>
                    @if ($umkm)
                        <div class="flex items-center gap-3 text-emerald-600 bg-emerald-50 px-4 py-2 rounded-full inline-flex font-semibold shadow-sm border border-emerald-100 mt-2">
                           <i class="fa-solid fa-store bg-emerald-100 text-emerald-700 w-8 h-8 rounded-full flex items-center justify-center"></i> 
                           {{ $umkm->name }}
                        </div>
                    @else
                        <div class="mt-4 p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-lg inline-block">
                            <p class="text-amber-800 font-medium flex items-center gap-2">
                                <i class="fa-solid fa-exclamation-triangle"></i>
                                {{ __('Anda belum mendaftarkan UMKM. ') }}
                            </p>
                            <a href="{{ route('seller.umkm.create') }}" class="mt-3 inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-full transition-all shadow-md hover:-translate-y-1">
                                <i class="fa-solid fa-plus-circle mr-2"></i> {{ __('Daftar Sekarang') }}
                            </a>
                        </div>
                    @endif
                </div>
                <div class="hidden md:flex text-6xl text-slate-100">
                     <i class="fa-solid fa-building-user drop-shadow-sm group-hover:text-indigo-100 transition-colors duration-500"></i>
                </div>
            </div>
        </div>

        @if($umkm)
        <!-- Stats Row -->
        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
            <i class="fa-solid fa-chart-pie text-indigo-500"></i> Ringkasan Kinerja
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total Produk -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center justify-center relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:rotate-12 transition-transform shadow-inner">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="text-slate-500 font-bold text-sm tracking-wider uppercase mb-1">Total Produk</div>
                <div class="text-4xl font-extrabold text-slate-800">
                    {{ $stats['product_count'] }}
                </div>
            </div>

            <!-- Total Pesanan -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center justify-center relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:-rotate-12 transition-transform shadow-inner">
                    <i class="fa-solid fa-shopping-cart"></i>
                </div>
                <div class="text-slate-500 font-bold text-sm tracking-wider uppercase mb-1">Total Pesanan</div>
                <div class="text-4xl font-extrabold text-slate-800">
                    {{ $stats['order_count'] }}
                </div>
            </div>

            <!-- Pesanan Pending -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center justify-center relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="text-slate-500 font-bold text-sm tracking-wider uppercase mb-1">Menunggu Diproses</div>
                <div class="text-4xl font-extrabold text-amber-500">
                    {{ $stats['pending_orders'] }}
                </div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex flex-col items-center justify-center relative overflow-hidden group hover:-translate-y-1 transition-transform cursor-pointer">
                <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition-transform shadow-inner">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <div class="text-slate-500 font-bold text-sm tracking-wider uppercase mb-1">Pesanan Selesai</div>
                <div class="text-4xl font-extrabold text-emerald-600">
                    {{ $stats['completed_orders'] }}
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <h3 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2 mt-8">
            <i class="fa-solid fa-bolt text-indigo-500"></i> Aksi Cepat
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <a href="{{ route('seller.products.create') }}" class="flex items-center gap-6 p-6 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-3xl shadow-lg hover:-translate-y-1 hover:shadow-xl transition-all">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm shadow-inner">
                    <i class="fa-solid fa-plus text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl font-bold mb-1">Tambah Produk</h4>
                    <p class="text-indigo-100 text-sm">Tambahkan produk baru ke etalase toko Anda.</p>
                </div>
            </a>
            
            <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-6 p-6 bg-gradient-to-r from-slate-700 to-slate-900 border border-slate-800 text-white rounded-3xl shadow-lg hover:-translate-y-1 hover:shadow-xl transition-all">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center backdrop-blur-sm shadow-inner text-emerald-400">
                    <i class="fa-solid fa-boxes-packing text-2xl"></i>
                </div>
                <div>
                    <h4 class="text-2xl font-bold mb-1 font-sans">Kelola Pesanan</h4>
                    <p class="text-slate-400 text-sm">Lihat pesanan terbaru dan perbarui status pengiriman.</p>
                </div>
            </a>
        </div>
        @endif
    </div>
</x-seller-layout>
