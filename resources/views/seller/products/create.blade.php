<x-seller-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.products.index') }}" class="text-indigo-200 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-plus-circle text-indigo-200"></i>
                {{ __('Tambah Produk') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('seller.products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Nama Produk -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Produk')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Tipe Produk -->
                        <div class="mb-4">
                            <x-input-label for="type" :value="__('Tipe Produk')" />
                            <select id="type" name="type"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                <option value="BARANG" {{ old('type', 'BARANG') === 'BARANG' ? 'selected' : '' }}>Barang</option>
                                <option value="JASA" {{ old('type', 'BARANG') === 'JASA' ? 'selected' : '' }}>Jasa</option>
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                            >{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Harga & Harga Modal -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="price" :value="__('Harga Jual (Rp)')" />
                                <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
                                    :value="old('price')" required />
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cost_price" :value="__('Harga Modal (Rp)')" />
                                <x-text-input id="cost_price" name="cost_price" type="number" step="0.01" class="mt-1 block w-full"
                                    :value="old('cost_price')" required />
                                <x-input-error :messages="$errors->get('cost_price')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Diskon & Stok -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <x-input-label for="discount" :value="__('Diskon (Rp)')" />
                                <x-text-input id="discount" name="discount" type="number" step="0.01" class="mt-1 block w-full"
                                    :value="old('discount', 0)" />
                                <x-input-error :messages="$errors->get('discount')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="stock" :value="__('Stok')" />
                                <x-text-input id="stock" name="stock" type="number" step="1" min="0" class="mt-1 block w-full"
                                    :value="old('stock', 0)" required />
                                <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Pre-order -->
                        <div class="mb-4">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="is_preorder" value="1"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                    {{ old('is_preorder') ? 'checked' : '' }}>
                                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Pre-order') }}</span>
                            </label>
                        </div>

                        <!-- Image Upload -->
                        <div class="mb-6">
                            <x-input-label for="images" :value="__('Foto Produk (maks 5)')" />
                            <input type="file" id="images" name="images[]" multiple accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0
                                file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300" />
                            <x-input-error :messages="$errors->get('images')" class="mt-2" />
                            <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                            <p class="text-xs text-gray-400 mt-1">Format: JPEG, PNG, JPG, WebP. Maks 2MB per gambar.</p>
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('seller.products.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                            <x-primary-button>
                                {{ __('Simpan Produk') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        form.addEventListener('submit', function(e) {
            clearErrors();
            let valid = true;

            const name = document.getElementById('name');
            if (!name.value.trim()) { showError(name, 'Nama produk wajib diisi.'); valid = false; }
            else if (name.value.trim().length > 255) { showError(name, 'Nama produk maksimal 255 karakter.'); valid = false; }

            const price = document.getElementById('price');
            if (!price.value || parseFloat(price.value) < 0) { showError(price, 'Harga jual harus minimal 0.'); valid = false; }

            const costPrice = document.getElementById('cost_price');
            if (!costPrice.value || parseFloat(costPrice.value) < 0) { showError(costPrice, 'Harga modal harus minimal 0.'); valid = false; }

            const discount = document.getElementById('discount');
            if (discount.value && parseFloat(discount.value) < 0) { showError(discount, 'Diskon tidak boleh negatif.'); valid = false; }

            const stock = document.getElementById('stock');
            if (!stock.value || parseInt(stock.value) < 0 || !Number.isInteger(Number(stock.value))) { showError(stock, 'Stok harus berupa bilangan bulat minimal 0.'); valid = false; }

            const images = document.getElementById('images');
            if (images.files.length > 5) { showError(images, 'Maksimal 5 gambar.'); valid = false; }
            else {
                for (const file of images.files) {
                    const validTypes = ['image/jpeg','image/png','image/jpg','image/webp'];
                    if (!validTypes.includes(file.type)) { showError(images, 'Format gambar harus JPEG, PNG, JPG, atau WebP.'); valid = false; break; }
                    if (file.size > 2 * 1024 * 1024) { showError(images, 'Setiap gambar maksimal 2MB.'); valid = false; break; }
                }
            }

            if (!valid) e.preventDefault();
        });

        function showError(el, msg) {
            const existing = el.parentElement.querySelector('.js-error');
            if (existing) return;
            const span = document.createElement('p');
            span.className = 'js-error text-red-500 text-sm mt-1';
            span.textContent = msg;
            el.parentElement.appendChild(span);
            el.classList.add('!border-red-400');
        }
        function clearErrors() {
            document.querySelectorAll('.js-error').forEach(el => el.remove());
            document.querySelectorAll('.\\!border-red-400').forEach(el => el.classList.remove('!border-red-400'));
        }
    });
    </script>
</x-seller-layout>
