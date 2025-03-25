<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        return RecipeResource::collection(Recipe::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required'],
            'imageUrl' => ['required'],
            'prepTime' => ['required', 'integer'],
            'likes' => ['required', 'integer'],
            'colories' => ['required', 'integer'],
            'protein' => ['required', 'integer'],
            'carbs' => ['required', 'integer'],
            'fats' => ['required'],
            'ingredients' => ['required'],
            'instructions' => ['required'],
            'category' => ['required'],
        ]);

        return new RecipeResource(Recipe::create($data));
    }

    public function show(Recipe $recipe)
    {
        return new RecipeResource($recipe);
    }

    public function update(Request $request, Recipe $recipe)
    {
        $data = $request->validate([
            'title' => ['required'],
            'imageUrl' => ['required'],
            'prepTime' => ['required', 'integer'],
            'likes' => ['required', 'integer'],
            'colories' => ['required', 'integer'],
            'protein' => ['required', 'integer'],
            'carbs' => ['required', 'integer'],
            'fats' => ['required'],
            'ingredients' => ['required'],
            'instructions' => ['required'],
            'category' => ['required'],
        ]);

        $recipe->update($data);

        return new RecipeResource($recipe);
    }

    public function destroy(Recipe $recipe)
    {
        $recipe->delete();

        return response()->json();
    }
}
