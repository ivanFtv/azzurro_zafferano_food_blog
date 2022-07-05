<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',
        'name',
        'img',
        'ingredients',
        'text',
        'keywords',
        'category'
    ];

    public function rates() {
        return $this->belongsToMany('App\Models\RateRecipe')->withPivot('user_id');
    }

}
