<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('likes', static function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Recipe::class, 'recipe_id');
            $table->string('device_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('likes');
    }
};
