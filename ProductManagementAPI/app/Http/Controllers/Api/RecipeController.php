<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // GET ALL
    public function index()
    {
        return response()->json(Recipe::all(), 200);
    }

    // POST - CREATE
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'difficulty' => 'required|string',
            'status' => 'required|string'
        ]);

        $recipe = Recipe::create($request->all());

        return response()->json([
            'message' => 'Created successfully',
            'data' => $recipe
        ], 201);
    }

    // GET BY ID
    public function show($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($recipe, 200);
    }

    // PUT - UPDATE
    public function update(Request $request, $id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $recipe->update($request->all());

        return response()->json([
            'message' => 'Updated successfully',
            'data' => $recipe
        ], 200);
    }

    // DELETE
    public function destroy($id)
    {
        $recipe = Recipe::find($id);

        if (!$recipe) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $recipe->delete();

        return response()->json(['message' => 'Deleted successfully'], 200);
    }
}
