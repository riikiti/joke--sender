<?php

namespace App\Console\Commands;

use App\Actions\SMS\SendSmsAction;
use App\Jobs\SmsJokeSenderJob;
use App\Models\Joke;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-sms-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send sms command';

    /**
     * Execute the console command.
     */
    public function handle(SendSmsAction $action): int
    {
        $jokes = Joke::whereDate('published_at', Carbon::today())->where('sms',true)->where('completed',false)->get();
        foreach ($jokes as $joke) {
            $action ->send($joke);
        }
        return self::SUCCESS;
    }
}
