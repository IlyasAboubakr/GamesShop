<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GameKey;
use App\Models\Game;
use Illuminate\Http\Request;

class GameKeyController extends Controller
{
    public function index()
    {
        $keys = GameKey::with(['game', 'order'])->latest()->paginate(50);
        return view('admin.keys.index', compact('keys'));
    }

    public function create()
    {
        $games = Game::all();
        return view('admin.keys.create', compact('games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'keys' => 'required|string',
        ]);
        
        $keyCodes = preg_split('/[\s,]+/', $request->keys, -1, PREG_SPLIT_NO_EMPTY);
        
        $added = 0;
        foreach ($keyCodes as $code) {
            $code = trim($code);
            if (!GameKey::where('key_code', $code)->exists()) {
                GameKey::create([
                    'game_id' => $request->game_id,
                    'key_code' => $code,
                    'is_used' => false,
                ]);
                $added++;
            }
        }
        
        $game = Game::find($request->game_id);
        $game->increment('stock', $added);

        return redirect()->route('admin.keys.index')->with('success', "{$added} new keys added successfully.");
    }
    
    public function destroy(GameKey $key)
    {
        if ($key->is_used) {
            return back()->with('error', 'Cannot delete a used key because it belongs to an order.');
        }
        $game = $key->game;
        $key->delete();
        $game->decrement('stock');
        return back()->with('success', 'Key deleted successfully.');
    }
}
