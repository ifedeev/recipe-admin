<?php

namespace App\Filament\Resources;

use App\Enums\RecipeCategory;
use App\Filament\Resources\RecipeResource\Pages;
use App\Models\Recipe;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Grid as TableGrid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RecipeResource extends Resource
{
    protected static ?string $model = Recipe::class;

    protected static ?string $slug = 'recipes';

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                FileUpload::make('imageUrl')
                    ->image()
                    ->imageEditor()
                    ->required(),
                Split::make([
                    Grid::make()
                        ->schema([
                            Section::make()
                                ->columnSpanFull()
                                ->schema([
                                    TextInput::make('title')
                                        ->label('Название')
                                        ->maxLength(255)
                                        ->required(),

                                    Select::make('category')
                                        ->native(false)
                                        ->options(RecipeCategory::class),
                                ]),
                            Section::make()
                                ->columnSpanFull()
                                ->schema([
                                    Repeater::make('ingredients')
                                        ->label('Ингридиенты')
                                        ->simple(
                                            TextInput::make('name')
                                                ->required()
                                        ),
                                ]),
                        ])
                        ->columnSpan(3),
                    Section::make()
                        ->grow(false)
                        ->columnSpan(1)
                        ->schema([
                            TextInput::make('prepTime')
                                ->suffixIcon('heroicon-o-clock')
                                ->required()
                                ->integer(),

                            TextInput::make('protein')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => $set('calories', ($get('carbs') * 4) + ($get('protein') * 4) + ($get('fats') * 9)))
                                ->suffix('g')
                                ->required()
                                ->integer(),

                            TextInput::make('carbs')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => $set('calories', ($get('carbs') * 4) + ($get('protein') * 4) + ($get('fats') * 9)))
                                ->suffix('g')
                                ->required()
                                ->integer(),

                            TextInput::make('fats')
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Get $get, Set $set) => $set('calories', ($get('carbs') * 4) + ($get('protein') * 4) + ($get('fats') * 9)))
                                ->suffix('g')
                                ->required(),

                            TextInput::make('calories')
                                ->suffix('kcal')
                                ->required()
                                ->integer(),
                        ]),
                ])
                    ->columns(4),

                Section::make()
                    ->schema([
                        Repeater::make('instructions')
                            ->label('Инструкции')
                            ->simple(
                                Textarea::make('name')
                                    ->required()
                            ),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->selectable(false)
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
            ])
            ->defaultSort('id', 'desc')
            ->columns([
                TableGrid::make(1)
                    ->schema([
                        ImageColumn::make('imageUrl')
                            ->extraImgAttributes([
                                'class' => 'w-full rounded',
                            ])
                            ->height('auto')
                            ->grow(),

                        TextColumn::make('title')
                            ->weight(FontWeight::SemiBold)
                            ->searchable(),

                        TableGrid::make(3)
                            ->schema([
                                TextColumn::make('category')
                                    ->badge(),

                                TextColumn::make('prepTime')
                                    ->icon('heroicon-o-clock')
                                    ->badge()
                                    ->color('gray')
                                    ->alignEnd(),

                                TextColumn::make('likes')
                                    ->badge()
                                    ->color('danger')
                                    ->alignEnd()
                                    ->icon('heroicon-o-heart'),
                            ]),
                    ]),

            ])
            ->filters([
                SelectFilter::make('category')
                    ->options(RecipeCategory::class),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecipes::route('/'),
            'create' => Pages\CreateRecipe::route('/create'),
            'edit' => Pages\EditRecipe::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['title'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Категория' => $record->category->getLabel(),
            'Белки' => $record->protein.'g',
            'Карбоны' => $record->carbs.'g',
            'Жиры' => $record->fats.'g',
        ];
    }
}
