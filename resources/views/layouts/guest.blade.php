<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GamesShop') }}</title>

        <!-- Google Font: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
            ::-webkit-scrollbar { width: 8px; }
            ::-webkit-scrollbar-track { background: #050510; }
            ::-webkit-scrollbar-thumb { background: #6366f1; border-radius: 99px; }
            ::-webkit-scrollbar-thumb:hover { background: #818cf8; }
        </style>
    </head>
    <body class="antialiased bg-[#050510] text-gray-100 min-h-screen flex flex-col selection:bg-indigo-500/30">

        <!-- Ambient floating background orbs -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none" style="z-index:0">
            <div class="absolute -top-1/4 -left-[10%] w-[55%] h-[55%] rounded-full bg-indigo-600/[0.07] blur-[160px] animate-float"></div>
            <div class="absolute -bottom-1/4 -right-[10%] w-[60%] h-[60%] rounded-full bg-fuchsia-600/[0.06] blur-[160px] animate-float anim-delay-3"></div>
            <div class="absolute top-[40%] right-[15%] w-[35%] h-[35%] rounded-full bg-blue-600/[0.04] blur-[140px] animate-float anim-delay-1"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col sm:justify-center items-center pt-6 pb-10 sm:pt-0">
            <!-- Logo -->
            <div class="mb-2">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/60 transition-shadow">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                    </div>
                    <span class="text-2xl font-black tracking-tight bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">GAMESHOP</span>
                </a>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-lg mt-6 px-10 py-10 glass shadow-2xl shadow-black/40 overflow-hidden sm:rounded-2xl fade-in-up" style="border:none;">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
