<?php

namespace App\Filament\Widgets;

use App\Models\Joke;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class JokeChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    protected static ?int $sort = 3;
    public function getHeading(): string
    {
        return "Новые шутки за " . Carbon::now()->translatedFormat('F');
    }

    protected function getData(): array
    {
        $amounts = $this->getTransactionPerMonth();
        return [
            'datasets' => [
                [
                    'label' => 'Шутки',
                    'data' => $amounts['userCountsByDay']
                ],
            ],
            'labels' => $amounts['daysInMonth']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    public function getTransactionPerMonth(): array
    {
        $now = Carbon::now();
        $userCountsByDay = [];
        $daysInMonth = collect(range(1, $now->endOfMonth()->day))->map(function ($day) use ($now, &$userCountsByDay) {
            $date = $now->day($day);
            $userCount = Joke::whereDate('published_at', $date->format('Y-m-d'))->count();
            $userCountsByDay[] = $userCount;
            return $date->translatedFormat('d');
        })->toArray();
        return [
            'userCountsByDay' => $userCountsByDay,
            'daysInMonth' => $daysInMonth
        ];
    }
}
