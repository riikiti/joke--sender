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

class SendSmsAction extends SmsAction implements SendInterface
{

    /**
     * @throws GuzzleException
     */
    public function send(Joke $joke)
    {
        $users = Recipient::where('phone', '!=', null)->get();
        foreach ($users as $user) {
            try {
                $response = $this->response(SMSApiMethodsEnum::SEND, $user, $joke);
                if ($response->getStatusCode() === 200) {
                    $joke->fill(['completed' => true])->save();
                    return $this->handleSmsResponse(
                        true,
                        ['message' => SmsResponseMessagesEnum::SMS_CONFIRM->value . $user->phone]
                    );
                } else {
                    return $this->handleSmsResponse(
                        true,
                        ['message' => SmsResponseMessagesEnum::SMS_REJECT->value . $response->getStatusCode()]
                    );
                }
            } catch (RequestException $e) {
                Log::channel('sms')->info($e->getMessage());
                throw new Exception($e->getMessage());
            }
        }
    }

}