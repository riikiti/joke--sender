<?php

namespace App\Actions\Telegram;

use App\Actions\SendInterface;
use App\Models\Joke;
use SergiX44\Nutgram\Nutgram;
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

    public function send(Joke $joke)
    {
        $joke->fill(['completed' => true])->save();
        if (empty( $joke->photo)) {
            $this->bot->sendMessage(
                text: $joke->body,
                chat_id: intval(env('TELEGRAM_CHANNEL')),
                parse_mode: ParseMode::HTML,
            );
        }
        else{
            $this->bot->sendPhoto(
                photo: InputFile::make($joke->photo),
                chat_id: $this->chat,
                caption: $joke->body,
            );
        }

        $this->bot->run();
    }
}