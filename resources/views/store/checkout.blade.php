@extends('layouts.store')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-[60vh]">
    <h1 class="text-3xl font-extrabold text-white mb-8">Simulated Checkout</h1>

    @if(session('error'))
        <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded mb-6">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col md:flex-row gap-8">
        <!-- Form -->
        <div class="flex-1">
            <div class="bg-[#111827] rounded-xl border border-gray-800 p-8 shadow-xl">
                <h2 class="text-xl font-bold text-white mb-6 uppercase tracking-wider flex items-center gap-2">
                    <svg class="h-6 w-6 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Payment Details
                </h2>

                <p class="text-sm text-gray-500 italic mb-6">Note: This is a simulated environment. We do not validate real cards.</p>

                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-6">
                        <div>
                            <label for="card_number" class="block text-sm font-medium text-gray-300 mb-2">Card Number</label>
                            <input type="text" id="card_number" name="card_number" required placeholder="0000 0000 0000 0000" maxlength="19" class="w-full bg-gray-900 border-gray-700 text-white rounded focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-4 py-3 placeholder-gray-600 font-mono text-lg tracking-widest leading-none">
                            @error('card_number')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                        </div>

                        <div class="flex space-x-6">
                            <div class="flex-1">
                                <label for="expiry" class="block text-sm font-medium text-gray-300 mb-2">Valid thru</label>
                                <input type="text" id="expiry" name="expiry" required placeholder="MM/YY" class="w-full bg-gray-900 border-gray-700 text-white rounded focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-4 py-3 placeholder-gray-600 font-mono text-lg text-center" maxlength="5">
                                @error('expiry')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                            </div>
                            <div class="flex-1">
                                <label for="cvc" class="block text-sm font-medium text-gray-300 mb-2">CVC</label>
                                <input type="text" id="cvc" name="cvc" required placeholder="123" class="w-full bg-gray-900 border-gray-700 text-white rounded focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 px-4 py-3 placeholder-gray-600 font-mono text-lg text-center" maxlength="4">
                                @error('cvc')<span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-4 px-4 rounded flex items-center justify-center gap-2 transition duration-300 shadow-[0_0_20px_rgba(79,70,229,0.4)]">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                Pay ${{ number_format($total, 2) }} Securely
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Order Total summary -->
        <div class="md:w-80 w-full shrink-0">
            <div class="bg-[#1F2937] p-6 rounded-xl border border-gray-700 shadow-md">
                <h3 class="text-white font-bold mb-4 border-b border-gray-600 pb-2">Order Items</h3>
                <ul class="space-y-4 mb-6">
                    @foreach($cart as $item)
                    <li class="flex justify-between text-sm text-gray-300">
                        <span>{{ $item['quantity'] }}x {{ $item['title'] }}</span>
                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </li>
                    @endforeach
                </ul>
                <div class="flex justify-between pt-4 border-t border-gray-600">
                    <span class="text-white font-bold text-lg">Subtotal</span>
                    <span class="text-emerald-400 font-bold text-xl">${{ number_format($total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Auto-format card number with spaces every 4 digits
    document.getElementById('card_number').addEventListener('input', function (e) {
        let value = this.value.replace(/\s+/g, '').replace(/[^0-9]/g, '');
        let formatted = value.match(/.{1,4}/g);
        this.value = formatted ? formatted.join(' ') : '';
    });

    // Simple mask for expiry
    document.getElementById('expiry').addEventListener('input', function (e) {
        let value = this.value.replace(/[^0-9]/g, '');
        if (value.length >= 2) {
            this.value = value.substring(0, 2) + '/' + value.substring(2, 4);
        } else {
            this.value = value;
        }
    });

    // CVC: numbers only
    document.getElementById('cvc').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
