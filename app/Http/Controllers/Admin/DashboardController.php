<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = \App\Models\Order::sum('total_price');
        $totalOrders = \App\Models\Order::count();
        $totalGames = \App\Models\Game::count();
        $totalUsers = \App\Models\User::where('role', 'client')->count();

        $recentOrders = \App\Models\Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalGames', 'totalUsers', 'recentOrders'
        ));
    }
}
