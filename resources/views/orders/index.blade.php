<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-8">
            <i class="fa-solid fa-clipboard-list text-indigo-500 mr-2"></i> Daftar Pesanan
        </h1>

        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-700 font-medium">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $order->qr_code }}</p>
                                <p class="text-xl font-bold text-slate-800">{{ $order->umkm->name }}</p>
                            </div>
                            <div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $order->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-700' :
                                       ($order->status === 'PAID' ? 'bg-blue-100 text-blue-700' :
                                       ($order->status === 'PENDING' ? 'bg-amber-100 text-amber-700' : 
                                       'bg-red-100 text-red-700')) }}">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-end gap-4 border-t border-slate-100 pt-4 mt-4 text-sm text-slate-600">
                            <div>
                                <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method === 'CASH' ? 'Tunai' : 'Non-Tunai (Doku)' }}</p>
                                <p><strong>Tipe Pengiriman:</strong> {{ $order->delivery_method === 'AMBIL_LOKASI' ? 'Ambil di Tempat' : 'Kirim Alamat' }}</p>
                                <p class="mt-2 text-indigo-600 font-bold text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('orders.show', $order) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-100 transition-colors">
                                Detail Pesanan <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center bg-white p-16 rounded-3xl border border-slate-100 shadow-sm mt-8">
                <i class="fa-solid fa-box-open text-6xl text-slate-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Belum ada pesanan</h3>
                <p class="text-slate-500 mb-6">Mulai belanja dan temukan berbagai produk menarik.</p>
                <a href="{{ route('umkms.index') }}" class="inline-block bg-indigo-600 font-bold text-white px-6 py-3 rounded-full hover:bg-indigo-700 transition">Belanja Sekarang</a>
            </div>
        @endif
    </div>
</x-app-layout>
