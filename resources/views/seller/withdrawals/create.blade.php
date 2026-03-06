<x-seller-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('seller.withdrawals.index') }}" class="text-indigo-200 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-wallet text-indigo-200"></i>
                {{ __('Tarik Dana') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 shadow-sm" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @php
                        $dokuFee         = (float) env('DOKU_WITHDRAWAL_FEE', 6500);
                        $thresholdActive = $umkm->tax_threshold > 0 && $totalEarnings > $umkm->tax_threshold;
                        $feeLabel        = $umkm->platform_fee_type === 'percentage'
                            ? $umkm->platform_fee_rate . '%'
                            : 'Rp ' . number_format($umkm->platform_fee_flat, 0, ',', '.');
                    @endphp

                    <!-- Saldo Tersedia -->
                    <div class="mb-8 p-4 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-wallet text-indigo-500 text-2xl"></i>
                            <div>
                                <p class="text-sm font-semibold text-indigo-800 dark:text-indigo-300">Saldo Tersedia</p>
                                <p class="text-2xl font-bold font-mono text-gray-900 dark:text-gray-100">Rp {{ number_format($availableBalance, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @if($umkm->tax_threshold > 0)
                            <div class="text-right text-xs max-w-[200px] {{ $thresholdActive ? 'text-orange-500 font-semibold' : 'text-indigo-500' }}">
                                @if($thresholdActive)
                                    <i class="fa-solid fa-triangle-exclamation mr-1"></i>
                                    Komisi platform aktif — kumulatif Anda melebihi batas Rp {{ number_format($umkm->tax_threshold, 0, ',', '.') }}
                                @else
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    Komisi platform belum berlaku (kumulatif: Rp {{ number_format($totalEarnings, 0, ',', '.') }} dari batas Rp {{ number_format($umkm->tax_threshold, 0, ',', '.') }})
                                @endif
                            </div>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('seller.withdrawals.store') }}" class="space-y-6" id="withdrawal-form">
                        @csrf

                        <!-- Nominal -->
                        <div>
                            <x-input-label for="amount" value="Nominal Penarikan (Min: Rp 50.000)" />
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-lg font-bold">Rp</span>
                                </div>
                                <input type="number" name="amount" id="amount"
                                    class="pl-10 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-lg py-3 transition-colors {{ $errors->has('amount') ? 'border-red-500' : '' }}"
                                    placeholder="0" min="50000" max="{{ max(50000, $availableBalance) }}"
                                    value="{{ old('amount', $availableBalance >= 50000 ? $availableBalance : '') }}" required />
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>

                        <!-- Rincian Potongan Live -->
                        <div class="rounded-xl border border-slate-200 dark:border-gray-700 overflow-hidden text-sm">
                            <div class="bg-slate-50 dark:bg-gray-700 px-4 py-2.5 font-semibold text-slate-600 dark:text-slate-300 text-xs uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-solid fa-calculator text-indigo-400"></i> Rincian Potongan
                            </div>
                            <div class="divide-y divide-slate-100 dark:divide-gray-700">
                                <!-- Bruto -->
                                <div class="flex justify-between px-4 py-3">
                                    <span class="text-slate-500">Jumlah Penarikan</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200" id="preview-gross">Rp 0</span>
                                </div>

                                <!-- Komisi Platform (hanya muncul jika threshold terlampaui) -->
                                @if($thresholdActive)
                                    <div class="flex justify-between px-4 py-3">
                                        <span class="text-orange-500 flex items-center gap-1">
                                            <i class="fa-solid fa-percent text-xs"></i>
                                            Komisi Platform ({{ $feeLabel }})
                                        </span>
                                        <span class="font-semibold text-orange-500" id="preview-platform-fee">- Rp 0</span>
                                    </div>
                                @else
                                    <div class="flex justify-between px-4 py-3 opacity-40">
                                        <span class="text-slate-400 flex items-center gap-1 text-xs italic">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                            Komisi Platform ({{ $feeLabel }}) — belum aktif
                                        </span>
                                        <span class="text-slate-400 text-xs">Rp 0</span>
                                    </div>
                                @endif

                                <!-- Biaya Admin DOKU -->
                                <div class="flex justify-between px-4 py-3">
                                    <span class="text-red-400 flex items-center gap-1">
                                        <i class="fa-solid fa-building-columns text-xs"></i>
                                        Biaya Transfer DOKU
                                    </span>
                                    <span class="font-semibold text-red-400">- Rp {{ number_format($dokuFee, 0, ',', '.') }}</span>
                                </div>

                                <!-- Neto -->
                                <div class="flex justify-between px-4 py-3 bg-emerald-50 dark:bg-emerald-900/20">
                                    <span class="font-bold text-emerald-700 dark:text-emerald-400">Yang Diterima ke Rekening</span>
                                    <span class="font-bold text-emerald-700 dark:text-emerald-400 text-base" id="preview-net">Rp 0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Bank / E-Wallet Info -->
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 space-y-4">

                            {{-- Nama Pemilik Rekening --}}
                            <div>
                                <x-input-label for="account_name" value="Nama Pemilik Rekening (sesuai buku tabungan / e-wallet)" />
                                <x-text-input id="account_name" name="account_name" type="text" class="mt-1 block w-full" :value="old('account_name')" placeholder="Contoh: Budi Santoso" required />
                                <p class="text-xs text-gray-400 mt-1">Harus sama persis dengan nama yang terdaftar di bank/e-wallet. Digunakan untuk validasi transfer.</p>
                                <x-input-error class="mt-1" :messages="$errors->get('account_name')" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                {{-- Pilih Bank / E-Wallet --}}
                                <div>
                                    <x-input-label for="bank_name" value="Bank / E-Wallet Tujuan" />
                                    {{--
                                        value format: "NAMA_TAMPIL|DOKU_CODE"
                                        DOKU bank codes: https://docs.doku.com
                                    --}}
                                    <select id="bank_name" name="bank_name" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="syncBankCode(this)">
                                        <option value="" disabled {{ old('bank_name') ? '' : 'selected' }}>Pilih Bank/E-Wallet...</option>
                                        <optgroup label="🏦 Bank Nasional">
                                            <option value="BCA"       data-code="014" {{ old('bank_name') == 'BCA'       ? 'selected' : '' }}>BCA – Bank Central Asia</option>
                                            <option value="BNI"       data-code="009" {{ old('bank_name') == 'BNI'       ? 'selected' : '' }}>BNI – Bank Negara Indonesia</option>
                                            <option value="BRI"       data-code="002" {{ old('bank_name') == 'BRI'       ? 'selected' : '' }}>BRI – Bank Rakyat Indonesia</option>
                                            <option value="Mandiri"   data-code="008" {{ old('bank_name') == 'Mandiri'   ? 'selected' : '' }}>Mandiri – Bank Mandiri</option>
                                            <option value="BSI"       data-code="451" {{ old('bank_name') == 'BSI'       ? 'selected' : '' }}>BSI – Bank Syariah Indonesia</option>
                                            <option value="CIMB"      data-code="022" {{ old('bank_name') == 'CIMB'      ? 'selected' : '' }}>CIMB Niaga</option>
                                            <option value="Jago"      data-code="542" {{ old('bank_name') == 'Jago'      ? 'selected' : '' }}>Bank Jago</option>
                                            <option value="SeaBank"   data-code="535" {{ old('bank_name') == 'SeaBank'   ? 'selected' : '' }}>SeaBank Indonesia</option>
                                            <option value="Danamon"   data-code="011" {{ old('bank_name') == 'Danamon'   ? 'selected' : '' }}>Bank Danamon</option>
                                            <option value="Permata"   data-code="013" {{ old('bank_name') == 'Permata'   ? 'selected' : '' }}>Bank Permata</option>
                                            <option value="Maybank"   data-code="016" {{ old('bank_name') == 'Maybank'   ? 'selected' : '' }}>Maybank Indonesia</option>
                                        </optgroup>
                                        <optgroup label="📱 E-Wallet">
                                            <option value="Gopay"     data-code="GOPAY"     {{ old('bank_name') == 'Gopay'     ? 'selected' : '' }}>GoPay</option>
                                            <option value="OVO"       data-code="OVO"       {{ old('bank_name') == 'OVO'       ? 'selected' : '' }}>OVO</option>
                                            <option value="Dana"      data-code="DANA"      {{ old('bank_name') == 'Dana'      ? 'selected' : '' }}>DANA</option>
                                            <option value="ShopeePay" data-code="SHOPEEPAY" {{ old('bank_name') == 'ShopeePay' ? 'selected' : '' }}>ShopeePay</option>
                                            <option value="LinkAja"   data-code="LINKAJA"   {{ old('bank_name') == 'LinkAja'   ? 'selected' : '' }}>LinkAja</option>
                                        </optgroup>
                                    </select>
                                    {{-- Hidden input menyimpan DOKU bank code --}}
                                    <input type="hidden" name="bank_code" id="bank_code" value="{{ old('bank_code') }}" />
                                    <x-input-error class="mt-1" :messages="$errors->get('bank_name')" />
                                </div>

                                {{-- Nomor Rekening / No HP --}}
                                <div>
                                    <x-input-label for="bank_account" value="Nomor Rekening / No HP" />
                                    <x-text-input id="bank_account" name="bank_account" type="text" class="mt-1 block w-full" :value="old('bank_account')" placeholder="Contoh: 081234567890" required />
                                    <p class="text-xs text-gray-400 mt-1">Untuk e-wallet, gunakan nomor HP yang terdaftar.</p>
                                    <x-input-error class="mt-1" :messages="$errors->get('bank_account')" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <x-primary-button class="px-8 py-3 text-sm">
                                <i class="fa-solid fa-paper-plane mr-2"></i> {{ __('Ajukan Penarikan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-6 text-sm text-gray-500 dark:text-gray-400 p-4 bg-gray-50 dark:bg-gray-800/50 rounded-lg">
                <h4 class="font-bold flex items-center gap-2 mb-3"><i class="fa-solid fa-circle-info text-blue-500"></i> Ketentuan Penarikan Dana</h4>
                <ul class="list-disc pl-5 space-y-1.5">
                    <li>Minimal pengajuan penarikan adalah <strong>Rp 50.000</strong>.</li>
                    <li>
                        <strong>Biaya transfer DOKU</strong> sebesar <strong>Rp {{ number_format($dokuFee, 0, ',', '.') }}</strong>
                        ditanggung UMKM dan dipotong dari dana yang dikirim ke rekening.
                    </li>
                    @if($umkm->tax_threshold > 0)
                        <li>
                            <strong>Komisi platform ({{ $feeLabel }})</strong> berlaku setelah total keuntungan kumulatif Anda
                            melebihi <strong>Rp {{ number_format($umkm->tax_threshold, 0, ',', '.') }}</strong>.
                            @if($thresholdActive)
                                <span class="text-orange-500 font-semibold">Saat ini komisi platform <u>sudah aktif</u>.</span>
                            @else
                                Kumulatif saat ini: <strong>Rp {{ number_format($totalEarnings, 0, ',', '.') }}</strong> (belum melampaui batas).
                            @endif
                        </li>
                    @else
                        <li>Komisi platform belum dikonfigurasi untuk UMKM Anda.</li>
                    @endif
                    <li>Penarikan ganda tidak diperbolehkan selagi ada pengajuan berstatus <strong>"Pending"</strong>.</li>
                    <li>Proses transfer memakan waktu hingga <strong>1×24 jam</strong> di hari kerja.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const amountInput    = document.getElementById('amount');
        const dokuFee        = {{ (float) env('DOKU_WITHDRAWAL_FEE', 6500) }};
        const thresholdActive = {{ $thresholdActive ? 'true' : 'false' }};
        const feeType        = '{{ $umkm->platform_fee_type }}';
        const feeRate        = {{ (float) $umkm->platform_fee_rate }};
        const feeFlat        = {{ (float) $umkm->platform_fee_flat }};

        function fmt(n) {
            return 'Rp ' + Math.round(n).toLocaleString('id-ID');
        }

        function updateBreakdown() {
            const gross = parseFloat(amountInput.value) || 0;
            let platformFee = 0;

            if (thresholdActive) {
                platformFee = feeType === 'percentage'
                    ? Math.round(gross * feeRate / 100)
                    : feeFlat;
            }

            const net = Math.max(0, gross - platformFee - dokuFee);

            document.getElementById('preview-gross').textContent = fmt(gross);
            if (thresholdActive) {
                document.getElementById('preview-platform-fee').textContent = '- ' + fmt(platformFee);
            }
            document.getElementById('preview-net').textContent = fmt(net);
        }

        // Sync DOKU bank code dari data-code attribute pilihan select
        function syncBankCode(select) {
            const selected = select.options[select.selectedIndex];
            document.getElementById('bank_code').value = selected.dataset.code || '';
        }

        // Init on page load (jika ada old value dari validation fail)
        document.addEventListener('DOMContentLoaded', function () {
            const sel = document.getElementById('bank_name');
            if (sel) syncBankCode(sel);
        });

        amountInput.addEventListener('input', updateBreakdown);
        updateBreakdown();

        // Form validation
        document.getElementById('withdrawal-form').addEventListener('submit', function(e) {
            document.querySelectorAll('.js-error').forEach(el => el.remove());
            let valid = true;
            function addError(el, msg) {
                const span = document.createElement('p');
                span.className = 'js-error text-red-500 text-sm mt-1';
                span.textContent = msg;
                el.parentElement.appendChild(span);
            }

            const amount = parseFloat(amountInput.value) || 0;
            if (!amountInput.value || amount < 50000) { addError(amountInput, 'Minimal penarikan Rp 50.000.'); valid = false; }
            else if (amount > {{ max(50000, $availableBalance) }}) { addError(amountInput, 'Saldo tidak mencukupi.'); valid = false; }

            const accountName = document.getElementById('account_name');
            if (!accountName.value.trim()) { addError(accountName, 'Nama pemilik rekening wajib diisi.'); valid = false; }

            const bankName = document.getElementById('bank_name');
            if (!bankName.value) { addError(bankName, 'Pilih bank atau e-wallet tujuan.'); valid = false; }

            const bankAccount = document.getElementById('bank_account');
            if (!bankAccount.value.trim()) { addError(bankAccount, 'Nomor rekening/HP wajib diisi.'); valid = false; }

            if (!valid) e.preventDefault();
        });
    </script>
</x-seller-layout>
