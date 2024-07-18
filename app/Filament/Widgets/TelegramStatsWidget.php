<?php

namespace App\Filament\Widgets;

use App\Models\Joke;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TelegramStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Опубликовано шуток Telegram', Joke::where('published_at', '<=', now())->where('tg',true)->count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Запланировано шуток Telegram', Joke::where('published_at', '>=', now())->where('tg',true)->count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
