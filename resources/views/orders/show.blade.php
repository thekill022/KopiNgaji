<x-app-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:text-indigo-700 bg-indigo-50 p-2 rounded-full transition-colors flex items-center justify-center w-10 h-10">
                <i class="fa-solid fa-arrow-left text-lg"></i>
            </a>
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                    <i class="fa-solid fa-file-invoice text-indigo-500 mr-2"></i> Detail Pesanan
                </h1>
                <p class="text-slate-500 text-sm font-mono mt-1 font-bold">{{ $order->qr_code }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-8 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -z-10 opacity-50"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Order Information -->
                <div class="space-y-6">
                    <div>
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Status Pembayaran</h2>
                        <span class="inline-block px-4 py-1.5 rounded-full text-sm font-bold uppercase
                            {{ $order->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-700' :
                               ($order->status === 'PAID' ? 'bg-blue-100 text-blue-700' :
                               ($order->status === 'PENDING' ? 'bg-amber-100 text-amber-700' : 
                               'bg-red-100 text-red-700')) }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    @if($order->refunds->count() > 0)
                        <div class="mt-4">
                            <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-2">Refund</h2>
                            @foreach($order->refunds as $refund)
                                <div class="bg-white border border-slate-200 rounded-xl p-3 mb-2">
                                    <div class="flex justify-between items-center">
                                        <span class="font-bold text-slate-800">Rp {{ number_format($refund->amount, 0, ',', '.') }}</span>
                                        <span class="text-xs px-2 py-1 rounded-full {{ $refund->status === 'APPROVED' ? 'bg-green-100 text-green-700' : ($refund->status === 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                            {{ $refund->status }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-600 mt-1">{{ $refund->reason }}</p>
                                    @if($refund->refunded_at)
                                        <p class="text-xs text-slate-400 mt-1">Diproses {{ $refund->refunded_at->format('d M Y, H:i') }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Pesanan</h2>
                        <p class="text-slate-800 font-bold text-lg">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <div>
                        <h2 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-1">Metode & Pengiriman</h2>
                        <p class="text-slate-800 font-medium">Pembayaran: <strong>{{ $order->payment_method === 'CASH' ? 'Tunai (Bayar di Tempat)' : 'Doku Non-Tunai' }}</strong></p>
                        <p class="text-slate-800 font-medium mt-1">Pengiriman: <strong>{{ $order->delivery_method === 'AMBIL_LOKASI' ? 'Ambil di Tempat' : 'Kirim Alamat' }}</strong></p>
                        @if($order->delivery_method === 'KIRIM_ALAMAT')
                            <p class="text-slate-600 mt-2 bg-slate-50 p-3 rounded-xl border border-slate-100 text-sm">
                                <strong>Alamat:</strong> <br>{{ $order->shipping_address }}
                            </p>
                        @endif
                    </div>
                </div>

                <!-- QR Code Validasi Pesanan -->
                <div class="flex flex-col items-center justify-center p-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl text-center">
                    @if($order->status === 'PAID' || $order->payment_method === 'CASH')
                        <h2 class="text-lg font-bold text-slate-800 mb-2">QR Code Pesanan</h2>
                        <p class="text-slate-500 text-xs mb-6 max-w-xs leading-relaxed">
                            Tunjukkan QR Code ini kepada pemilik/kasir UMKM untuk <strong>memvalidasi pesanan dan menyelesaikan transaksi</strong>.
                        </p>
                        <div class="bg-white p-4 rounded-2xl shadow-sm inline-block">
                            {!! QrCode::size(200)->generate(route('seller.orders.show', ['order' => $order->id, 'scanned' => 'true'])) !!}
                        </div>
                        <p class="mt-4 text-indigo-600 font-bold font-mono tracking-widest">{{ $order->qr_code }}</p>
                    @elseif($order->status === 'PENDING' && $order->payment_method === 'NON_CASH')
                        <h2 class="text-lg font-bold text-slate-800 mb-2">Selesaikan Pembayaran</h2>
                        <p class="text-slate-500 text-xs mb-6 max-w-xs leading-relaxed">
                            QR Code akan tersedia setelah Anda menyelesaikan pembayaran via DokuPay.
                        </p>
                        <div class="w-48 h-48 bg-slate-200 flex items-center justify-center text-slate-400 rounded-2xl">
                            <i class="fa-solid fa-qrcode text-4xl"></i>
                        </div>
                        
                        @if($order->doku_payment_url)
                            <a href="{{ $order->doku_payment_url }}" class="mt-6 w-full max-w-[200px] text-center bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-indigo-700 shadow-md">
                                Bayar Sekarang
                            </a>
                        @endif
                    @endif
                </div>
            </div>
            
            <div class="border-t border-slate-100 mt-8 pt-8 pt-4">
                <h2 class="text-lg font-bold text-slate-800 mb-4">Ringkasan Harga</h2>
                <div class="flex justify-between items-center bg-slate-50 p-6 rounded-2xl border border-slate-100">
                    <span class="text-slate-500 font-medium">Total Harga</span>
                    <span class="text-3xl font-black text-indigo-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
