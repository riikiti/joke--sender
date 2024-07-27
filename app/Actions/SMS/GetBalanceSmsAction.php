<?php

namespace App\Actions\SMS;

use App\Actions\SendInterface;
use App\Enums\Methods\SMSApiMethodsEnum;
use App\Enums\Response\SmsResponseMessagesEnum;
use App\Models\Joke;
use App\Models\Recipient;
use App\Models\User;
use App\Trait\ClearPhoneTrait;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class GetBalanceSmsAction extends SmsAction
{
    public function getBalance()
    {
        return  json_decode($this->response(SMSApiMethodsEnum::BALANCE)->getBody()->getContents());
    }

}