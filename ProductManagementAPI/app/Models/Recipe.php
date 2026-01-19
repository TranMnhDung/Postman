<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    protected $primaryKey = 'recipe_id';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'cooking_time',
        'servings',
        'difficulty',
        'image_url',
        'status',
        'views'
    ];
}
