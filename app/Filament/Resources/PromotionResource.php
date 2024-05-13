<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromotionResource\Pages;
use App\Models\Promotion;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PromotionResource extends Resource
{
    protected static ?string $model = Promotion::class;

    protected static ?string $slug = 'promotions';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()->label('Название'),

                FileUpload::make('image')
                    ->required()
                    ->label('Картинка')
                    ->visibility('public')
                    ->directory('/media/images/promotions'),

                Textarea::make('description')
                    ->required()
                    ->label('Описание'),

                TextInput::make('link')
                    ->required()->label('Ссылка на нужный каталог'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()->label('Название'),

                ImageColumn::make('image')->label('Картинка'),

                TextColumn::make('link')->label('Ссылка'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListPromotions::route('/'),
            'create' => Pages\CreatePromotion::route('/create'),
            'edit' => Pages\EditPromotion::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
