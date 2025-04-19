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

    public function isLiked(?string $deviceId): bool
    {
        if (is_null($deviceId)) {
            return false;
        }

        return $this->likes()->where('device_id', $deviceId)->exists();
    }

    protected function casts(): array
    {
        return [
            'fats' => 'integer',
            'ingredients' => 'json',
            'instructions' => 'json',
            'category' => RecipeCategory::class,
        ];
    }
}
