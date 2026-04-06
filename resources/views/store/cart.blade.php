@extends('layouts.store')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-[60vh]">
    <h1 class="text-3xl font-extrabold text-white mb-8">Your Cart</h1>

    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-6">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="bg-emerald-500 text-white p-4 rounded mb-6">{{ session('success') }}</div>
    @endif

    @if(empty($cart))
        <div class="bg-[#111827] rounded-xl border border-gray-800 p-12 text-center shadow-lg">
            <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            <h2 class="text-2xl font-bold text-gray-300 mb-4">Your cart is empty</h2>
            <p class="text-gray-500 mb-8">Looks like you haven't added any games to your cart yet.</p>
            <a href="{{ route('store.browse') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded transition">Browse Games</a>
        </div>
    @else
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Cart Items -->
            <div class="flex-1 w-full">
                <div class="bg-[#111827] rounded-xl border border-gray-800 overflow-hidden shadow-lg">
                    <ul class="divide-y divide-gray-800">
                        @foreach($cart as $id => $item)
                        <li class="p-6 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                            <!-- Image -->
                            <div class="w-24 h-32 flex-shrink-0 rounded-md overflow-hidden bg-gray-900 border border-gray-800 relative">
                                @if(isset($item['cover_image']))
                                    <img src="{{ Storage::url($item['cover_image']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex justify-center items-center text-xs text-gray-600">No Img</div>
                                @endif
                            </div>
                            
                            <!-- Info -->
                            <div class="flex-1 w-full text-center sm:text-left">
                                <h3 class="text-xl font-bold text-white mb-1"><a href="{{ route('store.show', $id) }}" class="hover:text-indigo-400 transition">{{ $item['title'] }}</a></h3>
                                <p class="text-gray-400 text-sm mb-4">{{ $item['platform'] }}</p>
                                
                                <div class="flex items-center justify-center sm:justify-start gap-4">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label for="qty_{{ $id }}" class="sr-only">Quantity</label>
                                        <input type="number" id="qty_{{ $id }}" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 bg-gray-900 border border-gray-700 text-white rounded text-center focus:ring-indigo-500 py-1">
                                        <button type="submit" class="text-sm text-indigo-400 hover:text-indigo-300 font-medium">Update</button>
                                    </form>
                                    
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-500 hover:text-red-400 font-medium">Remove</button>
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Price -->
                            <div class="text-right">
                                <p class="text-lg font-bold text-white">${{ number_format($item['price'], 2) }}</p>
                                @if($item['quantity'] > 1)
                                    <p class="text-sm text-gray-500 mt-1">Subtotal: ${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Summary -->
            <div class="w-full lg:w-80 flex-shrink-0">
                <div class="bg-[#1F2937] rounded-xl border border-gray-700 p-6 shadow-xl sticky top-24">
                    <h2 class="text-lg font-bold text-white mb-4 uppercase tracking-wider border-b border-gray-600 pb-2">Order Summary</h2>
                    
                    <div class="flex justify-between mb-4">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-white font-medium">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-6 pb-6 border-b border-gray-600">
                        <span class="text-gray-400">Digital Delivery</span>
                        <span class="text-emerald-400 font-medium">Free</span>
                    </div>
                    
                    <div class="flex justify-between mb-8">
                        <span class="text-lg font-bold text-white">Total</span>
                        <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-500">${{ number_format($total, 2) }}</span>
                    </div>
                    
                    <a href="{{ route('checkout.index') }}" class="block w-full text-center bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold py-3 px-4 rounded transition-all shadow-[0_0_15px_rgba(79,70,229,0.3)]">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
