<nav x-data="{ open: false }" class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="<?php echo e(route('seller.dashboard')); ?>" class="flex items-center gap-2 group">
                        <div class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-600 transition-colors duration-300">
                            <i class="fa-solid fa-mug-hot text-lg text-indigo-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <span class="font-bold text-lg tracking-tight text-slate-800">
                            Kopi<span class="text-indigo-600">Ngaji</span>
                        </span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <div class="hidden lg:flex items-center ms-8 space-x-1">
                    
                    <a href="<?php echo e(route('seller.dashboard')); ?>"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              <?php echo e(request()->routeIs('seller.dashboard') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                        <i class="fa-solid fa-gauge-high text-xs"></i>
                        Dashboard
                    </a>

                    
                    <?php if(Auth::user()->umkm): ?>
                        <a href="<?php echo e(route('seller.umkm.edit')); ?>"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                                  <?php echo e(request()->routeIs('seller.umkm.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                            <i class="fa-solid fa-store text-xs"></i>
                            UMKM
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('seller.umkm.create')); ?>"
                           class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                                  <?php echo e(request()->routeIs('seller.umkm.create') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                            <i class="fa-solid fa-plus text-xs"></i>
                            Daftar UMKM
                        </a>
                    <?php endif; ?>

                    
                    <a href="<?php echo e(route('seller.products.index')); ?>"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              <?php echo e(request()->routeIs('seller.products.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                        <i class="fa-solid fa-box text-xs"></i>
                        Produk
                    </a>

                    
                    <a href="<?php echo e(route('seller.orders.index')); ?>"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                              <?php echo e(request()->routeIs('seller.orders.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                        <i class="fa-solid fa-clipboard-list text-xs"></i>
                        Pesanan
                    </a>

                    
                    <div x-data="{ openMenu: false }" class="relative">
                        <button @click="openMenu = !openMenu" @click.outside="openMenu = false"
                                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
                                       <?php echo e(request()->routeIs('seller.withdrawals.*') || request()->routeIs('seller.shipping-zones.*') || request()->routeIs('seller.finance.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                            <i class="fa-solid fa-ellipsis text-xs"></i>
                            Lainnya
                            <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{ 'rotate-180': openMenu }" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        <div x-show="openMenu"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-1"
                             class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-100 py-2 z-50"
                             style="display: none;">
                            <a href="<?php echo e(route('seller.withdrawals.index')); ?>"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors
                                      <?php echo e(request()->routeIs('seller.withdrawals.*') ? 'text-indigo-700 bg-indigo-50 font-semibold' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                                <i class="fa-solid fa-wallet w-4 text-center"></i>
                                Penarikan Dana
                            </a>
                            <a href="<?php echo e(route('seller.shipping-zones.index')); ?>"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors
                                      <?php echo e(request()->routeIs('seller.shipping-zones.*') ? 'text-indigo-700 bg-indigo-50 font-semibold' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                                <i class="fa-solid fa-truck w-4 text-center"></i>
                                Zona Pengiriman
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="<?php echo e(route('seller.finance.index')); ?>"
                               class="flex items-center gap-3 px-4 py-2.5 text-sm transition-colors
                                      <?php echo e(request()->routeIs('seller.finance.*') ? 'text-indigo-700 bg-indigo-50 font-semibold' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50'); ?>">
                                <i class="fa-solid fa-chart-line w-4 text-center"></i>
                                Laporan Keuangan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Mode Pembeli + User Dropdown -->
            <div class="hidden lg:flex items-center gap-3">
                <!-- Mode Pembeli Button -->
                <a href="<?php echo e(route('dashboard')); ?>"
                   class="inline-flex items-center gap-2 px-3.5 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                    <i class="fa-solid fa-bag-shopping text-xs"></i>
                    Mode Pembeli
                </a>

                <!-- User Dropdown -->
                <?php if (isset($component)) { $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                     <?php $__env->slot('trigger', null, []); ?> 
                        <button class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-full hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 focus:outline-none transition duration-200 shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs uppercase">
                                <?php echo e(substr(Auth::user()->name, 0, 1)); ?>

                            </div>
                            <span class="max-w-[100px] truncate"><?php echo e(Auth::user()->name); ?></span>
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                     <?php $__env->endSlot(); ?>

                     <?php $__env->slot('content', null, []); ?> 
                        <div class="px-4 py-3 border-b border-slate-100 mb-1">
                            <p class="text-xs text-slate-500 font-medium">Masuk sebagai</p>
                            <p class="text-sm font-semibold text-slate-800 truncate"><?php echo e(Auth::user()->email); ?></p>
                        </div>

                        <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('profile.edit'),'class' => 'flex items-center gap-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 font-medium']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('profile.edit')),'class' => 'flex items-center gap-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 font-medium']); ?>
                            <i class="fa-regular fa-user w-4"></i> <?php echo e(__('Profile Settings')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>

                        <!-- Authentication -->
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <?php if (isset($component)) { $__componentOriginal68cb1971a2b92c9735f83359058f7108 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68cb1971a2b92c9735f83359058f7108 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.dropdown-link','data' => ['href' => route('logout'),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();','class' => 'flex items-center gap-2 text-red-600 hover:text-red-700 hover:bg-red-50 font-medium border-t border-slate-100 mt-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dropdown-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('logout')),'onclick' => 'event.preventDefault(); this.closest(\'form\').submit();','class' => 'flex items-center gap-2 text-red-600 hover:text-red-700 hover:bg-red-50 font-medium border-t border-slate-100 mt-1']); ?>
                                <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> <?php echo e(__('Log Out')); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $attributes = $__attributesOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__attributesOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68cb1971a2b92c9735f83359058f7108)): ?>
<?php $component = $__componentOriginal68cb1971a2b92c9735f83359058f7108; ?>
<?php unset($__componentOriginal68cb1971a2b92c9735f83359058f7108); ?>
<?php endif; ?>
                        </form>
                     <?php $__env->endSlot(); ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $attributes = $__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__attributesOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe)): ?>
<?php $component = $__componentOriginaldf8083d4a852c446488d8d384bbc7cbe; ?>
<?php unset($__componentOriginaldf8083d4a852c446488d8d384bbc7cbe); ?>
<?php endif; ?>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center lg:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden lg:hidden bg-white border-b border-slate-200 shadow-lg absolute w-full z-50">
        <div class="pt-2 pb-3 space-y-1 px-2">
            <a href="<?php echo e(route('seller.dashboard')); ?>"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      <?php echo e(request()->routeIs('seller.dashboard') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                <i class="fa-solid fa-gauge-high w-5 text-center"></i> Dashboard
            </a>
            <?php if(Auth::user()->umkm): ?>
                <a href="<?php echo e(route('seller.umkm.edit')); ?>"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                          <?php echo e(request()->routeIs('seller.umkm.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                    <i class="fa-solid fa-store w-5 text-center"></i> UMKM Saya
                </a>
            <?php else: ?>
                <a href="<?php echo e(route('seller.umkm.create')); ?>"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                          <?php echo e(request()->routeIs('seller.umkm.create') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                    <i class="fa-solid fa-plus w-5 text-center"></i> Daftar UMKM
                </a>
            <?php endif; ?>
            <a href="<?php echo e(route('seller.products.index')); ?>"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      <?php echo e(request()->routeIs('seller.products.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                <i class="fa-solid fa-box w-5 text-center"></i> Produk
            </a>
            <a href="<?php echo e(route('seller.orders.index')); ?>"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      <?php echo e(request()->routeIs('seller.orders.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                <i class="fa-solid fa-clipboard-list w-5 text-center"></i> Pesanan
            </a>

            <div class="border-t border-slate-100 my-2"></div>
            <p class="px-4 py-1 text-xs font-semibold text-slate-400 uppercase tracking-wider">Keuangan & Pengiriman</p>

            <a href="<?php echo e(route('seller.withdrawals.index')); ?>"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      <?php echo e(request()->routeIs('seller.withdrawals.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                <i class="fa-solid fa-wallet w-5 text-center"></i> Penarikan Dana
            </a>
            <a href="<?php echo e(route('seller.shipping-zones.index')); ?>"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      <?php echo e(request()->routeIs('seller.shipping-zones.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                <i class="fa-solid fa-truck w-5 text-center"></i> Zona Pengiriman
            </a>
            <a href="<?php echo e(route('seller.finance.index')); ?>"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium transition-colors
                      <?php echo e(request()->routeIs('seller.finance.*') ? 'text-indigo-700 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50'); ?>">
                <i class="fa-solid fa-chart-line w-5 text-center"></i> Laporan Keuangan
            </a>

            <div class="border-t border-slate-100 my-2"></div>

            <a href="<?php echo e(route('dashboard')); ?>"
               class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-indigo-600 hover:bg-indigo-50 transition-colors">
                <i class="fa-solid fa-bag-shopping w-5 text-center"></i> Mode Pembeli
            </a>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-3 border-t border-slate-100 bg-slate-50">
            <div class="px-4 py-2">
                <div class="font-bold text-base text-slate-800"><?php echo e(Auth::user()->name); ?></div>
                <div class="font-medium text-sm text-slate-500"><?php echo e(Auth::user()->email); ?></div>
            </div>

            <div class="mt-2 space-y-1 px-2">
                <a href="<?php echo e(route('profile.edit')); ?>"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-slate-600 hover:bg-white transition-colors">
                    <i class="fa-regular fa-user w-5 text-center"></i> Profile Settings
                </a>

                <!-- Authentication -->
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-2.5 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                        <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i> Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
<?php /**PATH C:\Kopi_Ngaji_Project\KopiNgaji\resources\views/layouts/seller-navigation.blade.php ENDPATH**/ ?>