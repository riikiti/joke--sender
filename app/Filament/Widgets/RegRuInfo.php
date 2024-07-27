<?php

namespace App\Filament\Widgets;

use App\Actions\RegRu\GetRegRuBasicInfo;
use App\Actions\SMS\GetBalanceSmsAction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use GuzzleHttp\Exception\GuzzleException;

class RegRuInfo extends BaseWidget
{
    protected static ?int $sort = 2;
    /**
     * @throws GuzzleException
     */
    protected function getStats(): array
    {
        $action = new GetRegRuBasicInfo();
        $smsAction = new GetBalanceSmsAction();
        return [
            Stat::make('Баланс на сервере', $action->getBalance() . ' руб')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Сервер будет работать', round($action->getHoursLeft(),2) . ' дней(ня)')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Баланс на SMS', $smsAction->getBalance()->balance . ' руб')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
        ];
    }
}
