<?php

namespace App\Enums\Methods;

enum TelegramApiMethodsEnum: string
{
    case Count = 'getChatMemberCount';
    case Administrator = 'getChatAdministrators';
    case Info = 'getChat';
}
