<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\Step;
use App\Models\Review;

class Recipe extends Model
{
   protected $fillable = [
    'user_id',
    'title',
    'description',
    'cooking_time',
    'servings',
    'difficulty',
    'status',
    'image_url' // <--- THÊM DÒNG NÀY
];

    public function steps()
    {
        return $this->hasMany(Step::class, 'recipe_id');
    }
}

