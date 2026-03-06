<x-seller-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.orders.index') }}" class="text-indigo-200 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-receipt text-indigo-200"></i>
                Pesanan #{{ $order->id }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Order Info & Status -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Pesanan</h3>
                        <div class="mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                            <p>Tanggal: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $order->created_at->format('d M Y, H:i') }}</span></p>
                            <p>Metode Pembayaran: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $order->payment_method ?? '-' }}</span></p>
                        </div>
                    </div>
                    <div class="text-right">
                        @if($order->status === 'COMPLETED')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">✓ Completed</span>
                        @elseif($order->status === 'PAID')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Paid</span>
                        @elseif($order->status === 'PENDING')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Cancelled</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Buyer Info -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-3">Informasi Pembeli</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Nama</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->buyer->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">WhatsApp</p>
                        @if($order->whatsapp)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->whatsapp) }}" target="_blank"
                               class="font-medium text-green-600 hover:underline">{{ $order->whatsapp }}</a>
                        @else
                            <p class="text-gray-900 dark:text-gray-100">-</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Email</p>
                        <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->buyer->email ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 pb-3">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Daftar Item</h3>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Produk</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase w-20">Qty</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Harga</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $item->product->name ?? 'Produk dihapus' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-center">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 text-right">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Financial Summary -->
                <div class="border-t border-gray-200 dark:border-gray-700 p-6">
                    <div class="max-w-xs ml-auto space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                            <span class="text-gray-900 dark:text-gray-100">Rp {{ number_format($order->subtotal_amount, 0, ',', '.') }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-500 dark:text-gray-400">Diskon</span>
                                <span class="text-red-500">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-500 dark:text-gray-400">Platform Fee</span>
                            <span class="text-gray-900 dark:text-gray-100">Rp {{ number_format($order->platform_fee_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-700 font-semibold">
                            <span class="text-gray-900 dark:text-gray-100">Total</span>
                            <span class="text-gray-900 dark:text-gray-100">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-green-600 font-medium">
                            <span>Pendapatan Bersih</span>
                            <span>Rp {{ number_format($order->net_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            @if(in_array($order->status, ['PENDING', 'PAID']))
                @php
                    $canComplete = request('scanned') === 'true' && ($order->status === 'PAID' || ($order->status === 'PENDING' && $order->payment_method === 'CASH'));
                    $canCancel = $order->payment_method === 'CASH' && $order->status === 'PENDING';
                @endphp
                
                @if($canComplete || $canCancel)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Aksi</h3>
                        <div class="flex flex-wrap gap-3">
                            @if($canComplete)
                                <form method="POST" action="{{ route('seller.orders.update-status', $order) }}" onsubmit="return confirm('Yakin ingin menyelesaikan pesanan ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="COMPLETED">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                        ✓ Selesaikan Pesanan
                                    </button>
                                </form>
                            @endif

                            @if($canCancel)
                                <form method="POST" action="{{ route('seller.orders.update-status', $order) }}" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="CANCELLED">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition">
                                        ✕ Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-seller-layout>
