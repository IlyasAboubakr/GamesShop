<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GamesShop') }} - @yield('title', 'Buy Digital Game Keys')</title>

        <!-- Google Font: Inter -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
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
        <div class="fixed inset-0 overflow-hidden pointer-events-none" style="z-index:-1">
            <div class="absolute -top-1/4 -left-[10%] w-[55%] h-[55%] rounded-full bg-indigo-600/[0.07] blur-[160px] animate-float"></div>
            <div class="absolute -bottom-1/4 -right-[10%] w-[60%] h-[60%] rounded-full bg-fuchsia-600/[0.06] blur-[160px] animate-float anim-delay-3"></div>
            <div class="absolute top-[40%] right-[15%] w-[35%] h-[35%] rounded-full bg-blue-600/[0.04] blur-[140px] animate-float anim-delay-1"></div>
        </div>

        <!-- ========== NAVBAR ========== -->
        <nav class="glass sticky top-0 z-50 shadow-lg shadow-black/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-[70px]">
                    <!-- Logo + Nav Links -->
                    <div class="flex items-center gap-10">
                        <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                            <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg shadow-indigo-500/30 group-hover:shadow-indigo-500/60 transition-shadow">
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                            </div>
                            <span class="text-xl font-black tracking-tight bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">GAMESHOP</span>
                        </a>
                        <div class="hidden md:flex items-center gap-1">
                            <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-400 hover:text-white px-4 py-2 rounded-lg hover:bg-white/5 transition-all">Home</a>
                            <a href="{{ route('store.browse') }}" class="text-sm font-semibold text-gray-400 hover:text-white px-4 py-2 rounded-lg hover:bg-white/5 transition-all">Store</a>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex items-center gap-4">
                        <!-- Cart icon (hidden for admins) -->
                        @if(!auth()->check() || auth()->user()->role !== 'admin')
                        <a href="{{ route('cart.index') }}" class="relative p-2.5 rounded-xl bg-white/5 border border-white/10 text-gray-400 hover:text-indigo-400 hover:border-indigo-400/40 transition-all group">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121 0 2.09-.773 2.34-1.865l1.692-7.414A1.125 1.125 0 0015.913 3.75H5.648M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" /></svg>
                            @if(Session::has('cart') && count(Session::get('cart')) > 0)
                                <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] flex items-center justify-center bg-gradient-to-r from-pink-500 to-red-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-red-500/40 border-2 border-[#050510]">{{ count(Session::get('cart')) }}</span>
                            @endif
                        </a>
                        @endif

                        @auth
                            @if(Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="hidden sm:flex text-xs font-bold px-3.5 py-2 border border-amber-500/40 text-amber-400 bg-amber-500/10 hover:bg-amber-500 hover:text-black rounded-lg transition-all">Admin</a>
                            @endif

                            {{-- User dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-2.5 text-sm font-semibold text-gray-300 hover:text-white bg-white/5 px-3.5 py-2 rounded-xl border border-white/10 hover:border-white/20 transition-all">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4f46e5&color=fff&rounded=true&size=28" alt="" class="w-6 h-6 rounded-full">
                                    {{ Auth::user()->name }}
                                    <svg class="w-3.5 h-3.5 ml-0.5 text-gray-500 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" /></svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95 -translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-[#0d0d1a] border border-white/[0.08] rounded-xl shadow-2xl shadow-black/50 py-1.5 z-50" style="display: none;">
                                    @if(Auth::user()->role !== 'admin')
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-indigo-500/10 transition-all">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" /></svg>
                                        My Account
                                    </a>
                                    @endif
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm text-gray-300 hover:text-white hover:bg-white/5 transition-all">
                                        <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        Profile
                                    </a>
                                    <div class="border-t border-white/[0.06] my-1"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                                            Disconnect
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:inline text-sm font-semibold text-gray-400 hover:text-white px-3 py-2 transition-colors">Log in</a>
                            <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/50 hover:-translate-y-0.5">Sign up</a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- ========== MAIN CONTENT ========== -->
        <main class="flex-grow relative z-10">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 px-4 py-3 rounded-xl text-sm font-medium">✓ {{ session('success') }}</div>
                </div>
            @endif
            @if(session('error'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-red-500/10 border border-red-500/30 text-red-400 px-4 py-3 rounded-xl text-sm font-medium">✕ {{ session('error') }}</div>
                </div>
            @endif
            @yield('content')
        </main>

        <!-- ========== FOOTER ========== -->
        <footer class="mt-auto pt-16 pb-10 relative z-10 border-t border-white/[0.06]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <span class="text-lg font-black tracking-tight bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">GAMESHOP</span>
                        <p class="text-gray-600 text-xs mt-1">© {{ date('Y') }} GamesShop. All rights reserved.</p>
                    </div>
                    <div class="flex gap-8">
                        <a href="#" class="text-gray-500 hover:text-gray-300 text-sm font-medium transition-colors">Terms</a>
                        <a href="#" class="text-gray-500 hover:text-gray-300 text-sm font-medium transition-colors">Privacy</a>
                        <a href="#" class="text-gray-500 hover:text-gray-300 text-sm font-medium transition-colors">Support</a>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
