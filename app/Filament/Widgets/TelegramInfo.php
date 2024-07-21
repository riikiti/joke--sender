<?php

namespace App\Filament\Widgets;

use App\Actions\Telegram\GetTelegram\GetTelegramInfoAction\GetTelegramBasicInfo;
use App\Models\Joke;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use GuzzleHttp\Exception\GuzzleException;

class TelegramInfo extends BaseWidget
{
    protected static ?int $sort = 1;
    /**
     * @throws GuzzleException
     */
    protected function getStats(): array
    {
        $action = new GetTelegramBasicInfo();
        return [
            Stat::make('Название канала', $action->getFullInfo()->title)
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            Stat::make('Всего пользователей в tg', $action->getChatMemberCount())
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),

        ];
    }
}
