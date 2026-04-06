@extends('layouts.admin')

@section('header', 'Dashboard Overview')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Cards -->
    <div class="bg-[#0d0d1a] rounded-2xl p-6 border border-white/[0.06]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" /></svg>
            </div>
            <div>
                <p class="text-2xl font-black text-white">${{ number_format($totalRevenue, 2) }}</p>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Revenue</p>
            </div>
        </div>
    </div>
    <div class="bg-[#0d0d1a] rounded-2xl p-6 border border-white/[0.06]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-indigo-500/10 border border-indigo-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" /></svg>
            </div>
            <div>
                <p class="text-2xl font-black text-white">{{ $totalOrders }}</p>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Orders</p>
            </div>
        </div>
    </div>
    <div class="bg-[#0d0d1a] rounded-2xl p-6 border border-white/[0.06]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-purple-500/10 border border-purple-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.313-.642.684-.526A7.5 7.5 0 0121 12a7.5 7.5 0 01-6.066 7.358c-.37.116-.684-.17-.684-.526V6.087zM10.5 6.087c0-.355-.313-.642-.684-.526A7.5 7.5 0 003 12a7.5 7.5 0 006.066 7.358c.37.116.684-.17.684-.526V6.087z" /></svg>
            </div>
            <div>
                <p class="text-2xl font-black text-white">{{ $totalGames }}</p>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Available Games</p>
            </div>
        </div>
    </div>
    <div class="bg-[#0d0d1a] rounded-2xl p-6 border border-white/[0.06]">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-pink-500/10 border border-pink-500/20 flex items-center justify-center">
                <svg class="w-6 h-6 text-pink-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" /></svg>
            </div>
            <div>
                <p class="text-2xl font-black text-white">{{ $totalUsers }}</p>
                <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Registered Users</p>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="bg-[#0d0d1a] rounded-2xl border border-white/[0.06] overflow-hidden">
    <div class="p-6 border-b border-white/[0.06]">
        <h2 class="text-lg font-bold text-white tracking-tight">Recent Orders</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white/[0.02]">
                <tr>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/[0.04]">
                @forelse($recentOrders as $order)
                <tr class="hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-white">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">{{ $order->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-400">${{ number_format($order->total_price, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-600">No recent orders found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
