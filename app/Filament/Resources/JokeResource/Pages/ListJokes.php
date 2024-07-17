<?php

namespace App\Filament\Resources\JokeResource\Pages;

use App\Filament\Resources\JokeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJokes extends ListRecords
{
    protected static ?string $title = 'Шутки';
    protected static string $resource = JokeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
