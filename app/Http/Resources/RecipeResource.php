<?php

namespace App\Http\Resources;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Recipe */
class RecipeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'imageUrl' => asset('storage/'.$this->imageUrl),
            'prepTime' => $this->prepTime,
            'likes' => $this->likes_count,
            'is_liked' => $this->resource->isLikedBy($request->headers->get('X-Device-Id')),
            'calories' => $this->calories,
            'protein' => $this->protein,
            'carbs' => $this->carbs,
            'fats' => $this->fats,
            'ingredients' => $this->ingredients,
            'instructions' => $this->instructions,
            'category' => $this->category,
        ];
    }
}
