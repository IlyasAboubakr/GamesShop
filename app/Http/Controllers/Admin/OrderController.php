<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\GameKey;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.game', 'user']);
        $keys = GameKey::where('order_id', $order->id)->with('game')->get();
        
        return view('admin.orders.show', compact('order', 'keys'));
    }

    public function export()
    {
        $orders = Order::with('user')->latest()->get();

        $response = new StreamedResponse(function() use ($orders) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Order ID', 'User Name', 'User Email', 'Total Price', 'Date']);
            
            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->id,
                    $order->user->name,
                    $order->user->email,
                    $order->total_price,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="orders_export.csv"');

        return $response;
    }
}
