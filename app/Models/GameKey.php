<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameKey extends Model
{
    protected $fillable = ['game_id', 'key_code', 'is_used', 'order_id'];

    public function game() {
        return $this->belongsTo(Game::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
