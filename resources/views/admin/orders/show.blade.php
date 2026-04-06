@extends('layouts.admin')

@section('header', 'Order Details #' . $order->id)

@section('content')
<div class="mb-6 flex justify-between items-center">
    <a href="{{ route('admin.orders.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400">&larr; Back to Orders</a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-100 dark:border-gray-700 md:col-span-1">
        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Customer Info</h3>
        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $order->user->name }}</p>
        <p class="text-gray-600 dark:text-gray-300">{{ $order->user->email }}</p>
        <p class="text-sm text-gray-500 mt-4">Order placed: {{ $order->created_at->format('M d, Y H:i') }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow-sm border border-gray-100 dark:border-gray-700 md:col-span-2">
        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-4">Assigned Game Keys</h3>
        <ul class="space-y-3">
            @forelse($keys as $key)
                <li class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded flex justify-between items-center">
                    <div>
                        <strong class="text-gray-900 dark:text-white">{{ $key->game->title }}</strong>
                        <div class="font-mono text-sm text-indigo-600 dark:text-indigo-400 mt-1">{{ $key->key_code }}</div>
                    </div>
                </li>
            @empty
                <li class="text-gray-500">No keys assigned.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 overflow-x-auto">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="font-medium text-gray-900 dark:text-white">Order Items Summary</h3>
    </div>
    <table class="w-full text-left">
        <thead class="bg-gray-50 dark:bg-gray-700/50">
            <tr>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Game</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Price (Unit)</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subtotal</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
            @foreach($order->items as $item)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $item->game->title }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${{ number_format($item->price, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $item->quantity }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">${{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-gray-50 dark:bg-gray-700/80 font-bold">
                <td colspan="3" class="px-6 py-4 text-right text-gray-900 dark:text-white">Total:</td>
                <td class="px-6 py-4 text-gray-900 dark:text-white">${{ number_format($order->total_price, 2) }}</td>
            </tr>
        </tfoot>
    </table>
</div>
@endsection
