<?php

namespace App\Actions\Telegram;

use App\Actions\SendInterface;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;

class SendTelegramAction implements SendInterface
{
    public Nutgram $bot;
    public int $chat;
    public function __construct()
    {
        $this->bot = new Nutgram(config('app.tgToken'));
        $this->chat = intval(config('app.tgChannel'));
    }
    public function send(string $message)
    {
        $this->bot->sendMessage(
            text: $message,
            chat_id: intval(env('TELEGRAM_CHANNEL')),
            parse_mode: ParseMode::HTML,
        );
        $this->bot->run();
    }
}