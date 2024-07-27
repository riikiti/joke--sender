<?php

namespace App\Enums\Response;

enum SmsResponseMessagesEnum :string
{
  case SMS_CONFIRM = 'Отправлена SMS по номеру - ';
  case SMS_REJECT = 'SMS не отправлена со статусом: ';
}
