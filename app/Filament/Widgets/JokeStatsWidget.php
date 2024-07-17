<?php

namespace App\Filament\Widgets;

use App\Models\Joke;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class JokeStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всего шуток', Joke::count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Опубликовано шуток', Joke::whereDate('published_at', Carbon::today())->where('published_at', '<=', now())->count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Запланировано шуток', Joke::where('published_at', '>=', now())->count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
