<?php

namespace App\Actions\SMS;

use App\Actions\SendInterface;
use App\Enums\Methods\SMSApiMethodsEnum;
use App\Models\Joke;
use App\Models\User;
use App\Trait\ClearPhoneTrait;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

abstract class SmsAction
{
    use ClearPhoneTrait;

    public Client $client;
    public string $key;
    public string $project;
    protected string $url;

    public function __construct()
    {
        $this->client = new Client();
        $this->key = config('app.mainSmsKey');
        $this->project = config('app.mainSmsProject');
        $this->url = config('app.mainSmsURL');
    }


    public function response(
        SMSApiMethodsEnum $method,
        User $user = null,
        Joke $joke = null
    ): \Psr\Http\Message\ResponseInterface {
        $response = $this->client->request('GET', $this->url . $method->value, [
            'headers' => [
                'Accept' => 'application/json',
            ],
            'form_params' => [
                'project' => $this->project,
                'recipients' => isset($user) ? $this->clearPhone($user->phone) : null,
                'message' => $joke?->body,
                'apikey' => $this->key,
                'test' => config('app.mainSmsTestMode')
            ],
        ]);
        return $response;
    }

    public function handleSmsResponse(
        $status,
        string|array $message,
    ): JsonResponse {
        Log::channel('sms')->info($message);
        return response()->json($status, $message);
    }
}