<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService) { 
        $this->cartService = $cartService; 
    }

    public function index() {
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getTotal();
        return view('store.cart', compact('cart', 'total'));
    }

    public function add(Request $request, Game $game) {
        $quantity = $request->input('quantity', 1);
        if ($game->stock < $quantity) { 
            return back()->with('error', 'Not enough stock.'); 
        }
        $this->cartService->add($game->id, (int)$quantity);
        return redirect()->route('cart.index')->with('success', 'Game added to cart.');
    }

    public function update(Request $request, Game $game) {
        $this->cartService->updateQuantity($game->id, (int)$request->quantity);
        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(Game $game) {
        $this->cartService->remove($game->id);
        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }
}
