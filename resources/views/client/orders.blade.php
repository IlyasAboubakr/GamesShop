@extends('layouts.store')

@section('title', 'My Orders')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Header --}}
    <div class="mb-10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-indigo-400 transition-colors text-sm font-semibold flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                    My Account
                </a>
                <span class="text-gray-700">/</span>
                <span class="text-sm text-gray-400 font-semibold">All Orders</span>
            </div>
            <h1 class="text-3xl font-black text-white tracking-tight">Order History</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $orders->count() }} order(s) &mdash; Total spent: <span class="text-emerald-400 font-bold">${{ number_format($orders->sum('total_price'), 2) }}</span></p>
        </div>
    </div>

    {{-- Orders List --}}
    <div class="space-y-6">
        @forelse($orders as $order)
            <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] overflow-hidden shadow-xl shadow-black/20 hover:border-indigo-500/20 transition-all duration-300">

                {{-- Order Header --}}
                <div class="p-5 bg-white/[0.02] border-b border-white/[0.06] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-lg text-xs font-bold text-indigo-400 uppercase tracking-wider">
                            Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                        </span>
                        <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                            {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl font-black bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                            ${{ number_format($order->total_price, 2) }}
                        </span>
                        {{-- PDF Download --}}
                        <a href="{{ route('checkout.pdf', $order) }}"
                           class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1.5 border border-red-500/30 text-red-400 bg-red-500/10 hover:bg-red-500 hover:text-white rounded-lg transition-all"
                           title="Download PDF Receipt">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            PDF
                        </a>
                    </div>
                </div>

                {{-- Order Items --}}
                <div class="p-5">
                    <div class="space-y-3 mb-5">
                        @foreach($order->items as $item)
                            <div class="flex items-center gap-4">
                                <div class="h-12 w-9 bg-gray-900 rounded-lg overflow-hidden flex-shrink-0 border border-white/[0.06]">
                                    @if($item->game->cover_image)
                                        <img src="{{ Storage::url($item->game->cover_image) }}" alt="" class="h-full w-full object-cover">
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-bold text-gray-200 truncate">{{ $item->game->title }}</h4>
                                    <p class="text-xs text-gray-600">{{ $item->quantity }}x &mdash; ${{ number_format($item->price, 2) }} each</p>
                                </div>
                                <span class="text-sm font-bold text-gray-300">${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Game Keys Section (hidden by default, revealed on click) --}}
                    @if(isset($keysByOrder[$order->id]))
                        <div class="border-t border-white/[0.06] pt-4">
                            {{-- Toggle Button --}}
                            <button
                                onclick="toggleKeys({{ $order->id }})"
                                id="reveal-btn-{{ $order->id }}"
                                class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2 bg-emerald-500/10 hover:bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 rounded-xl transition-all mb-4">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" /></svg>
                                <span id="reveal-btn-text-{{ $order->id }}">Show Game Keys ({{ count($keysByOrder[$order->id]) }})</span>
                            </button>

                            {{-- Keys Panel (hidden by default) --}}
                            <div id="keys-panel-{{ $order->id }}" class="hidden">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach($keysByOrder[$order->id] as $key)
                                        <div class="bg-white/[0.02] border border-emerald-500/20 rounded-xl p-4 flex items-center justify-between gap-4 hover:border-emerald-500/40 transition-colors">
                                            <div class="min-w-0">
                                                <p class="text-[10px] text-gray-600 font-bold uppercase tracking-widest">{{ $key->game->title ?? 'Game' }}</p>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <p class="font-mono text-base text-emerald-400 font-bold tracking-widest" id="key-text-{{ $key->id }}">••••-••••-••••-••••</p>
                                                    <button onclick="revealKey('{{ $key->id }}', '{{ $key->key_code ?? 'N/A' }}')" id="reveal-btn-{{ $key->id }}" class="text-[10px] bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500 hover:text-white px-2 py-0.5 rounded transition-colors font-bold uppercase">Reveal</button>
                                                </div>
                                            </div>
                                            <button
                                                class="text-gray-600 hover:text-indigo-400 focus:outline-none transition-colors flex-shrink-0"
                                                title="Copy Key"
                                                onclick="copyKey(this, '{{ $key->key_code ?? '' }}')">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] p-16 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-700 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                <h3 class="text-xl font-bold text-gray-300 mb-2">No orders yet</h3>
                <p class="text-gray-600 text-sm mb-6">Start building your gaming library today!</p>
                <a href="{{ route('store.browse') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-8 py-3 rounded-xl transition-all shadow-lg shadow-indigo-600/25">
                    Browse Store
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        @endforelse
    </div>

</div>

<script>
function toggleKeys(orderId) {
    const panel = document.getElementById('keys-panel-' + orderId);
    const btnText = document.getElementById('reveal-btn-text-' + orderId);
    const btn = document.getElementById('reveal-btn-' + orderId);

    if (panel.classList.contains('hidden')) {
        panel.classList.remove('hidden');
        btnText.textContent = btnText.textContent.replace('Show', 'Hide');
        btn.classList.add('bg-emerald-500/30');
    } else {
        panel.classList.add('hidden');
        btnText.textContent = btnText.textContent.replace('Hide', 'Show');
        btn.classList.remove('bg-emerald-500/30');
    }
}

function copyKey(btn, keyCode) {
    navigator.clipboard.writeText(keyCode);
    const origHTML = btn.innerHTML;
    btn.innerHTML = '<svg class="h-5 w-5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>';
    setTimeout(() => { btn.innerHTML = origHTML; }, 1500);
}

function revealKey(id, code) {
    document.getElementById('key-text-' + id).innerText = code;
    document.getElementById('reveal-btn-' + id).style.display = 'none';
}
</script>
@endsection
