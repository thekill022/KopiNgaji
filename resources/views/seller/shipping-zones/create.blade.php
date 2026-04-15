<x-seller-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.shipping-zones.index') }}" class="text-indigo-200 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-plus-circle text-indigo-200"></i>
                {{ __('Tambah Zona Pengiriman') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('seller.shipping-zones.store') }}">
                        @csrf

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Zona')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="cost" :value="__('Biaya Pengiriman (Rp)')" />
                            <x-text-input id="cost" name="cost" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('cost', 0)" required />
                            <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Area Cakupan')" />
                            <div id="areas-container" class="space-y-2 mt-2">
                                <div class="flex gap-2 area-row">
                                    <x-text-input name="areas[]" type="text" class="block w-full" placeholder="Contoh: Kecamatan Klojen" required />
                                    <button type="button" class="px-3 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 remove-area-btn" onclick="removeArea(this)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" id="add-area-btn" class="mt-2 text-sm text-indigo-600 font-medium hover:underline">
                                <i class="fa-solid fa-plus"></i> Tambah Area
                            </button>
                            <x-input-error :messages="$errors->get('areas')" class="mt-2" />
                            <x-input-error :messages="$errors->get('areas.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('seller.shipping-zones.index') }}" class="text-gray-600 dark:text-gray-400 hover:underline">Batal</a>
                            <x-primary-button>{{ __('Simpan') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('add-area-btn').addEventListener('click', function() {
            const container = document.getElementById('areas-container');
            const row = document.createElement('div');
            row.className = 'flex gap-2 area-row';
            row.innerHTML = `
                <input type="text" name="areas[]" class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" placeholder="Contoh: Kecamatan Klojen" required />
                <button type="button" class="px-3 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 remove-area-btn" onclick="removeArea(this)">
                    <i class="fa-solid fa-trash"></i>
                </button>
            `;
            container.appendChild(row);
        });

        function removeArea(btn) {
            const rows = document.querySelectorAll('.area-row');
            if (rows.length > 1) {
                btn.closest('.area-row').remove();
            } else {
                alert('Minimal satu area wajib diisi.');
            }
        }
    </script>
</x-seller-layout>
