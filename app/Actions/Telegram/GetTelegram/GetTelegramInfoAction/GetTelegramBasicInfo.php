<?php

namespace App\Actions\Telegram\GetTelegram\GetTelegramInfoAction;

use App\Enums\Methods\TelegramApiMethodsEnum;
use GuzzleHttp\Exception\GuzzleException;

class GetTelegramBasicInfo extends GetTelegram
{
    /**
     * @throws GuzzleException
     */
    public function getChatMemberCount(): int
    {
        $object = $this->getObject(TelegramApiMethodsEnum::Count->value);
        return $object->result;
    }

    /**
     * @throws GuzzleException
     */
    public function getAdministrator(): array|object
    {
        $object = $this->getObject(TelegramApiMethodsEnum::Administrator->value);
        return $object->result;
    }

    /**
     * @throws GuzzleException
     */
    public function getFullInfo(): object
    {
        $object = $this->getObject(TelegramApiMethodsEnum::Info->value);
        return $object->result;
    }

}