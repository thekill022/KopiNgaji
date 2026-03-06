<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('UMKM Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('seller.umkm.update') }}">
                        @csrf
                        @method('PUT')

                        <!-- Nama UMKM -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama UMKM')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                :value="old('name', $umkm->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        @if (!$umkm->is_verified)
                            <div class="mb-4 p-3 bg-yellow-100 dark:bg-yellow-800 rounded">
                                <p class="text-yellow-800 dark:text-yellow-200 text-sm">
                                    {{ __('UMKM Anda masih menunggu verifikasi oleh admin. Produk dan pesanan akan aktif setelah diverifikasi.') }}
                                </p>
                            </div>
                        @endif

                        <!-- Deskripsi -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Deskripsi')" />
                            <textarea id="description" name="description" rows="4"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $umkm->description) }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Info Fee -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Informasi Platform Fee
                            </h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tipe: <span class="font-semibold">{{ ucfirst($umkm->platform_fee_type) }}</span>
                            </p>
                            @if ($umkm->platform_fee_type === 'percentage')
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Rate: <span class="font-semibold">{{ $umkm->platform_fee_rate }}%</span>
                                </p>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Flat: <span class="font-semibold">Rp
                                        {{ number_format($umkm->platform_fee_flat, 0, ',', '.') }}</span>
                                </p>
                            @endif
                            <p class="text-xs text-gray-400 mt-1">* Fee dikelola oleh admin</p>
                        </div>

                        <div class="flex items-center justify-end">
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
