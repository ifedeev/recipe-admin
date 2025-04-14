<?php

namespace App\Models;

use App\Enums\RecipeCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    use HasFactory;

    protected $withCount = ['likes'];

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

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class, 'recipe_id');
    }

    protected function casts(): array
    {
        return [
            'ingredients' => 'json',
            'instructions' => 'json',
            'category' => RecipeCategory::class,
        ];
    }
}
