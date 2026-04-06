<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameController extends Controller
{
    public function index()
    {
        $games = Game::with('category')->withCount('keys')->get();
        return view('admin.games.index', compact('games'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.games.form', ['game' => new Game(), 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'platform' => 'required|in:PC,PlayStation',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }
        
        Game::create($data);

        return redirect()->route('admin.games.index')->with('success', 'Game created successfully.');
    }

    public function edit(Game $game)
    {
        $categories = Category::all();
        return view('admin.games.form', compact('game', 'categories'));
    }

    public function update(Request $request, Game $game)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'platform' => 'required|in:PC,PlayStation',
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('cover_image')) {
            if ($game->cover_image) {
                Storage::disk('public')->delete($game->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }
        
        $game->update($data);

        return redirect()->route('admin.games.index')->with('success', 'Game updated successfully.');
    }

    public function destroy(Game $game)
    {
        if ($game->cover_image) {
            Storage::disk('public')->delete($game->cover_image);
        }
        $game->delete();
        return redirect()->route('admin.games.index')->with('success', 'Game deleted successfully.');
    }
}
