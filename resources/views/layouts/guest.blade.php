<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KopiNgaji') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-slate-50 selection:bg-indigo-500 selection:text-white">
    <div class="flex min-h-screen">
        <!-- Left Side - Branding/Design -->
        <div class="hidden w-1/2 lg:flex flex-col items-center justify-center relative overflow-hidden bg-white shadow-2xl">
            <!-- Decorative Background Element -->
            <div class="absolute inset-0 bg-[#f8fafc]">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 via-white to-emerald-50 opacity-90"></div>
                <!-- Abstract Coffee/Islamic pattern circles -->
                <div class="absolute top-[-10%] left-[-10%] w-[500px] h-[500px] rounded-full bg-indigo-100/50 mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
                <div class="absolute top-[20%] right-[-10%] w-[400px] h-[400px] rounded-full bg-emerald-100/50 mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute bottom-[-10%] left-[20%] w-[600px] h-[600px] rounded-full bg-amber-100/50 mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
            </div>

            <div class="z-10 text-center px-16 relative">
                <div class="mb-8 flex justify-center">
                    <div class="p-4 bg-white rounded-2xl shadow-xl flex items-center justify-center w-24 h-24 transform transition hover:scale-105 duration-300">
                        <i class="fa-solid fa-mug-hot text-4xl text-indigo-600"></i>
                    </div>
                </div>
                <h1 class="text-5xl font-extrabold text-slate-800 tracking-tight mb-6">
                    Kopi<span class="text-indigo-600">Ngaji</span>
                </h1>
                <p class="text-xl text-slate-600 font-medium leading-relaxed max-w-md mx-auto">
                    Sinergi Umat, Membangun Ekonomi Negeri dengan Penuh Keberkahan.
                </p>
                <div class="mt-12 flex gap-4 justify-center">
                   <div class="flex items-center gap-2 text-sm font-semibold text-slate-600 bg-white/60 backdrop-blur px-4 py-2 rounded-full shadow-sm">
                        <i class="fa-solid fa-check-circle text-emerald-500"></i> Terpercaya
                   </div>
                   <div class="flex items-center gap-2 text-sm font-semibold text-slate-600 bg-white/60 backdrop-blur px-4 py-2 rounded-full shadow-sm">
                        <i class="fa-solid fa-store text-indigo-500"></i> UMKM Pilihan
                   </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="flex flex-col justify-center w-full lg:w-1/2 p-8 sm:p-12 md:p-16 bg-slate-50/50 backdrop-blur-xl">
            <div class="w-full max-w-md mx-auto">
                <div class="flex flex-col items-center mb-10 lg:hidden">
                    <div class="p-3 bg-white rounded-xl shadow-md flex items-center justify-center w-16 h-16 mb-4">
                        <i class="fa-solid fa-mug-hot text-3xl text-indigo-600"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Kopi<span class="text-indigo-600">Ngaji</span></h2>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-xl border border-slate-100">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
