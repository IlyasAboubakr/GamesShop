@extends('layouts.admin')

@section('header', 'Orders')

@section('content')
<div class="mb-4 flex justify-end">
    <a href="{{ route('admin.orders.export') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-medium text-sm">
        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Export to Excel / CSV
    </a>
</div>
<div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] overflow-x-auto">
    <table class="w-full text-left">
        <thead class="bg-white/[0.02]">
            <tr>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Order ID</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/[0.04]">
            @forelse($orders as $order)
            <tr class="hover:bg-white/[0.02] transition-colors">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $order->user->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-400">${{ number_format($order->total_price, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View Details</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">No orders found.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
