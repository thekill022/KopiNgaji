<?php if (isset($component)) { $__componentOriginala3086a5efa12cddd37a6951435b5e715 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala3086a5efa12cddd37a6951435b5e715 = $attributes; } ?>
<?php $component = App\View\Components\SellerLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('seller-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\SellerLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center gap-3">
            <a href="<?php echo e(route('seller.withdrawals.index')); ?>" class="text-indigo-200 hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h2 class="font-bold text-2xl text-white leading-tight flex items-center gap-3">
                <i class="fa-solid fa-wallet text-indigo-200"></i>
                <?php echo e(__('Tarik Dana')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 border-b border-gray-200 dark:border-gray-700">

                    <?php
                        $dokuFee         = (float) env('DOKU_WITHDRAWAL_FEE', 6500);
                        $thresholdBarangActive = $umkm->tax_threshold > 0 && $totalEarningsBarang > $umkm->tax_threshold;
                        $thresholdJasaActive   = $umkm->tax_threshold_jasa > 0 && $totalEarningsJasa > $umkm->tax_threshold_jasa;
                        $feeBarangLabel = $umkm->platform_fee_type === 'percentage'
                            ? $umkm->platform_fee_rate . '%'
                            : 'Rp ' . number_format($umkm->platform_fee_flat, 0, ',', '.');
                        $feeJasaLabel = $umkm->platform_fee_type_jasa === 'percentage'
                            ? $umkm->platform_fee_rate_jasa . '%'
                            : 'Rp ' . number_format($umkm->platform_fee_flat_jasa, 0, ',', '.');
                    ?>

                    <!-- Saldo Tersedia -->
                    <div class="mb-8 p-4 bg-indigo-50 dark:bg-indigo-900/30 border border-indigo-100 dark:border-indigo-800 rounded-xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-wallet text-indigo-500 text-2xl"></i>
                            <div>
                                <p class="text-sm font-semibold text-indigo-800 dark:text-indigo-300">Saldo Tersedia</p>
                                <p class="text-2xl font-bold font-mono text-gray-900 dark:text-gray-100">Rp <?php echo e(number_format($availableBalance, 0, ',', '.')); ?></p>
                            </div>
                        </div>
                        <?php if($umkm->tax_threshold > 0 || $umkm->tax_threshold_jasa > 0): ?>
                            <div class="text-right text-xs max-w-[260px]">
                                <?php if($thresholdBarangActive): ?>
                                    <p class="text-orange-500 font-semibold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Komisi Barang aktif (>&nbsp;Rp&nbsp;<?php echo e(number_format($umkm->tax_threshold, 0, ',', '.')); ?>)</p>
                                <?php else: ?>
                                    <p class="text-indigo-500"><i class="fa-solid fa-circle-info mr-1"></i> Komisi Barang belum aktif</p>
                                <?php endif; ?>
                                <?php if($thresholdJasaActive): ?>
                                    <p class="text-orange-500 font-semibold"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Komisi Jasa aktif (>&nbsp;Rp&nbsp;<?php echo e(number_format($umkm->tax_threshold_jasa, 0, ',', '.')); ?>)</p>
                                <?php else: ?>
                                    <p class="text-indigo-500"><i class="fa-solid fa-circle-info mr-1"></i> Komisi Jasa belum aktif</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <form method="POST" action="<?php echo e(route('seller.withdrawals.store')); ?>" class="space-y-6" id="withdrawal-form">
                        <?php echo csrf_field(); ?>

                        <!-- Nominal -->
                        <div>
                            <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'amount','value' => 'Nominal Penarikan (Min: Rp 50.000)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'amount','value' => 'Nominal Penarikan (Min: Rp 50.000)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                            <div class="relative mt-1">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-lg font-bold">Rp</span>
                                </div>
                                <input type="number" name="amount" id="amount"
                                    class="pl-10 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm sm:text-lg py-3 transition-colors <?php echo e($errors->has('amount') ? 'border-red-500' : ''); ?>"
                                    placeholder="0" min="50000" max="<?php echo e(max(50000, $availableBalance)); ?>"
                                    value="<?php echo e(old('amount', $availableBalance >= 50000 ? $availableBalance : '')); ?>" required />
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-2','messages' => $errors->get('amount')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-2','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('amount'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
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

                                <!-- Komisi Platform Barang -->
                                <?php if($thresholdBarangActive): ?>
                                    <div class="flex justify-between px-4 py-3">
                                        <span class="text-orange-500 flex items-center gap-1 text-sm">
                                            <i class="fa-solid fa-percent text-xs"></i>
                                            Komisi Barang (<?php echo e($feeBarangLabel); ?>)
                                        </span>
                                        <span class="font-semibold text-orange-500" id="preview-platform-fee-barang">- Rp 0</span>
                                    </div>
                                <?php else: ?>
                                    <div class="flex justify-between px-4 py-3 opacity-40">
                                        <span class="text-slate-400 flex items-center gap-1 text-xs italic">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                            Komisi Barang (<?php echo e($feeBarangLabel); ?>) — belum aktif
                                        </span>
                                        <span class="text-slate-400 text-xs">Rp 0</span>
                                    </div>
                                <?php endif; ?>

                                <!-- Komisi Platform Jasa -->
                                <?php if($thresholdJasaActive): ?>
                                    <div class="flex justify-between px-4 py-3">
                                        <span class="text-orange-500 flex items-center gap-1 text-sm">
                                            <i class="fa-solid fa-percent text-xs"></i>
                                            Komisi Jasa (<?php echo e($feeJasaLabel); ?>)
                                        </span>
                                        <span class="font-semibold text-orange-500" id="preview-platform-fee-jasa">- Rp 0</span>
                                    </div>
                                <?php else: ?>
                                    <div class="flex justify-between px-4 py-3 opacity-40">
                                        <span class="text-slate-400 flex items-center gap-1 text-xs italic">
                                            <i class="fa-solid fa-lock text-xs"></i>
                                            Komisi Jasa (<?php echo e($feeJasaLabel); ?>) — belum aktif
                                        </span>
                                        <span class="text-slate-400 text-xs">Rp 0</span>
                                    </div>
                                <?php endif; ?>

                                <!-- Biaya Admin DOKU -->
                                <div class="flex justify-between px-4 py-3">
                                    <span class="text-red-400 flex items-center gap-1">
                                        <i class="fa-solid fa-building-columns text-xs"></i>
                                        Biaya Transfer DOKU
                                    </span>
                                    <span class="font-semibold text-red-400">- Rp <?php echo e(number_format($dokuFee, 0, ',', '.')); ?></span>
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

                            
                            <div>
                                <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'account_name','value' => 'Nama Pemilik Rekening (sesuai buku tabungan / e-wallet)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'account_name','value' => 'Nama Pemilik Rekening (sesuai buku tabungan / e-wallet)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'account_name','name' => 'account_name','type' => 'text','class' => 'mt-1 block w-full','value' => old('account_name'),'placeholder' => 'Contoh: Budi Santoso','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'account_name','name' => 'account_name','type' => 'text','class' => 'mt-1 block w-full','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('account_name')),'placeholder' => 'Contoh: Budi Santoso','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                <p class="text-xs text-gray-400 mt-1">Harus sama persis dengan nama yang terdaftar di bank/e-wallet. Digunakan untuk validasi transfer.</p>
                                <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1','messages' => $errors->get('account_name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('account_name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <div>
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'bank_name','value' => 'Bank / E-Wallet Tujuan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'bank_name','value' => 'Bank / E-Wallet Tujuan']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    
                                    <select id="bank_name" name="bank_name" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required onchange="syncBankCode(this)">
                                        <option value="" disabled <?php echo e(old('bank_name') ? '' : 'selected'); ?>>Pilih Bank/E-Wallet...</option>
                                        <optgroup label="🏦 Bank Nasional">
                                            <option value="BCA"       data-code="014" <?php echo e(old('bank_name') == 'BCA'       ? 'selected' : ''); ?>>BCA – Bank Central Asia</option>
                                            <option value="BNI"       data-code="009" <?php echo e(old('bank_name') == 'BNI'       ? 'selected' : ''); ?>>BNI – Bank Negara Indonesia</option>
                                            <option value="BRI"       data-code="002" <?php echo e(old('bank_name') == 'BRI'       ? 'selected' : ''); ?>>BRI – Bank Rakyat Indonesia</option>
                                            <option value="Mandiri"   data-code="008" <?php echo e(old('bank_name') == 'Mandiri'   ? 'selected' : ''); ?>>Mandiri – Bank Mandiri</option>
                                            <option value="BSI"       data-code="451" <?php echo e(old('bank_name') == 'BSI'       ? 'selected' : ''); ?>>BSI – Bank Syariah Indonesia</option>
                                            <option value="CIMB"      data-code="022" <?php echo e(old('bank_name') == 'CIMB'      ? 'selected' : ''); ?>>CIMB Niaga</option>
                                            <option value="Jago"      data-code="542" <?php echo e(old('bank_name') == 'Jago'      ? 'selected' : ''); ?>>Bank Jago</option>
                                            <option value="SeaBank"   data-code="535" <?php echo e(old('bank_name') == 'SeaBank'   ? 'selected' : ''); ?>>SeaBank Indonesia</option>
                                            <option value="Danamon"   data-code="011" <?php echo e(old('bank_name') == 'Danamon'   ? 'selected' : ''); ?>>Bank Danamon</option>
                                            <option value="Permata"   data-code="013" <?php echo e(old('bank_name') == 'Permata'   ? 'selected' : ''); ?>>Bank Permata</option>
                                            <option value="Maybank"   data-code="016" <?php echo e(old('bank_name') == 'Maybank'   ? 'selected' : ''); ?>>Maybank Indonesia</option>
                                        </optgroup>
                                        <optgroup label="📱 E-Wallet">
                                            <option value="Gopay"     data-code="GOPAY"     <?php echo e(old('bank_name') == 'Gopay'     ? 'selected' : ''); ?>>GoPay</option>
                                            <option value="OVO"       data-code="OVO"       <?php echo e(old('bank_name') == 'OVO'       ? 'selected' : ''); ?>>OVO</option>
                                            <option value="Dana"      data-code="DANA"      <?php echo e(old('bank_name') == 'Dana'      ? 'selected' : ''); ?>>DANA</option>
                                            <option value="ShopeePay" data-code="SHOPEEPAY" <?php echo e(old('bank_name') == 'ShopeePay' ? 'selected' : ''); ?>>ShopeePay</option>
                                            <option value="LinkAja"   data-code="LINKAJA"   <?php echo e(old('bank_name') == 'LinkAja'   ? 'selected' : ''); ?>>LinkAja</option>
                                        </optgroup>
                                    </select>
                                    
                                    <input type="hidden" name="bank_code" id="bank_code" value="<?php echo e(old('bank_code')); ?>" />
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1','messages' => $errors->get('bank_name')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('bank_name'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>

                                
                                <div>
                                    <?php if (isset($component)) { $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-label','data' => ['for' => 'bank_account','value' => 'Nomor Rekening / No HP']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'bank_account','value' => 'Nomor Rekening / No HP']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $attributes = $__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__attributesOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581)): ?>
<?php $component = $__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581; ?>
<?php unset($__componentOriginale3da9d84bb64e4bc2eeebaafabfb2581); ?>
<?php endif; ?>
                                    <?php if (isset($component)) { $__componentOriginal18c21970322f9e5c938bc954620c12bb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal18c21970322f9e5c938bc954620c12bb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.text-input','data' => ['id' => 'bank_account','name' => 'bank_account','type' => 'text','class' => 'mt-1 block w-full','value' => old('bank_account'),'placeholder' => 'Contoh: 081234567890','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('text-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'bank_account','name' => 'bank_account','type' => 'text','class' => 'mt-1 block w-full','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(old('bank_account')),'placeholder' => 'Contoh: 081234567890','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $attributes = $__attributesOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__attributesOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal18c21970322f9e5c938bc954620c12bb)): ?>
<?php $component = $__componentOriginal18c21970322f9e5c938bc954620c12bb; ?>
<?php unset($__componentOriginal18c21970322f9e5c938bc954620c12bb); ?>
<?php endif; ?>
                                    <p class="text-xs text-gray-400 mt-1">Untuk e-wallet, gunakan nomor HP yang terdaftar.</p>
                                    <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['class' => 'mt-1','messages' => $errors->get('bank_account')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mt-1','messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('bank_account'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <?php if (isset($component)) { $__componentOriginald411d1792bd6cc877d687758b753742c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald411d1792bd6cc877d687758b753742c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.primary-button','data' => ['class' => 'px-8 py-3 text-sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('primary-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'px-8 py-3 text-sm']); ?>
                                <i class="fa-solid fa-paper-plane mr-2"></i> <?php echo e(__('Ajukan Penarikan')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $attributes = $__attributesOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__attributesOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald411d1792bd6cc877d687758b753742c)): ?>
<?php $component = $__componentOriginald411d1792bd6cc877d687758b753742c; ?>
<?php unset($__componentOriginald411d1792bd6cc877d687758b753742c); ?>
<?php endif; ?>
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
                        <strong>Biaya transfer DOKU</strong> sebesar <strong>Rp <?php echo e(number_format($dokuFee, 0, ',', '.')); ?></strong>
                        ditanggung UMKM dan dipotong dari dana yang dikirim ke rekening.
                    </li>
                    <?php if($umkm->tax_threshold > 0 || $umkm->tax_threshold_jasa > 0): ?>
                        <li>
                            <strong>Komisi platform</strong> dipisahkan per tipe produk:
                            <?php if($umkm->tax_threshold > 0): ?>
                                Barang <strong><?php echo e($feeBarangLabel); ?></strong> setelah Rp <?php echo e(number_format($umkm->tax_threshold, 0, ',', '.')); ?>

                                (kumulatif Barang: Rp <?php echo e(number_format($totalEarningsBarang, 0, ',', '.')); ?>).
                            <?php endif; ?>
                            <?php if($umkm->tax_threshold_jasa > 0): ?>
                                Jasa <strong><?php echo e($feeJasaLabel); ?></strong> setelah Rp <?php echo e(number_format($umkm->tax_threshold_jasa, 0, ',', '.')); ?>

                                (kumulatif Jasa: Rp <?php echo e(number_format($totalEarningsJasa, 0, ',', '.')); ?>).
                            <?php endif; ?>
                        </li>
                    <?php else: ?>
                        <li>Komisi platform belum dikonfigurasi untuk UMKM Anda.</li>
                    <?php endif; ?>
                    <li>Penarikan ganda tidak diperbolehkan selagi ada pengajuan berstatus <strong>"Pending"</strong>.</li>
                    <li>Proses transfer memakan waktu hingga <strong>1×24 jam</strong> di hari kerja.</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        const amountInput    = document.getElementById('amount');
        const dokuFee        = <?php echo e((float) env('DOKU_WITHDRAWAL_FEE', 6500)); ?>;
        const totalEarnings  = <?php echo e((float) $totalEarnings); ?>;
        const totalEarningsBarang = <?php echo e((float) $totalEarningsBarang); ?>;
        const totalEarningsJasa   = <?php echo e((float) $totalEarningsJasa); ?>;
        const thresholdBarangActive = <?php echo e($thresholdBarangActive ? 'true' : 'false'); ?>;
        const thresholdJasaActive   = <?php echo e($thresholdJasaActive ? 'true' : 'false'); ?>;
        const feeBarangType  = '<?php echo e($umkm->platform_fee_type); ?>';
        const feeBarangRate  = <?php echo e((float) $umkm->platform_fee_rate); ?>;
        const feeBarangFlat  = <?php echo e((float) $umkm->platform_fee_flat); ?>;
        const feeJasaType    = '<?php echo e($umkm->platform_fee_type_jasa); ?>';
        const feeJasaRate    = <?php echo e((float) $umkm->platform_fee_rate_jasa); ?>;
        const feeJasaFlat    = <?php echo e((float) $umkm->platform_fee_flat_jasa); ?>;

        function fmt(n) {
            return 'Rp ' + Math.round(n).toLocaleString('id-ID');
        }

        function updateBreakdown() {
            const gross = parseFloat(amountInput.value) || 0;
            let platformFeeBarang = 0;
            let platformFeeJasa = 0;

            if (totalEarnings > 0) {
                const barangPortion = gross * (totalEarningsBarang / totalEarnings);
                const jasaPortion   = gross * (totalEarningsJasa / totalEarnings);

                if (thresholdBarangActive) {
                    platformFeeBarang = feeBarangType === 'percentage'
                        ? Math.round(barangPortion * feeBarangRate / 100)
                        : feeBarangFlat;
                }
                if (thresholdJasaActive) {
                    platformFeeJasa = feeJasaType === 'percentage'
                        ? Math.round(jasaPortion * feeJasaRate / 100)
                        : feeJasaFlat;
                }
            }

            const platformFee = platformFeeBarang + platformFeeJasa;
            const net = Math.max(0, gross - platformFee - dokuFee);

            document.getElementById('preview-gross').textContent = fmt(gross);
            if (thresholdBarangActive) {
                document.getElementById('preview-platform-fee-barang').textContent = '- ' + fmt(platformFeeBarang);
            }
            if (thresholdJasaActive) {
                document.getElementById('preview-platform-fee-jasa').textContent = '- ' + fmt(platformFeeJasa);
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
            else if (amount > <?php echo e(max(50000, $availableBalance)); ?>) { addError(amountInput, 'Saldo tidak mencukupi.'); valid = false; }

            const accountName = document.getElementById('account_name');
            if (!accountName.value.trim()) { addError(accountName, 'Nama pemilik rekening wajib diisi.'); valid = false; }

            const bankName = document.getElementById('bank_name');
            if (!bankName.value) { addError(bankName, 'Pilih bank atau e-wallet tujuan.'); valid = false; }

            const bankAccount = document.getElementById('bank_account');
            if (!bankAccount.value.trim()) { addError(bankAccount, 'Nomor rekening/HP wajib diisi.'); valid = false; }

            if (!valid) e.preventDefault();
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala3086a5efa12cddd37a6951435b5e715)): ?>
<?php $attributes = $__attributesOriginala3086a5efa12cddd37a6951435b5e715; ?>
<?php unset($__attributesOriginala3086a5efa12cddd37a6951435b5e715); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala3086a5efa12cddd37a6951435b5e715)): ?>
<?php $component = $__componentOriginala3086a5efa12cddd37a6951435b5e715; ?>
<?php unset($__componentOriginala3086a5efa12cddd37a6951435b5e715); ?>
<?php endif; ?>
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views\seller\withdrawals\create.blade.php ENDPATH**/ ?>