<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Recipe;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Recipe::factory()->count(10)->create();
        Like::factory(1000)->create();
    }
}
