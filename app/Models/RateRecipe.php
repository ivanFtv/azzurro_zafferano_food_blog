<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateRecipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'recipe_id',
        'rate_id',
        'comment',
    ];

    public function recipe() {
        return $this->belongsTo(Recipe::class);
    }
}
