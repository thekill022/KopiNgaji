<x-guest-layout>
    <div class="mb-8 text-center lg:text-left">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Create Account</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Join KopiNgaji today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <x-text-input id="name" class="block mt-2 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                          type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Full Name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Role -->
        <div>
            <x-input-label for="role" :value="__('Register as')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <select id="role" name="role" class="block mt-2 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300" required>
                <option value="BUYER" {{ old('role') == 'BUYER' ? 'selected' : '' }}>Consumer (Pembeli)</option>
                <option value="OWNER" {{ old('role') == 'OWNER' ? 'selected' : '' }}>Seller (Penjual)</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <x-text-input id="email" class="block mt-2 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                          type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 dark:text-gray-300 font-semibold"  />
            <x-text-input id="password" class="block mt-2 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-gray-700 dark:text-gray-300 font-semibold" />
            <x-text-input id="password_confirmation" class="block mt-2 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-300"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
             <x-primary-button class="w-full justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                {{ __('Register') }}
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Already have an account? 
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                    Log in
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
