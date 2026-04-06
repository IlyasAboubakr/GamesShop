@extends('layouts.store')

@section('content')
<!-- ========== HERO ========== -->
<div class="relative overflow-hidden min-h-[580px] flex items-center" style="background: linear-gradient(135deg, #0c0c1d 0%, #0f0a24 40%, #150d2e 100%);">
    {{-- Decorative grid overlay --}}
    <div class="absolute inset-0 opacity-[0.03]" style="background-image: url('data:image/svg+xml,%3Csvg width=&quot;40&quot; height=&quot;40&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cpath d=&quot;M0 0h40v40H0z&quot; fill=&quot;none&quot; stroke=&quot;%23fff&quot; stroke-width=&quot;0.5&quot;/%3E%3C/svg%3E');"></div>
    {{-- Gradient blobs --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-600/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-purple-600/15 rounded-full blur-[100px]"></div>
    {{-- Bottom fade --}}
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-[#050510] to-transparent"></div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-20 z-10">
        <div class="max-w-3xl">
            <div class="fade-in-up">
                <span class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-indigo-400 bg-indigo-500/10 border border-indigo-500/20 px-4 py-1.5 rounded-full mb-6">
                    <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse"></span>
                    Instant Digital Delivery
                </span>
            </div>

            <h1 class="fade-in-up anim-delay-1 text-5xl sm:text-6xl lg:text-7xl font-black tracking-tight text-white leading-[1.1]">
                Level Up Your
                <span class="block mt-2 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Gaming Library</span>
            </h1>

            <p class="fade-in-up anim-delay-2 mt-6 text-lg sm:text-xl text-gray-400 leading-relaxed max-w-xl">
                Discover the best deals on digital game keys for PC & PlayStation. Instant checkout, instant keys — no waiting.
            </p>

            <div class="fade-in-up anim-delay-3 mt-10 flex flex-wrap gap-4">
                <a href="{{ route('store.browse') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-lg shadow-indigo-600/30 hover:shadow-indigo-500/50 hover:-translate-y-0.5">
                    Browse Store
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
                <a href="{{ route('store.browse', ['platform' => 'PlayStation']) }}" class="inline-flex items-center gap-2 bg-white/5 hover:bg-white/10 text-white font-bold px-8 py-4 rounded-xl border border-white/10 hover:border-white/20 transition-all">
                    PlayStation Deals
                </a>
            </div>
        </div>
    </div>
</div>

<!-- ========== FEATURED GAMES ========== -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-10">
        <div class="fade-in-up">
            <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Trending Now</h2>
            <p class="text-gray-500 text-sm mt-1">The hottest game keys right now</p>
        </div>
        <a href="{{ route('store.browse') }}" class="fade-in-up anim-delay-1 text-sm font-bold text-indigo-400 hover:text-indigo-300 transition-colors">View all games →</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($featuredGames as $index => $game)
            <a href="{{ route('store.show', $game) }}" class="fade-in-up group flex flex-col bg-[#0d0d1a] rounded-2xl overflow-hidden border border-white/[0.06] hover:border-indigo-500/40 transition-all duration-500 hover:shadow-[0_0_40px_rgba(99,102,241,0.15)] hover:-translate-y-2" style="animation-delay: {{ ($index % 4) * 80 }}ms">
                {{-- Cover --}}
                <div class="relative h-72 overflow-hidden bg-gray-900 shrink-0">
                    @if($game->cover_image)
                        <img src="{{ Storage::url($game->cover_image) }}" alt="{{ $game->title }}" class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-out">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-700">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0d0d1a] via-transparent to-transparent opacity-80"></div>
                    {{-- Platform badge --}}
                    <div class="absolute top-3 right-3 px-2.5 py-1 bg-black/70 backdrop-blur-md text-[10px] font-bold uppercase tracking-widest text-gray-300 rounded-md border border-white/10">
                        {{ $game->platform }}
                    </div>
                </div>

                {{-- Details --}}
                <div class="p-5 flex-1 flex flex-col">
                    <span class="text-[11px] font-bold uppercase tracking-widest text-indigo-400 mb-2">{{ $game->category->name ?? 'Game' }}</span>
                    <h3 class="text-base font-bold text-gray-100 group-hover:text-indigo-300 line-clamp-2 leading-snug transition-colors">{{ $game->title }}</h3>

                    <div class="mt-auto pt-5 flex items-end justify-between">
                        <span class="text-2xl font-black text-white">${{ number_format($game->price, 2) }}</span>
                        @if($game->stock > 0)
                            <span class="flex items-center gap-1.5 text-xs font-bold text-emerald-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                In Stock
                            </span>
                        @else
                            <span class="text-xs font-bold text-red-400">Sold Out</span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full py-24 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                <h3 class="text-xl font-bold text-gray-300 mb-2">No games yet</h3>
                <p class="text-gray-600 text-sm">Check back soon — we're loading up the catalog.</p>
            </div>
        @endforelse
    </div>
</section>

<!-- ========== FEATURES ========== -->
<section class="border-y border-white/[0.04] bg-[#08081a] py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16 fade-in-up">
            <h2 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Why GamesShop?</h2>
            <p class="text-gray-500 text-sm mt-2">Trusted by thousands of gamers worldwide</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            {{-- Feature 1 --}}
            <div class="text-center fade-in-up group" style="animation-delay: 100ms">
                <div class="mx-auto w-16 h-16 rounded-2xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center mb-6 group-hover:bg-indigo-500/20 group-hover:border-indigo-500/40 transition-all">
                    <svg class="w-7 h-7 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Instant Delivery</h3>
                <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">Keys are delivered to your dashboard immediately — no emails to wait for.</p>
            </div>
            {{-- Feature 2 --}}
            <div class="text-center fade-in-up group" style="animation-delay: 200ms">
                <div class="mx-auto w-16 h-16 rounded-2xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center mb-6 group-hover:bg-purple-500/20 group-hover:border-purple-500/40 transition-all">
                    <svg class="w-7 h-7 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">100% Secure</h3>
                <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">Your payment is safe  — all transactions are encrypted end-to-end.</p>
            </div>
            {{-- Feature 3 --}}
            <div class="text-center fade-in-up group" style="animation-delay: 300ms">
                <div class="mx-auto w-16 h-16 rounded-2xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center mb-6 group-hover:bg-pink-500/20 group-hover:border-pink-500/40 transition-all">
                    <svg class="w-7 h-7 text-pink-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                </div>
                <h3 class="text-lg font-bold text-white mb-2">Best Prices</h3>
                <p class="text-gray-500 text-sm leading-relaxed max-w-xs mx-auto">We compare prices globally to guarantee the cheapest keys on the market.</p>
            </div>
        </div>
    </div>
</section>
@endsection
