<nav x-data="{ open: false }" class="bg-white sticky top-0 z-40 shadow-sm border-b border-slate-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center group-hover:bg-indigo-600 transition-colors duration-300">
                            <i class="fa-solid fa-mug-hot text-xl text-indigo-600 group-hover:text-white transition-colors duration-300"></i>
                        </div>
                        <span class="font-bold text-xl tracking-tight text-slate-800">
                            Kopi<span class="text-indigo-600">Ngaji</span>
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="!font-medium !text-slate-600 hover:!text-indigo-600 !border-indigo-600 py-7">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('umkms.index')" :active="request()->routeIs('umkms.index')" class="!font-medium !text-slate-600 hover:!text-indigo-600 !border-indigo-600 py-7">
                        {{ __('Eksplorasi UMKM') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Cart/Notification Icons -->
                <div class="mr-4 flex items-center space-x-4">
                     @if(Auth::user()->role === 'BUYER')
                         @php
                            $cartItemCount = \App\Models\CartItem::whereHas('cart', function($q) {
                                $q->where('user_id', Auth::id());
                            })->sum('quantity');
                         @endphp
                         <a href="{{ route('cart.index') }}" class="text-slate-400 hover:text-indigo-600 transition-colors p-2 rounded-full hover:bg-slate-50 relative group">
                             <i class="fa-solid fa-cart-shopping text-lg group-hover:scale-110 transition-transform"></i>
                             @if($cartItemCount > 0)
                                 <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 shadow-sm border-2 border-white">
                                     {{ $cartItemCount > 99 ? '99+' : $cartItemCount }}
                                 </span>
                             @endif
                         </a>
                     @endif
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-4 py-2 border border-slate-200 text-sm leading-4 font-medium rounded-full text-slate-600 bg-white hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 focus:outline-none transition ease-in-out duration-150 shadow-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs uppercase">
                                     {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="font-semibold">{{ Auth::user()->name }}</span>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-3 border-b border-slate-100 mb-1">
                             <p class="text-xs text-slate-500 font-medium">Masuk sebagai</p>
                             <p class="text-sm font-semibold text-slate-800 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 font-medium">
                            <i class="fa-regular fa-user w-4"></i> {{ __('Profile Settings') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2 text-red-600 hover:text-red-700 hover:bg-red-50 font-medium border-t border-slate-100 mt-1">
                                <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none focus:bg-slate-100 focus:text-slate-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-slate-200 shadow-lg absolute w-full z-50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="!font-medium">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('umkms.index')" :active="request()->routeIs('umkms.index')" class="!font-medium">
                {{ __('Eksplorasi UMKM') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-100 bg-slate-50">
            <div class="px-4 py-2">
                <div class="font-bold text-base text-slate-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 bg-white">
                <x-responsive-nav-link :href="route('profile.edit')" class="!font-medium text-slate-600 flex items-center gap-2">
                    <i class="fa-regular fa-user w-4"></i> {{ __('Profile Settings') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-600 !font-medium flex items-center gap-2">
                            <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
