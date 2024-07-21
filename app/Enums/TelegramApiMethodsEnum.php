<?php

namespace App\Enums;

enum TelegramApiMethodsEnum: string
{
    case Count = 'getChatMemberCount';
    case Administrator = 'getChatAdministrators';
    case Info = 'getChat';
}
