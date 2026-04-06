<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = ['title', 'description', 'price', 'platform', 'category_id', 'stock', 'cover_image'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function keys() {
        return $this->hasMany(GameKey::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
