<?php

namespace App\Models;

use App\Enums\RecipeCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'imageUrl',
        'prepTime',
        'likes',
        'calories',
        'protein',
        'carbs',
        'fats',
        'ingredients',
        'instructions',
        'category',
    ];

    protected function casts(): array
    {
        return [
            'ingredients' => 'json',
            'instructions' => 'json',
            'category' => RecipeCategory::class,
        ];
    }
}
