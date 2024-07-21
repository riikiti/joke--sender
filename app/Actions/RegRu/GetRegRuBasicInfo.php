<?php

namespace App\Actions\RegRu;

use App\Enums\RegRuApiMethodsEnum;
use GuzzleHttp\Exception\GuzzleException;

class GetRegRuBasicInfo extends GetRegRu
{
    /**
     * @throws GuzzleException
     */
    public function getBalance(): int
    {
        $object = $this->getObject(RegRuApiMethodsEnum::Balance->value);
        return $object->balance_data->balance;
    }

    /**
     * @throws GuzzleException
     */
    public function getHoursLeft(): float
    {
        $object = $this->getObject(RegRuApiMethodsEnum::Balance->value);
        return $object->balance_data->hours_left / 24;
    }
}