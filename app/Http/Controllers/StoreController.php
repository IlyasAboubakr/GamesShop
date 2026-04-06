<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $featuredGames = Game::with('category')->latest()->take(8)->get();
        return view('store.index', compact('featuredGames'));
    }

    public function browse(Request $request)
    {
        $query = Game::with('category');
        
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }
        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $games = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('store.browse', compact('games', 'categories'));
    }

    public function show(Game $game)
    {
        $game->load(['category', 'reviews.user']);
        return view('store.show', compact('game'));
    }
}
