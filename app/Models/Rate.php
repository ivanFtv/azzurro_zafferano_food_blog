<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = [
        'stars',
        'name'
    ];

    public function recipe() {
        return $this->belongsToMany('App\Models\Recipe')->withPivot('user_id');
    }

    public function user() {
        return $this->belongsToMany('App\Models\User')->withPivot('recipe_id');
    }
}
