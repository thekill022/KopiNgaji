<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
            <i class="fa-solid fa-store text-indigo-200"></i>
            {{ __('Daftar UMKM') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('seller.umkm.store') }}">
                        @csrf

                        <!-- Nama UMKM -->
                        <div>
                            <x-input-label for="name" :value="__('Nama UMKM')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-4">
                            <x-input-label for="description" :value="__('Deskripsi (opsional)')" />
                            <textarea id="description" name="description" rows="4"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('Daftar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('form').addEventListener('submit', function(e) {
            document.querySelectorAll('.js-error').forEach(el => el.remove());
            let valid = true;
            const name = document.getElementById('name');
            if (!name.value.trim()) {
                const span = document.createElement('p');
                span.className = 'js-error text-red-500 text-sm mt-1';
                span.textContent = 'Nama UMKM wajib diisi.';
                name.parentElement.appendChild(span);
                valid = false;
            } else if (name.value.trim().length > 255) {
                const span = document.createElement('p');
                span.className = 'js-error text-red-500 text-sm mt-1';
                span.textContent = 'Nama UMKM maksimal 255 karakter.';
                name.parentElement.appendChild(span);
                valid = false;
            }
            if (!valid) e.preventDefault();
        });
    });
    </script>
</x-seller-layout>
