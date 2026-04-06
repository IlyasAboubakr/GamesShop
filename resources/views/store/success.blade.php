@extends('layouts.store')

@section('title', 'Order Successful')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/20 mb-8 border border-emerald-500/30">
        <svg class="h-10 w-10 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    <h1 class="text-4xl font-extrabold text-white tracking-tight mb-4">Payment Successful!</h1>
    <p class="text-gray-400 text-lg mb-2">Thank you for your purchase. Here are the keys to your new games.</p>
    <p class="text-emerald-400 font-medium mb-10">A receipt and your game keys have been sent to your email.</p>

    <div class="bg-[#111827] rounded-xl border border-gray-800 shadow-xl overflow-hidden mb-10 text-left">
        <div class="p-6 border-b border-gray-800 bg-gray-900/50 flex flex-col sm:flex-row justify-between items-center sm:items-baseline gap-4">
            <div>
                <h2 class="text-xl font-bold text-white tracking-wider">Order Reference: <span class="text-indigo-400">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span></h2>
                <p class="text-gray-500 text-sm mt-1">Order Total: <span class="text-emerald-400 font-bold">${{ number_format($order->total_price, 2) }}</span></p>
            </div>
            <a href="{{ route('checkout.pdf', $order) }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-lg shadow-red-500/20 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Download PDF
            </a>
        </div>

        <ul class="divide-y divide-gray-800">
            @foreach($keys as $key)
                <li class="p-6 sm:px-10 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-center sm:text-left">
                        <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">{{ $key->game->platform ?? 'Platform' }}</span>
                        <h3 class="text-lg font-bold text-gray-200">{{ $key->game->title ?? 'Game Name' }}</h3>
                    </div>
                    
                    <div class="bg-gray-900 px-6 py-3 rounded-lg border border-gray-700 flex items-center gap-3 w-full sm:w-auto overflow-x-auto justify-center">
                        <code class="text-emerald-400 font-mono text-lg tracking-widest">{{ $key->key_code }}</code>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <a href="{{ route('store.browse') }}" class="text-indigo-400 hover:text-indigo-300 font-bold text-lg inline-flex items-center gap-2 transition-colors">
        ← Continue Shopping
    </a>
</div>
@endsection
