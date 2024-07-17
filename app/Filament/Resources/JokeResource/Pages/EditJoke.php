<?php

namespace App\Filament\Resources\JokeResource\Pages;

use App\Filament\Resources\JokeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJoke extends EditRecord
{
    protected static string $resource = JokeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
