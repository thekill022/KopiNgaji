<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('seller.products.update', $product) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Produk -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $product->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $product->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Harga & Harga Modal -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="price" :value="__('Harga Jual (Rp)')" />
                                <x-text-input id="price" name="price" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('price', $product->price)" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cost_price" :value="__('Harga Modal (Rp)')" />
                                <x-text-input id="cost_price" name="cost_price" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('cost_price', $product->cost_price)" required />
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Diskon & Stok -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="discount" :value="__('Diskon (Rp)')" />
                                <x-text-input id="discount" name="discount" type="number" step="0.01"
                                    class="mt-1 block w-full" :value="old('discount', $product->discount)" />
                                <x-input-error :messages="$errors->get('discount')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="stock" :value="__('Stok')" />
                                <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full"
                                    :value="old('stock', $product->stock)" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Pre-order -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_preorder" value="1"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                    {{ old('is_preorder', $product->is_preorder) ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Pre-order') }}</span>
                            </label>
                        </div>

                        <!-- Existing Images -->
                        @if ($product->images->count() > 0)
                            <div class="mb-4">
                                <x-input-label :value="__('Foto Saat Ini')" />
                                <div class="grid grid-cols-3 gap-3 mt-2">
                                    @foreach ($product->images as $image)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $image->image_url) }}" alt="Product image"
                                                class="w-full h-32 object-cover rounded-lg">
                                            <button type="button"
                                                data-url="{{ route('seller.product-images.destroy', $image) }}"
                                                class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-700 delete-image-btn">
                                                ✕
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Images -->
                        <div class="mb-6">
                            <x-input-label for="images" :value="__('Tambah Foto Baru')" />
                            <input type="file" id="images" name="images[]" multiple accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300" />
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                            <p class="text-xs text-gray-400 mt-1">Format: JPEG, PNG, JPG, WebP. Maks 2MB per gambar.</p>

                            <!-- Preview of newly selected files -->
                            <div id="new-images-preview" class="grid grid-cols-3 gap-3 mt-2"></div>
                        </div>

                        <!-- Status Info -->
                        <div class="mb-6 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Status:
                                @if ($product->status === 'APPROVED')
                                    <span class="font-semibold text-green-600">Approved</span>
                                @elseif($product->status === 'PENDING')
                                    <span class="font-semibold text-yellow-600">Pending</span>
                                @else
                                    <span class="font-semibold text-red-600">Rejected</span>
                                @endif
                            </p>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('seller.products.index') }}"
                                class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                            <x-primary-button>
                                {{ __('Perbarui Produk') }}
                            </x-primary-button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('images').addEventListener('change', function(e) {
                            var preview = document.getElementById('new-images-preview');
                            preview.innerHTML = '';
                            Array.from(e.target.files).forEach(function(file) {
                                var img = document.createElement('img');
                                img.src = URL.createObjectURL(file);
                                img.className = 'w-full h-32 object-cover rounded-lg';
                                preview.appendChild(img);
                            });
                        });

                        // handle delete-image buttons
                        document.querySelectorAll('.delete-image-btn').forEach(function(btn) {
                            btn.addEventListener('click', function() {
                                if (!confirm('Hapus gambar ini?')) return;
                                var url = btn.getAttribute('data-url');
                                fetch(url, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json'
                                    }
                                }).then(function(res) {
                                    if (res.ok) {
                                        window.location.reload();
                                    } else {
                                        alert('Gagal menghapus gambar.');
                                    }
                                });
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
