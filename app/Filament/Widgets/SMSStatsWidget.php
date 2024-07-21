<?php

namespace App\Filament\Widgets;

use App\Models\Joke;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SMSStatsWidget extends BaseWidget
{
    protected static ?int $sort = 6;
    protected function getStats(): array
    {
        return [
            Stat::make('Опубликовано шуток SMS', Joke::where('published_at', '<=', now())->where('sms',true)->where('completed',true)->count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Запланировано шуток SMS', Joke::where('published_at', '>=', now())->where('sms',true)->where('completed',false)->count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
