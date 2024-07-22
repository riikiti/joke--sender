<?php

namespace App\Filament\Widgets;

use App\Models\Joke;
use App\Models\Recipient;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JokeStatsWidget extends BaseWidget
{
    protected static ?int $sort = 5;
    protected function getStats(): array
    {
        return [
            Stat::make('Всего шуток', Joke::count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Всего пользователей для SMS', Recipient::count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('На скольк дней хватит постов', (Joke::query()->where('completed',false)->count())/3 . ' дней')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
