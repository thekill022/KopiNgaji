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
                    @foreach ($cart->items as $item)
                        <div class="bg-white rounded-2xl p-4 sm:p-6 shadow-sm border border-slate-100 flex flex-col sm:flex-row gap-6 relative group transition-all hover:shadow-md cart-item"
                             data-item-id="{{ $item->id }}"
                             data-price="{{ $item->product->price }}"
                             data-stock="{{ $item->product->stock }}"
                             data-original-qty="{{ $item->quantity }}">
                            
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

                                <!-- Quantity Controls (JS-only, no form submit) -->
                                <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                                    <p class="text-sm font-semibold text-slate-500">Total: <span class="text-slate-800 font-bold item-total">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span></p>
                                    
                                    <div class="flex items-center w-28 bg-white border border-slate-200 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-indigo-100">
                                        <button type="button" class="qty-btn qty-minus w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-minus text-[10px]"></i>
                                        </button>
                                        
                                        <input type="number" readonly value="{{ $item->quantity }}" class="qty-input w-12 h-8 text-center border-none text-sm font-bold text-slate-700 p-0 focus:ring-0">
                                        
                                        <button type="button" class="qty-btn qty-plus w-8 h-8 flex items-center justify-center text-slate-400 hover:text-indigo-600 bg-slate-50 transition-colors">
                                            <i class="fa-solid fa-plus text-[10px]"></i>
                                        </button>
                                    </div>
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
                                <span>Total Harga (<span id="total-items">{{ $cart->items->sum('quantity') }}</span> barang)</span>
                                <span class="text-slate-700 font-medium" id="summary-price">Rp {{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        
                        <div class="border-t border-slate-100 pt-4 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-slate-800">Total Belanja</span>
                                <span class="text-2xl font-black text-indigo-600" id="grand-total">Rp {{ number_format($cart->items->sum(fn($i) => $i->product->price * $i->quantity), 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="button" id="checkout-btn" class="w-full py-4 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-center shadow-lg shadow-indigo-200 focus:ring-4 focus:ring-indigo-100 transition-all flex justify-center items-center gap-2">
                            Lanjut ke Pembayaran
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                        
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

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const checkoutBtn = document.getElementById('checkout-btn');
        let hasChanges = false;

        function formatRupiah(num) {
            return 'Rp ' + Math.round(num).toLocaleString('id-ID');
        }

        function recalcSummary() {
            let grandTotal = 0;
            let totalItems = 0;

            document.querySelectorAll('.cart-item').forEach(el => {
                const price = parseFloat(el.dataset.price);
                const qty = parseInt(el.querySelector('.qty-input').value);
                const itemTotal = price * qty;
                grandTotal += itemTotal;
                totalItems += qty;

                el.querySelector('.item-total').textContent = formatRupiah(itemTotal);
            });

            document.getElementById('summary-price').textContent = formatRupiah(grandTotal);
            document.getElementById('grand-total').textContent = formatRupiah(grandTotal);
            document.getElementById('total-items').textContent = totalItems;
        }

        function checkChanges() {
            hasChanges = false;
            document.querySelectorAll('.cart-item').forEach(el => {
                const originalQty = parseInt(el.dataset.originalQty);
                const currentQty = parseInt(el.querySelector('.qty-input').value);
                if (originalQty !== currentQty) {
                    hasChanges = true;
                }
            });
        }

        // Quantity buttons
        document.querySelectorAll('.qty-minus').forEach(btn => {
            btn.addEventListener('click', function () {
                const item = this.closest('.cart-item');
                const input = item.querySelector('.qty-input');
                let val = parseInt(input.value);
                if (val > 1) {
                    input.value = val - 1;
                    recalcSummary();
                    checkChanges();
                }
            });
        });

        document.querySelectorAll('.qty-plus').forEach(btn => {
            btn.addEventListener('click', function () {
                const item = this.closest('.cart-item');
                const input = item.querySelector('.qty-input');
                const stock = parseInt(item.dataset.stock);
                let val = parseInt(input.value);
                if (val < stock) {
                    input.value = val + 1;
                    recalcSummary();
                    checkChanges();
                }
            });
        });

        // Checkout button — auto-save quantities then redirect
        checkoutBtn.addEventListener('click', function () {
            if (!hasChanges) {
                window.location.href = '{{ route("checkout.index") }}';
                return;
            }

            const items = {};
            document.querySelectorAll('.cart-item').forEach(el => {
                items[el.dataset.itemId] = parseInt(el.querySelector('.qty-input').value);
            });

            checkoutBtn.disabled = true;
            checkoutBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';

            fetch('{{ route("cart.bulk-update") }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ items: items })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("checkout.index") }}';
                }
            })
            .catch(() => {
                checkoutBtn.disabled = false;
                checkoutBtn.innerHTML = 'Lanjut ke Pembayaran <i class="fa-solid fa-arrow-right"></i>';
                showToast('Gagal menyimpan perubahan. Coba lagi.', true);
            });
        });

        function showToast(message, isError = false) {
            const toast = document.createElement('div');
            toast.className = `fixed top-6 right-6 z-50 px-6 py-3 rounded-xl font-medium shadow-lg flex items-center gap-2 transition-all transform translate-x-0 ${isError ? 'bg-red-500 text-white' : 'bg-emerald-500 text-white'}`;
            toast.innerHTML = `<i class="fa-solid ${isError ? 'fa-circle-exclamation' : 'fa-circle-check'}"></i> ${message}`;
            document.body.appendChild(toast);
            setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2500);
        }
    });
    </script>
</x-app-layout>
