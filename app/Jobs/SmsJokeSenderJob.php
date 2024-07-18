<?php

namespace App\Jobs;

use App\Actions\SMS\SendSmsAction;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsJokeSenderJob implements ShouldQueue
{
    use Queueable;

    public string $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     * @throws GuzzleException
     */
    public function handle(SendSmsAction $action): void
    {
        $action->send($this->message);
    }
}
