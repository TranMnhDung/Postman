<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // 1. GET ALL
    public function index()
    {
        return response()->json(Recipe::all(), 200);
    }

    // 2. GET BY ID
    public function show($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }

        return response()->json($recipe, 200);
    }

    // 3. POST
    public function store(Request $request)
    {
        $recipe = Recipe::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
            'cooking_time' => $request->cooking_time,
            'servings' => $request->servings,
            'difficulty' => $request->difficulty,
            'image_url' => $request->image_url,
            'status' => 'Published',
            'views' => 0
        ]);

        return response()->json($recipe, 201);
    }

    // 4. PUT
    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }

        $recipe->update($request->all());

        return response()->json($recipe, 200);
    }

    // 5. DELETE
    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Recipe not found'], 404);
        }

        $recipe->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
