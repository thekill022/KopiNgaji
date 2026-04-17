<x-seller-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.shipping-zones.index') }}" class="text-indigo-200 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-pen-to-square text-indigo-200"></i>
                {{ __('Edit Zona Pengiriman') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6"
                     x-data="{
                         provinces: [],
                         cities: [],
                         districts: [],
                         provinceId: '',
                         cityId: '',
                         selectedDistricts: [],
                         defaultProvinceId: '{{ $defaultProvinceId ?? '' }}',
                         defaultCityId: '{{ $defaultCityId ?? '' }}',
                         defaultSelected: {{ $shippingZone->areas->map(fn($a) => ['id' => $a->district_id, 'name' => $a->district?->name ?? $a->area_name])->values()->toJson() }},

                         async init() {
                             await this.fetchProvinces();
                             if (this.defaultProvinceId) {
                                 this.provinceId = this.defaultProvinceId;
                                 await this.fetchCities();
                                 if (this.defaultCityId) {
                                     this.cityId = this.defaultCityId;
                                     await this.fetchDistricts();
                                     this.selectedDistricts = JSON.parse(JSON.stringify(this.defaultSelected));
                                 }
                             }
                         },

                         async fetchProvinces() {
                             try {
                                 const res = await fetch('/api/regions/provinces');
                                 this.provinces = await res.json();
                             } catch (e) {
                                 console.error('Gagal memuat provinsi:', e);
                             }
                         },

                         async fetchCities() {
                             this.cities = [];
                             if (!this.provinceId) return;
                             try {
                                 const res = await fetch('/api/regions/provinces/' + this.provinceId + '/cities');
                                 this.cities = await res.json();
                             } catch (e) {
                                 console.error('Gagal memuat kota:', e);
                             }
                         },

                         async fetchDistricts() {
                             this.districts = [];
                             if (!this.cityId) return;
                             try {
                                 const res = await fetch('/api/regions/cities/' + this.cityId + '/districts');
                                 this.districts = await res.json();
                             } catch (e) {
                                 console.error('Gagal memuat kecamatan:', e);
                             }
                         },

                         onProvinceChange() {
                             this.cityId = '';
                             this.districts = [];
                             this.cities = [];
                             this.selectedDistricts = [];
                             this.fetchCities();
                         },

                         onCityChange() {
                             this.districts = [];
                             this.selectedDistricts = [];
                             this.fetchDistricts();
                         },

                         isSelected(id) {
                             return this.selectedDistricts.some(d => d.id === id);
                         },

                         toggleDistrict(district) {
                             const index = this.selectedDistricts.findIndex(d => d.id === district.id);
                             if (index >= 0) {
                                 this.selectedDistricts.splice(index, 1);
                             } else {
                                 this.selectedDistricts.push(district);
                             }
                         }
                     }"
                     x-init="init()">
                    <form method="POST" action="{{ route('seller.shipping-zones.update', $shippingZone) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Nama Zona')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $shippingZone->name)" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label for="cost" :value="__('Biaya Pengiriman (Rp)')" />
                            <x-text-input id="cost" name="cost" type="number" step="0.01" min="0" class="mt-1 block w-full" :value="old('cost', $shippingZone->cost)" required />
                            <x-input-error :messages="$errors->get('cost')" class="mt-2" />
                        </div>

                        <div class="mb-4">
                            <x-input-label :value="__('Pilih Wilayah')" />
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">Pilih provinsi dan kota/kabupaten untuk menampilkan daftar kecamatan.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Provinsi</label>
                                    <select x-model="provinceId" @change="onProvinceChange()"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">-- Pilih Provinsi --</option>
                                        <template x-for="p in provinces" :key="p.id">
                                            <option :value="p.id" x-text="p.name"></option>
                                        </template>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kabupaten/Kota</label>
                                    <select x-model="cityId" @change="onCityChange()" :disabled="!cities.length"
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50">
                                        <option value="">-- Pilih Kabupaten/Kota --</option>
                                        <template x-for="c in cities" :key="c.id">
                                            <option :value="c.id" x-text="c.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            <!-- Selected badges -->
                            <div x-show="selectedDistricts.length" class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kecamatan Terpilih</label>
                                <div class="flex flex-wrap gap-2">
                                    <template x-for="(d, idx) in selectedDistricts" :key="d.id">
                                        <span class="inline-flex items-center px-2.5 py-1 bg-indigo-100 text-indigo-800 text-sm rounded">
                                            <span x-text="d.name"></span>
                                            <button type="button" @click="toggleDistrict(d)" class="ml-1.5 w-5 h-5 inline-flex items-center justify-center bg-red-100 text-red-600 rounded hover:bg-red-200">
                                                <i class="fa-solid fa-xmark text-xs"></i>
                                            </button>
                                            <input type="hidden" name="district_ids[]" :value="d.id">
                                        </span>
                                    </template>
                                </div>
                            </div>

                            <!-- Districts checklist -->
                            <div x-show="districts.length" class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-900 max-h-64 overflow-y-auto">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Daftar Kecamatan</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                                    <template x-for="d in districts" :key="d.id">
                                        <label class="flex items-center space-x-2 cursor-pointer">
                                            <input type="checkbox" :value="d.id" :checked="isSelected(d.id)" @change="toggleDistrict(d)"
                                                class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                            <span class="text-sm text-gray-700 dark:text-gray-300" x-text="d.name"></span>
                                        </label>
                                    </template>
                                </div>
                            </div>

                            <x-input-error :messages="$errors->get('district_ids')" class="mt-2" />
                            <x-input-error :messages="$errors->get('district_ids.*')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <a href="{{ route('seller.shipping-zones.index') }}" class="px-4 py-2 bg-white text-indigo-700 font-semibold rounded-lg border border-indigo-200 hover:bg-indigo-50 transition">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition shadow-sm">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
