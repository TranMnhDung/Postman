<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RecipeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Recipes CRUD APIs
Route::prefix('recipes')->group(function () {
    Route::get('/', [RecipeController::class, 'index']);          // GET all recipes
    Route::get('/{id}', [RecipeController::class, 'show']);       // GET recipe by ID
    Route::post('/', [RecipeController::class, 'store']);         // POST create recipe
    Route::put('/{id}', [RecipeController::class, 'update']);     // PUT update recipe
    Route::delete('/{id}', [RecipeController::class, 'destroy']); // DELETE recipe
});

// Hoặc sử dụng Resource Route (cách ngắn gọn hơn)
// Route::apiResource('recipes', RecipeController::class, [
//     'parameters' => ['recipes' => 'id']
// ]);