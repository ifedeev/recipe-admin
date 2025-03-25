<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum RecipeCategory: string implements HasLabel, HasIcon
{
    case Breakfast = 'breakfast';

    case Lunch = 'lunch';

    case Dinner = 'dinner';

    case Snack = 'snack';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Breakfast => 'Завтрак',
            self::Snack => 'Закуска',
            self::Lunch => 'Обед',
            self::Dinner => 'Ужин',
        };
    }


    public function getIcon(): ?string
    {
        return match ($this) {
            self::Breakfast => 'heroicon-o-sun',
            self::Snack => 'heroicon-o-cake',
            self::Lunch => 'heroicon-o-fire',
            self::Dinner => 'heroicon-o-moon',
        };
    }
}
