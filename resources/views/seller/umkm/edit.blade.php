<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
            <i class="fa-solid fa-store text-indigo-200"></i>
            {{ __('UMKM Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100"
                     x-data="locationForm({
                         oldProvince: '{{ old('province_id', $umkm->province_id) }}',
                         oldCity: '{{ old('city_id', $umkm->city_id) }}',
                         oldDistrict: '{{ old('district_id', $umkm->district_id) }}',
                         oldVillage: '{{ old('village_id', $umkm->village_id) }}',
                         oldLatitude: '{{ old('latitude', $umkm->latitude) }}',
                         oldLongitude: '{{ old('longitude', $umkm->longitude) }}'
                     })">
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

                        <!-- Alamat Lengkap -->
                        <div class="mb-4">
                            <x-input-label for="address" :value="__('Alamat Lengkap')" />
                            <textarea id="address" name="address" rows="3"
                                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('address', $umkm->address) }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Cascade Wilayah -->
                        <div class="mb-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="province_id" :value="__('Provinsi')" />
                                <select id="province_id" name="province_id" x-model="provinceId"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <template x-for="p in provinces" :key="p.id">
                                        <option :value="p.id" x-text="p.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('province_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="city_id" :value="__('Kabupaten/Kota')" />
                                <select id="city_id" name="city_id" x-model="cityId" :disabled="!cities.length"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50">
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                    <template x-for="c in cities" :key="c.id">
                                        <option :value="c.id" x-text="c.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="district_id" :value="__('Kecamatan')" />
                                <select id="district_id" name="district_id" x-model="districtId" :disabled="!districts.length"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <template x-for="d in districts" :key="d.id">
                                        <option :value="d.id" x-text="d.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('district_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="village_id" :value="__('Desa/Kelurahan')" />
                                <select id="village_id" name="village_id" x-model="villageId" :disabled="!villages.length"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50">
                                    <option value="">-- Pilih Desa/Kelurahan --</option>
                                    <template x-for="v in villages" :key="v.id">
                                        <option :value="v.id" x-text="v.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('village_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Koordinat -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Lokasi Koordinat</h4>
                                <button type="button" @click="getLocation"
                                    class="text-sm px-3 py-1.5 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                    <i class="fa-solid fa-location-crosshairs mr-1"></i> Dapatkan Lokasi
                                </button>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="latitude" :value="__('Latitude')" />
                                    <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                        :value="old('latitude', $umkm->latitude)" x-model="latitude" readonly />
                                    <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="longitude" :value="__('Longitude')" />
                                    <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                        :value="old('longitude', $umkm->longitude)" x-model="longitude" readonly />
                                    <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                                </div>
                            </div>
                            <p x-show="geoError" x-text="geoError" class="text-red-500 text-sm mt-2"></p>
                        </div>

                        <!-- Info Fee -->
                        <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300 mb-2">Informasi Platform Fee</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Tipe: <span class="font-semibold">{{ ucfirst($umkm->platform_fee_type) }}</span>
                            </p>
                            @if ($umkm->platform_fee_type === 'percentage')
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Rate: <span class="font-semibold">{{ $umkm->platform_fee_rate }}%</span>
                                </p>
                            @else
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Flat: <span class="font-semibold">Rp {{ number_format($umkm->platform_fee_flat, 0, ',', '.') }}</span>
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

    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('locationForm', (defaults) => ({
            provinces: [],
            cities: [],
            districts: [],
            villages: [],
            provinceId: defaults.oldProvince || '',
            cityId: defaults.oldCity || '',
            districtId: defaults.oldDistrict || '',
            villageId: defaults.oldVillage || '',
            latitude: defaults.oldLatitude || '',
            longitude: defaults.oldLongitude || '',
            geoError: '',

            async init() {
                await this.loadProvinces();
                if (this.provinceId) await this.loadCities();
                if (this.cityId) await this.loadDistricts();
                if (this.districtId) await this.loadVillages();

                this.$watch('provinceId', (value) => {
                    this.onProvinceChange(value);
                });
                this.$watch('cityId', (value) => {
                    this.onCityChange(value);
                });
                this.$watch('districtId', (value) => {
                    this.onDistrictChange(value);
                });
            },

            async loadProvinces() {
                const res = await fetch('/api/regions/provinces');
                this.provinces = await res.json();
            },

            async onProvinceChange(value) {
                this.cityId = '';
                this.districtId = '';
                this.villageId = '';
                this.cities = [];
                this.districts = [];
                this.villages = [];
                if (!value) return;
                await this.loadCities();
            },

            async loadCities() {
                const res = await fetch(`/api/regions/provinces/${this.provinceId}/cities`);
                this.cities = await res.json();
            },

            async onCityChange(value) {
                this.districtId = '';
                this.villageId = '';
                this.districts = [];
                this.villages = [];
                if (!value) return;
                await this.loadDistricts();
            },

            async loadDistricts() {
                const res = await fetch(`/api/regions/cities/${this.cityId}/districts`);
                this.districts = await res.json();
            },

            async onDistrictChange(value) {
                this.villageId = '';
                this.villages = [];
                if (!value) return;
                await this.loadVillages();
            },

            async loadVillages() {
                const res = await fetch(`/api/regions/districts/${this.districtId}/villages`);
                this.villages = await res.json();
            },

            getLocation() {
                if (!navigator.geolocation) {
                    this.geoError = 'Browser Anda tidak mendukung geolokasi.';
                    return;
                }
                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        this.latitude = pos.coords.latitude;
                        this.longitude = pos.coords.longitude;
                        this.geoError = '';
                    },
                    (err) => {
                        this.geoError = 'Gagal mengambil lokasi: ' + err.message;
                    }
                );
            }
        }));
    });
    </script>
</x-seller-layout>
