<?php

namespace App\Filament\Widgets;

use App\Models\Joke;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Всего пользователей для SMS', User::count())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
