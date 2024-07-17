<?php

namespace App\Console\Commands;

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
    public function handle(): int
    {
        $jokes = Joke::whereDate('publish_at', Carbon::today())->where('publish_at', '<=', now())->get();
        foreach ($jokes as $joke) {
            SmsJokeSenderJob::dispatch($joke);
        }
        return self::SUCCESS;
    }
}
