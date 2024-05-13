<?php

namespace App\Filament\Resources\PromotionResource\Pages;

use App\Filament\Resources\PromotionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPromotion extends EditRecord
{
    protected static string $resource = PromotionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
