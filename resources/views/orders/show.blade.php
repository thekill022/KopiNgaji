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

                <!-- QR Code Validasi Pesanan & Completion -->
                <div class="flex flex-col items-center justify-center p-6 bg-slate-50 border-2 border-dashed border-slate-200 rounded-3xl text-center">
                    @if($order->status === 'PAID' || ($order->status === 'PENDING' && $order->payment_method === 'CASH'))
                        <h2 class="text-lg font-bold text-slate-800 mb-2">QR Code Pesanan</h2>
                        <p class="text-slate-500 text-xs mb-4 max-w-xs leading-relaxed">
                            Tunjukkan QR Code ini kepada pemilik/kasir UMKM untuk <strong>memvalidasi pesanan dan menyelesaikan transaksi</strong>.
                        </p>
                        <div class="bg-white p-4 rounded-2xl shadow-sm inline-block">
                            {!! QrCode::size(180)->generate(route('seller.orders.show', ['order' => $order->id, 'scanned' => 'true'])) !!}
                        </div>
                        <p class="mt-3 text-indigo-600 font-bold font-mono tracking-widest text-sm">{{ $order->qr_code }}</p>

                        @if($order->seller_completion_notified_at && !$order->buyer_completed_at)
                            <div class="mt-4 w-full bg-amber-50 border border-amber-100 rounded-xl p-3">
                                <p class="text-sm text-amber-700 font-medium"><i class="fa-solid fa-bell mr-1"></i> Penjual telah mengkonfirmasi pengiriman. Silakan tekan "Selesai" jika pesanan sudah diterima.</p>
                            </div>

                            <form method="POST" action="{{ route('orders.complete', $order) }}" class="mt-4 w-full max-w-xs">
                                @csrf
                                <button type="submit" class="w-full px-5 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition shadow-md">
                                    <i class="fa-solid fa-check-circle mr-2"></i> Selesaikan Pesanan
                                </button>
                            </form>
                        @elseif(!$order->seller_completion_notified_at)
                            <div class="mt-4 w-full bg-slate-100 border border-slate-200 rounded-xl p-3">
                                <p class="text-sm text-slate-600 font-medium"><i class="fa-solid fa-clock mr-1"></i> Menunggu konfirmasi pengiriman dari penjual.</p>
                            </div>
                        @endif

                        <div id="push-enable-banner" class="mt-4 w-full max-w-xs bg-blue-50 border border-blue-100 rounded-xl p-3 hidden">
                            <p class="text-sm text-blue-700 font-medium mb-2">
                                <i class="fa-solid fa-bell mr-1"></i> Aktifkan notifikasi agar mendapat update dari penjual.
                            </p>
                            <button type="button" onclick="enablePush()" class="w-full text-sm px-3 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                Izinkan Notifikasi
                            </button>
                        </div>
                        <script>
                        function enablePush() {
                            if (typeof window.requestPushNotification === 'function') {
                                window.requestPushNotification().then(granted => {
                                    if (granted) {
                                        document.getElementById('push-enable-banner').classList.add('hidden');
                                    }
                                });
                            }
                        }
                        if (('Notification' in window) && Notification.permission === 'default') {
                            document.getElementById('push-enable-banner').classList.remove('hidden');
                        }
                        </script>
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
                    @elseif($order->status === 'COMPLETED')
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-check text-emerald-600 text-3xl"></i>
                        </div>
                        <h2 class="text-lg font-bold text-slate-800 mb-1">Pesanan Selesai</h2>
                        <p class="text-slate-500 text-xs max-w-xs leading-relaxed">Terima kasih telah berbelanja di KopiNgaji.</p>
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

            {{-- Refund History --}}
            @if($order->refunds->count() > 0)
                <div class="border-t border-slate-100 mt-8 pt-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">
                        <i class="fa-solid fa-rotate-left text-purple-500 mr-2"></i>Riwayat Refund
                    </h2>
                    <div class="space-y-3">
                        @foreach($order->refunds as $refund)
                            <div class="bg-white border border-slate-200 rounded-xl p-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="font-bold text-slate-800">Rp {{ number_format($refund->amount, 0, ',', '.') }}</span>
                                        @if($refund->requested_by === 'BUYER')
                                            <span class="text-xs bg-blue-50 text-blue-600 px-2 py-0.5 rounded-full ml-2">Diajukan Anda</span>
                                        @else
                                            <span class="text-xs bg-slate-50 text-slate-500 px-2 py-0.5 rounded-full ml-2">Dari Penjual</span>
                                        @endif
                                    </div>
                                    <span class="text-xs px-3 py-1 rounded-full font-bold
                                        {{ $refund->status === 'APPROVED' ? 'bg-green-100 text-green-700' : ($refund->status === 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                        {{ $refund->status === 'APPROVED' ? 'Disetujui' : ($refund->status === 'REJECTED' ? 'Ditolak' : 'Menunggu') }}
                                    </span>
                                </div>
                                <p class="text-sm text-slate-600 mt-2">{{ $refund->reason }}</p>
                                @if($refund->refunded_at)
                                    <p class="text-xs text-slate-400 mt-1">Diproses {{ $refund->refunded_at->format('d M Y, H:i') }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Buyer Refund Request Button --}}
            @if(in_array($order->status, ['PAID', 'COMPLETED']) && !$order->refunds->where('status', 'PENDING')->where('requested_by', 'BUYER')->count())
                <div class="border-t border-slate-100 mt-8 pt-6">
                    <div class="bg-purple-50 border border-purple-100 rounded-2xl p-6">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                            <div>
                                <h3 class="text-base font-bold text-purple-900">
                                    <i class="fa-solid fa-rotate-left mr-2"></i>Ajukan Refund
                                </h3>
                                <p class="text-sm text-purple-700 mt-1">
                                    @if($order->payment_method === 'CASH')
                                        Refund tunai akan diproses oleh penjual secara langsung.
                                    @else
                                        Refund non-tunai akan diajukan ke penjual, lalu diproses via DOKU.
                                    @endif
                                </p>
                            </div>
                            <button type="button"
                                    onclick="document.getElementById('buyer-refund-modal').classList.remove('hidden')"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-purple-600 text-white text-sm font-bold rounded-xl hover:bg-purple-700 transition shadow-sm whitespace-nowrap">
                                <i class="fa-solid fa-paper-plane"></i> Ajukan Refund
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Refund Modal --}}
                <div id="buyer-refund-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
                    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-6 relative">
                        <button type="button" onclick="document.getElementById('buyer-refund-modal').classList.add('hidden')"
                                class="absolute top-4 right-4 text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>

                        <div class="text-center mb-5">
                            <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-rotate-left text-purple-600 text-2xl"></i>
                            </div>
                            <h4 class="text-lg font-bold text-slate-900">Ajukan Refund</h4>
                            <p class="text-sm text-slate-500 mt-1">
                                Pesanan <span class="font-mono font-bold">{{ $order->qr_code }}</span>
                            </p>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-4 mb-5">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-slate-500">Jumlah refund</span>
                                <span class="text-lg font-bold text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Refund penuh sesuai total harga pesanan</p>
                        </div>

                        @if($order->payment_method === 'CASH')
                            <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 mb-5 text-sm text-amber-700">
                                <i class="fa-solid fa-info-circle mr-1"></i>
                                <strong>Refund Tunai:</strong> Penjual akan memproses pengembalian uang secara langsung setelah disetujui.
                            </div>
                        @else
                            <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 mb-5 text-sm text-blue-700">
                                <i class="fa-solid fa-info-circle mr-1"></i>
                                <strong>Refund Non-Tunai:</strong> Setelah disetujui penjual, Admin akan memproses refund via DOKU.
                            </div>
                        @endif

                        <form method="POST" action="{{ route('orders.refund', $order) }}">
                            @csrf
                            <div class="mb-5">
                                <label for="buyer-refund-reason" class="block text-sm font-semibold text-slate-700 mb-2">
                                    Alasan Refund <span class="text-red-500">*</span>
                                </label>
                                <textarea name="reason" id="buyer-refund-reason" rows="3" required
                                          class="w-full rounded-xl border-slate-300 focus:border-purple-500 focus:ring-purple-500 text-sm"
                                          placeholder="Jelaskan alasan Anda mengajukan refund..."></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="button"
                                        onclick="document.getElementById('buyer-refund-modal').classList.add('hidden')"
                                        class="flex-1 px-4 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-medium text-sm hover:bg-slate-50 transition">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="flex-1 px-4 py-2.5 rounded-xl bg-purple-600 text-white font-bold text-sm hover:bg-purple-700 transition">
                                    <i class="fa-solid fa-paper-plane mr-1"></i> Kirim Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($order->refunds->where('status', 'PENDING')->where('requested_by', 'BUYER')->count())
                <div class="border-t border-slate-100 mt-8 pt-6">
                    <div class="bg-amber-50 border border-amber-100 rounded-2xl p-6 text-center">
                        <i class="fa-solid fa-clock text-amber-500 text-2xl mb-2"></i>
                        <h3 class="text-base font-bold text-amber-800">Pengajuan Refund Sedang Diproses</h3>
                        <p class="text-sm text-amber-700 mt-1">Silakan tunggu konfirmasi dari penjual untuk pengajuan refund Anda.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
