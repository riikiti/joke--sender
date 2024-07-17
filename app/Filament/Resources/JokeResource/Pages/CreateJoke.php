<?php

namespace App\Filament\Resources\JokeResource\Pages;

use App\Filament\Resources\JokeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJoke extends CreateRecord
{
    protected static string $resource = JokeResource::class;
}
