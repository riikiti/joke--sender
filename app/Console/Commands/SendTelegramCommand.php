<?php

namespace App\Console\Commands;

use App\Actions\Telegram\SendTelegramAction;
use App\Jobs\TelegramSenderJob;
use App\Models\Joke;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendTelegramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-telegram-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send sms telegram';

    /**
     * Execute the console command.
     */
    public function handle(SendTelegramAction $action)
    {
        $jokes = Joke::whereDate('published_at', Carbon::today())->where('published_at', '<=', now())->where('completed',false)->where('tg',true)->get();
        foreach ($jokes as $joke) {
            $action->send($joke);
        }
        return self::SUCCESS;
    }
}
