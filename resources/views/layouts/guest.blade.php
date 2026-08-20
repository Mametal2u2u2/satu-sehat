<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Satu Sehat LPSK') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex items-center justify-center p-4">
        <div class="flex flex-col w-full max-w-md bg-white shadow-[0_4px_24px_rgba(0,0,0,0.04)] border border-gray-100 rounded-3xl relative px-6 py-8 justify-center">

            
            <!-- App Logo & Title -->
            <div class="flex flex-col items-center mb-8">
                <div class="w-16 h-16 bg-emerald-50 rounded-2xl flex items-center justify-center shadow-sm p-2.5 mb-3 border border-emerald-100">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/ea/Logo_Garuda_Pancasila_Emas.svg" alt="Logo" class="w-full h-full object-contain">
                </div>
                <h1 class="text-xl font-extrabold text-gray-900 tracking-tight leading-tight">Satu Sehat LPSK</h1>
                <p class="text-xs text-emerald-600 font-semibold tracking-wide mt-0.5">Melayani dengan Hati</p>
            </div>

            <!-- Content Area -->
            <div class="w-full">
                {{ $slot }}
            </div>
            
        </div>
    </body>
</html>

