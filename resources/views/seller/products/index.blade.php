<x-seller-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center w-full">
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-box-open text-indigo-200"></i>
                {{ __('Produk') }}
            </h2>
            <a href="{{ route('seller.products.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2 bg-white text-indigo-700 font-bold rounded-full text-sm hover:bg-indigo-50 transition-colors shadow-sm">
                <i class="fa-solid fa-plus"></i> Tambah Produk
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="mb-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-4">
                <form method="GET" action="{{ route('seller.products.index') }}" id="product-filter-form" class="flex flex-col sm:flex-row gap-3 items-end">
                    <div class="flex-1 w-full relative">
                        <x-input-label for="search" :value="__('Cari')" class="mb-1" />
                        <div class="relative">
                            <x-text-input id="product-search" name="search" type="text" class="w-full pl-10" placeholder="Cari nama produk..."
                                :value="request('search')" autocomplete="off" />
                            <i class="fa-solid fa-search product-search-icon absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <i class="fa-solid fa-spinner fa-spin product-search-spinner absolute left-3 top-1/2 -translate-y-1/2 text-indigo-500 hidden"></i>
                        </div>
                    </div>
                    <div class="w-full sm:w-48">
                        <x-input-label for="status" :value="__('Status')" class="mb-1" />
                        <select id="status" name="status" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm">
                            <option value="">Semua Status</option>
                            <option value="PENDING" {{ request('status') === 'PENDING' ? 'selected' : '' }}>Pending</option>
                            <option value="APPROVED" {{ request('status') === 'APPROVED' ? 'selected' : '' }}>Approved</option>
                            <option value="REJECTED" {{ request('status') === 'REJECTED' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                </form>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                let debounceTimer;
                const input = document.getElementById('product-search');
                const form = document.getElementById('product-filter-form');
                const icon = form.querySelector('.product-search-icon');
                const spinner = form.querySelector('.product-search-spinner');

                input.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        icon.classList.add('hidden');
                        spinner.classList.remove('hidden');
                        form.submit();
                    }, 500);
                });

                document.getElementById('status').addEventListener('change', function() {
                    icon.classList.add('hidden');
                    spinner.classList.remove('hidden');
                    form.submit();
                });
            });
            </script>

            <!-- Products Table (Desktop) -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg hidden md:block">
                <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-2/5">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-20">Stok</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-28">Status</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-24">Penjualan</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($product->image_url)
                                            <img class="h-12 w-12 rounded-lg object-cover flex-shrink-0" src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-gray-100 dark:bg-gray-600 flex-shrink-0 flex items-center justify-center">
                                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</p>
                                            @if($product->is_preorder)
                                                <span class="text-xs text-indigo-500">Pre-order</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    @if($product->discount > 0)
                                        <p class="text-xs text-red-500 mt-0.5">Diskon: Rp {{ number_format($product->discount, 0, ',', '.') }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-sm font-medium {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-900 dark:text-gray-100' }}">
                                        {{ $product->stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($product->status === 'APPROVED')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">Approved</span>
                                    @elseif($product->status === 'PENDING')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">Pending</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button type="button"
                                        class="toggle-active-btn relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 {{ $product->is_active ? 'bg-green-500' : 'bg-gray-300' }}"
                                        data-product-id="{{ $product->id }}"
                                        data-url="{{ route('seller.products.toggle-active', $product) }}"
                                        data-active="{{ $product->is_active ? '1' : '0' }}"
                                        title="{{ $product->is_active ? 'Tutup Penjualan' : 'Buka Penjualan' }}">
                                        <span class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $product->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('seller.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 text-sm font-medium">Edit</a>
                                        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 text-sm font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                    <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Belum ada produk.</p>
                                    <a href="{{ route('seller.products.create') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:underline font-medium">+ Tambah produk pertama</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>

            <!-- Products Cards (Mobile) -->
            <div class="md:hidden space-y-4">
                @forelse($products as $product)
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            @if($product->image_url)
                                <img class="h-16 w-16 rounded-lg object-cover flex-shrink-0" src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                            @else
                                <div class="h-16 w-16 rounded-lg bg-gray-100 dark:bg-gray-600 flex-shrink-0 flex items-center justify-center">
                                    <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2">
                                    <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $product->name }}</p>
                                    @if($product->status === 'APPROVED')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 flex-shrink-0">Approved</span>
                                    @elseif($product->status === 'PENDING')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 flex-shrink-0">Pending</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 flex-shrink-0">Rejected</span>
                                    @endif
                                </div>
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mt-1">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Stok: <span class="{{ $product->stock <= 5 ? 'text-red-600 font-semibold' : '' }}">{{ $product->stock }}</span></span>
                                    <div class="flex items-center gap-3">
                                        <button type="button"
                                            class="toggle-active-btn relative inline-flex h-5 w-9 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $product->is_active ? 'bg-green-500' : 'bg-gray-300' }}"
                                            data-product-id="{{ $product->id }}"
                                            data-url="{{ route('seller.products.toggle-active', $product) }}"
                                            data-active="{{ $product->is_active ? '1' : '0' }}"
                                            title="{{ $product->is_active ? 'Tutup Penjualan' : 'Buka Penjualan' }}">
                                            <span class="pointer-events-none inline-block h-4 w-4 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $product->is_active ? 'translate-x-4' : 'translate-x-0' }}"></span>
                                        </button>
                                        <a href="{{ route('seller.products.edit', $product) }}" class="text-xs text-indigo-600 font-medium">Edit</a>
                                        <form method="POST" action="{{ route('seller.products.destroy', $product) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 font-medium">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                        <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">Belum ada produk.</p>
                        <a href="{{ route('seller.products.create') }}" class="mt-2 inline-block text-sm text-indigo-600 hover:underline font-medium">+ Tambah produk pertama</a>
                    </div>
                @endforelse

                <!-- Pagination (Mobile) -->
                @if($products->hasPages())
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        document.querySelectorAll('.toggle-active-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const url = this.dataset.url;
                const isActive = this.dataset.active === '1';
                const span = this.querySelector('span');

                // Optimistic toggle
                if (isActive) {
                    this.classList.remove('bg-green-500');
                    this.classList.add('bg-gray-300');
                    span.classList.remove('translate-x-5', 'translate-x-4');
                    span.classList.add('translate-x-0');
                    this.dataset.active = '0';
                    this.title = 'Buka Penjualan';
                } else {
                    this.classList.remove('bg-gray-300');
                    this.classList.add('bg-green-500');
                    span.classList.remove('translate-x-0');
                    // Desktop uses translate-x-5, mobile uses translate-x-4
                    span.classList.add(span.classList.contains('h-5') ? 'translate-x-5' : 'translate-x-4');
                    this.dataset.active = '1';
                    this.title = 'Tutup Penjualan';
                }

                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        // Show toast
                        const toast = document.createElement('div');
                        toast.className = 'fixed top-6 right-6 z-50 px-6 py-3 rounded-xl font-medium shadow-lg flex items-center gap-2 bg-emerald-500 text-white';
                        toast.innerHTML = '<i class="fa-solid fa-circle-check"></i> ' + data.message;
                        document.body.appendChild(toast);
                        setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 2500);
                    }
                });
            });
        });
    });
    </script>
</x-seller-layout>
