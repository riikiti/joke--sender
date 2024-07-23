<?php

namespace App\Actions\Telegram;

use App\Actions\SendInterface;
use App\Models\Joke;
use Illuminate\Support\Facades\Storage;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Polling;
use SergiX44\Nutgram\RunningMode\Webhook;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Internal\InputFile;

class SendTelegramAction implements SendInterface
{
    public Nutgram $bot;
    public int $chat;

    public function __construct()
    {
        $this->bot = new Nutgram(config('app.tgToken'));
        $this->chat = intval(config('app.tgChannel'));
    }

    public function send(Joke $joke): void
    {
        $joke->fill(['completed' => true])->save();
        if ($joke->photo) {
            $filePath = storage_path('app/public/' . $joke->photo);
            $photo = fopen($filePath, 'r+');
            $this->bot->sendPhoto(
                photo: InputFile::make($photo),
                chat_id: $this->chat,
                caption: $joke->body,
            );
        }
        else{
            $this->bot->sendMessage(
                text: $joke->body,
                chat_id: intval(env('TELEGRAM_CHANNEL')),
                parse_mode: ParseMode::HTML,
            );
        }
    }
}