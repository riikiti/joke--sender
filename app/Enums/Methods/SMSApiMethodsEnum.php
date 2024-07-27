<?php

namespace App\Enums\Methods;

enum SMSApiMethodsEnum: string
{
    case SEND = 'send';
    case BALANCE = 'balance';
}
