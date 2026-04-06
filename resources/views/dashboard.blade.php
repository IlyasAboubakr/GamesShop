@extends('layouts.store')

@section('title', 'My Account')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Header --}}
    <div class="mb-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">My Account</h1>
            <p class="text-gray-500 text-sm mt-1">Welcome back, <span class="text-indigo-400 font-semibold">{{ auth()->user()->name }}</span>!</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 text-sm font-bold px-4 py-2.5 border border-white/10 text-gray-300 bg-white/5 hover:bg-white/10 rounded-xl transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                My Profile
            </a>
            <a href="{{ route('store.browse') }}" class="inline-flex items-center gap-2 text-sm font-bold px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl transition-all shadow-lg shadow-indigo-600/25">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z" /></svg>
                Browse Store
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-12">
        {{-- Total Orders --}}
        <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-6 hover:border-indigo-500/20 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-white">{{ $orders->count() }}</p>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Orders</p>
                </div>
            </div>
        </div>
        {{-- Total Spent --}}
        <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-6 hover:border-emerald-500/20 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-white">${{ number_format($orders->sum('total_price'), 2) }}</p>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Spent</p>
                </div>
            </div>
        </div>
        {{-- Game Keys --}}
        <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-6 hover:border-purple-500/20 transition-all">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                </div>
                <div>
                    <p class="text-2xl font-black text-white">{{ $keysByOrder->flatten()->count() }}</p>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Game Keys</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Last Order Section --}}
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-black text-white tracking-tight">Last Order</h2>
        @if($orders->count() > 0)
        <a href="{{ route('client.orders') }}" class="inline-flex items-center gap-2 text-sm font-bold px-4 py-2 bg-indigo-600/20 hover:bg-indigo-600 border border-indigo-500/30 hover:border-indigo-500 text-indigo-400 hover:text-white rounded-xl transition-all duration-200">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
            All Orders
        </a>
        @endif
    </div>

    @if($lastOrder)
        <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] overflow-hidden shadow-xl shadow-black/20 hover:border-indigo-500/20 transition-all duration-300">
            {{-- Order Header --}}
            <div class="p-6 bg-white/[0.02] border-b border-white/[0.06] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-xs font-bold text-indigo-400 uppercase tracking-wider">Order #{{ str_pad($lastOrder->id, 6, '0', STR_PAD_LEFT) }}</span>
                        <span class="text-xs text-gray-600">{{ $lastOrder->created_at->format('M d, Y \a\t h:i A') }}</span>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-2xl font-black bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">${{ number_format($lastOrder->total_price, 2) }}</span>
                    <a href="{{ route('checkout.pdf', $lastOrder) }}" class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 border border-red-500/30 text-red-400 bg-red-500/10 hover:bg-red-500 hover:text-white rounded-lg transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        PDF
                    </a>
                </div>
            </div>

            {{-- Items --}}
            <div class="p-6">
                <div class="space-y-4 mb-6">
                    @foreach($lastOrder->items as $item)
                        <div class="flex items-center gap-4">
                            <div class="h-14 w-10 bg-gray-900 rounded-lg overflow-hidden flex-shrink-0 border border-white/[0.06]">
                                @if($item->game->cover_image)
                                    <img src="{{ Storage::url($item->game->cover_image) }}" alt="" class="h-full w-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-bold text-gray-200 truncate">{{ $item->game->title }}</h4>
                                <p class="text-xs text-gray-600">{{ $item->quantity }}x ${{ number_format($item->price, 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Keys for last order --}}
                @if(isset($keysByOrder[$lastOrder->id]))
                    <div class="border-t border-white/[0.06] pt-5">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                            Your Game Keys
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($keysByOrder[$lastOrder->id] as $key)
                                <div class="bg-white/[0.02] border border-white/[0.06] rounded-xl p-4 flex items-center justify-between gap-4 hover:border-indigo-500/30 transition-colors">
                                    <div class="min-w-0">
                                        <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">{{ $key->game->title ?? 'Game' }}</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <p class="font-mono text-base text-emerald-400 font-bold tracking-widest" id="dash-key-text-{{ $key->id }}">••••-••••-••••-••••</p>
                                            <button onclick="revealDashKey('{{ $key->id }}', '{{ $key->key_code ?? 'N/A' }}')" id="dash-reveal-btn-{{ $key->id }}" class="text-[10px] bg-indigo-500/20 text-indigo-400 hover:bg-indigo-500 hover:text-white px-2 py-0.5 rounded transition-colors font-bold uppercase">Reveal</button>
                                        </div>
                                    </div>
                                    <button class="text-gray-600 hover:text-indigo-400 focus:outline-none transition-colors flex-shrink-0" title="Copy Key"
                                        onclick="navigator.clipboard.writeText('{{ $key->key_code ?? '' }}'); this.innerHTML='<svg class=\'h-5 w-5 text-emerald-400\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\' /></svg>'; setTimeout(() => { this.innerHTML='<svg class=\'h-5 w-5\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z\' /></svg>'; }, 1500);">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Link to all orders --}}
                <div class="mt-6 pt-4 border-t border-white/[0.04] text-center">
                    <a href="{{ route('client.orders') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-400 hover:text-white transition-colors group">
                        View all {{ $orders->count() }} order(s)
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-16 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            <h3 class="text-xl font-bold text-gray-300 mb-2">No orders yet</h3>
            <p class="text-gray-600 text-sm mb-6">Start building your gaming library today!</p>
            <a href="{{ route('store.browse') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-lg shadow-indigo-600/25">
                Browse Store
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
            </a>
        </div>
    @endif

</div>

<script>
function revealDashKey(id, code) {
    document.getElementById('dash-key-text-' + id).innerText = code;
    document.getElementById('dash-reveal-btn-' + id).style.display = 'none';
}
</script>
@endsection
