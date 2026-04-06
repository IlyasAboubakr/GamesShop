<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Support\Facades\Session;

class CartService
{
    private string $sessionKey = 'cart';

    public function getCart()
    {
        return Session::get($this->sessionKey, []);
    }

    public function add(int $gameId, int $quantity = 1): void
    {
        $cart = $this->getCart();

        if (array_key_exists($gameId, $cart)) {
            $cart[$gameId]['quantity'] += $quantity;
        } else {
            $game = Game::findOrFail($gameId);
            $cart[$gameId] = [
                'id' => $game->id,
                'title' => $game->title,
                'price' => $game->price,
                'cover_image' => $game->cover_image,
                'platform' => $game->platform,
                'quantity' => $quantity,
            ];
        }

        Session::put($this->sessionKey, $cart);
    }

    public function updateQuantity(int $gameId, int $quantity): void
    {
        $cart = $this->getCart();
        
        if (array_key_exists($gameId, $cart)) {
            if ($quantity <= 0) {
                unset($cart[$gameId]);
            } else {
                $cart[$gameId]['quantity'] = $quantity;
            }
            Session::put($this->sessionKey, $cart);
        }
    }

    public function remove(int $gameId): void
    {
        $cart = $this->getCart();
        
        if (array_key_exists($gameId, $cart)) {
            unset($cart[$gameId]);
            Session::put($this->sessionKey, $cart);
        }
    }

    public function clear(): void
    {
        Session::forget($this->sessionKey);
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getCart() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}
