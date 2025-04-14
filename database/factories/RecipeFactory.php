<?php

namespace Database\Factories;

use App\Enums\RecipeCategory;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'imageUrl' => $this->faker->imageUrl(),
            'prepTime' => $this->faker->randomNumber(),
            'calories' => $this->faker->randomNumber(),
            'protein' => $this->faker->randomNumber(),
            'carbs' => $this->faker->randomNumber(),
            'fats' => $this->faker->randomNumber(),
            'ingredients' => [
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
            ],
            'instructions' => [
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
                $this->faker->realText(random_int(10, 100)),
            ],
            'category' => $this->faker->randomElement(RecipeCategory::cases()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
