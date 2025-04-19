<?php

namespace App\Http\Controllers;

use App\Enums\RecipeCategory;
use App\Http\Resources\RecipeResource;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\Rule;

class RecipeController extends Controller
{
    public function index(Request $request): JsonResource
    {
        $request->validate([
            'category' => ['sometimes', Rule::enum(RecipeCategory::class)],
            'sort' => ['sometimes', Rule::in(['likes', 'prepTime', 'calories', 'protein', 'carbs', 'fats'])],
            'sort_direction' => ['sometimes', Rule::in(['asc', 'desc'])],
        ]);

        $recipes = Recipe::query()
            ->withCount('likes');

        if ($request->has('category')) {
            $recipes->where('category', $request->input('category'));
        }

        if ($request->has('sort')) {
            $recipes->orderBy($request->input('sort'), $request->input('sort_direction', 'asc'));
        }


        return RecipeResource::collection($recipes->paginate(10));
    }


    public function show(Recipe $recipe): RecipeResource
    {
        return new RecipeResource($recipe);
    }

    public function like(Recipe $recipe, Request $request): JsonResponse
    {
        $recipe->likes()
            ->create([
                'device_id' => $request->header('X-Device-Id')
            ]);

        return response()->json(['message' => 'Recipe liked!'], 201);
    }

    public function dislike(Recipe $recipe, Request $request)
    {
        $recipe->likes()
            ->where('device_id', $request->header('X-Device-Id'))
            ->delete();

        return response()->json(['message' => 'Recipe disliked!'], 200);
    }


    public function likes(Request $request)
    {
        $recipes = Recipe::whereHas('likes', static function ($query) use ($request) {
            $query->where('device_id', $request->header('X-Device-Id'));
        });

        return RecipeResource::collection($recipes->paginate(10));
    }
}
