<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $table = 'steps';

    protected $fillable = [
        'recipe_id',
        'step_order',
        'content'
    ];

    public $timestamps = false;

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id');
    }
}

