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
                <div class="p-6 text-gray-900 dark:text-gray-100"
                     x-data="locationForm({
                         oldProvince: '{{ old('province_id') }}',
                         oldCity: '{{ old('city_id') }}',
                         oldDistrict: '{{ old('district_id') }}',
                         oldVillage: '{{ old('village_id') }}',
                         oldLatitude: '{{ old('latitude') }}',
                         oldLongitude: '{{ old('longitude') }}'
                     })">
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

                        <!-- Alamat Lengkap -->
                        <div class="mt-4">
                            <x-input-label for="address" :value="__('Alamat Lengkap')" />
                            <textarea id="address" name="address" rows="3"
                                class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('address') }}</textarea>
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>

                        <!-- Cascade Wilayah -->
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="province_id" :value="__('Provinsi')" />
                                <select id="province_id" name="province_id" x-model="provinceId"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
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
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 disabled:opacity-50">
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
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 disabled:opacity-50">
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
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 disabled:opacity-50">
                                    <option value="">-- Pilih Desa/Kelurahan --</option>
                                    <template x-for="v in villages" :key="v.id">
                                        <option :value="v.id" x-text="v.name"></option>
                                    </template>
                                </select>
                                <x-input-error :messages="$errors->get('village_id')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Koordinat & Peta -->
                        <div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-600 dark:text-gray-300">Pilih Lokasi di Peta</h4>
                                <button type="button" @click="getLocation"
                                    class="text-sm px-3 py-1.5 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">
                                    <i class="fa-solid fa-location-crosshairs mr-1"></i> Dapatkan Lokasi Saya
                                </button>
                            </div>
                            <div id="umkm-map" class="w-full h-72 rounded-lg border border-gray-300 dark:border-gray-600 z-0"></div>
                            <div class="grid grid-cols-2 gap-4 mt-3">
                                <div>
                                    <x-input-label for="latitude" :value="__('Latitude')" />
                                    <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full"
                                        :value="old('latitude')" x-model="latitude" readonly />
                                    <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="longitude" :value="__('Longitude')" />
                                    <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full"
                                        :value="old('longitude')" x-model="longitude" readonly />
                                    <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                                </div>
                            </div>
                            <p x-show="geoError" x-text="geoError" class="text-red-500 text-sm mt-2"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                <i class="fa-solid fa-hand-pointer mr-1"></i> Klik di peta atau geser marker untuk menentukan lokasi.
                            </p>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Daftar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
            map: null,
            marker: null,

            async init() {
                await this.loadProvinces();
                if (this.provinceId) await this.loadCities();
                if (this.cityId) await this.loadDistricts();
                if (this.districtId) await this.loadVillages();

                this.$watch('provinceId', (value) => { this.onProvinceChange(value); });
                this.$watch('cityId', (value) => { this.onCityChange(value); });
                this.$watch('districtId', (value) => { this.onDistrictChange(value); });

                this.$nextTick(() => this.initMap());
            },

            initMap() {
                const defaultLat = -2.5489;
                const defaultLng = 118.0149;
                const lat = parseFloat(this.latitude) || defaultLat;
                const lng = parseFloat(this.longitude) || defaultLng;
                const zoom = (this.latitude && this.longitude) ? 15 : 5;

                this.map = L.map('umkm-map').setView([lat, lng], zoom);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(this.map);

                this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);

                this.marker.on('dragend', (e) => {
                    const pos = e.target.getLatLng();
                    this.latitude = pos.lat.toFixed(7);
                    this.longitude = pos.lng.toFixed(7);
                });

                this.map.on('click', (e) => {
                    this.marker.setLatLng(e.latlng);
                    this.latitude = e.latlng.lat.toFixed(7);
                    this.longitude = e.latlng.lng.toFixed(7);
                });
            },

            updateMapPosition(lat, lng) {
                if (!this.map || !this.marker) return;
                this.map.setView([lat, lng], 16);
                this.marker.setLatLng([lat, lng]);
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
                        this.latitude = pos.coords.latitude.toFixed(7);
                        this.longitude = pos.coords.longitude.toFixed(7);
                        this.geoError = '';
                        this.updateMapPosition(pos.coords.latitude, pos.coords.longitude);
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
