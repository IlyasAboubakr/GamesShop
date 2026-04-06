<?php

namespace App\Services;

use App\Models\Game;
use App\Models\GameKey;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class CheckoutService
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function processCheckout(User $user, array $paymentDetails): Order
    {
        $cart = $this->cartService->getCart();
        
        if (empty($cart)) {
            throw new Exception("Cart is empty.");
        }

        // Fake payment simulation (always pass in this demo unless configured)
        if (empty($paymentDetails['card_number']) || empty($paymentDetails['cvc'])) {
            throw new Exception("Invalid payment details.");
        }

        return DB::transaction(function () use ($user, $cart) {
            $totalPrice = $this->cartService->getTotal();

            // 1. Create Order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $totalPrice,
            ]);

            // 2. Assign keys and deduct stock
            foreach ($cart as $gameId => $item) {
                $game = Game::lockForUpdate()->findOrFail($gameId);
                $quantityNeeded = $item['quantity'];

                // Generating random keys for the purchased game as requested by user logic
                for ($i = 0; $i < $quantityNeeded; $i++) {
                    GameKey::create([
                        'game_id' => $game->id,
                        'order_id' => $order->id,
                        'key_code' => strtoupper(\Illuminate\Support\Str::random(4) . '-' . \Illuminate\Support\Str::random(4) . '-' . \Illuminate\Support\Str::random(4) . '-' . \Illuminate\Support\Str::random(4)),
                        'is_used' => true,
                    ]);
                }

                // Deduct stock from game table
                $game->decrement('stock', $quantityNeeded);

                // Create Order Item
                OrderItem::create([
                    'order_id' => $order->id,
                    'game_id' => $game->id,
                    'price' => $item['price'],
                    'quantity' => $quantityNeeded,
                ]);
            }

            // 3. Clear cart
            $this->cartService->clear();

            return $order;
        });
    }
}
