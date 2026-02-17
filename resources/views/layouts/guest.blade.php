<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50 dark:bg-gray-900">
        <div class="flex min-h-screen">
            <!-- Left Side - Branding/Design -->
            <div class="hidden w-1/2 lg:flex flex-col items-center justify-center relative overflow-hidden bg-gradient-to-br from-slate-900 to-slate-800">
                <!-- Decorative Circle -->
                <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-4000"></div>

                <div class="z-10 text-center px-12">
                    <div class="mb-6 flex justify-center">
                         <!-- Placeholder for Logo if needed, or just use text -->
                         <svg class="w-20 h-20 text-white opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    </div>
                    <h1 class="text-5xl font-bold text-white tracking-widest uppercase mb-4">KopiNgaji</h1>
                    <p class="text-lg text-gray-300 font-light leading-relaxed">
                        Sinergi Umat, Membangun Ekonomi Negeri.
                    </p>
                </div>
            </div>

            <!-- Right Side - Form -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 p-8 sm:p-12 md:p-16 bg-white dark:bg-gray-800">
                <div class="w-full max-w-md mx-auto">
                    <div class="flex justify-center mb-8 lg:hidden">
                        <a href="/">
                            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                        </a>
                    </div>
                    
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
