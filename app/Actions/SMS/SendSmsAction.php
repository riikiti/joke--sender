<?php

namespace App\Actions\SMS;

use App\Actions\SendInterface;
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

class SendSmsAction implements SendInterface
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

    /**
     * @throws GuzzleException
     */
    public function send(Joke $joke)
    {
        $users = Recipient::where('phone', '!=', null)->get();
        foreach ($users as $user) {
            try {
                $response = $this->client->request('GET', $this->url, [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                    'form_params' => [
                        'project' => $this->project,
                        'recipients' => $this->clearPhone($user->phone),
                        'message' => $joke->body,
                        'apikey' => $this->key,
                        'test' => config('app.mainSmsTestMode')
                    ],
                ]);
                $statusCode = $response->getStatusCode();
                if ($statusCode === 200) {
                    $joke->fill(['completed' => true])->save();
                    return $this->handleSmsResponse(
                        true,
                        ['message' => 'Отправлена SMS по номеру - ' . $user->phone]
                    );
                } else {
                    return $this->handleSmsResponse(
                        true,
                        ['message' => 'SMS не отправлена со статусом: ' . $statusCode]
                    );
                }
            } catch (RequestException $e) {
                Log::channel('sms')->info($e->getMessage());
                throw new Exception($e->getMessage());
            }
        }
    }

    private function handleSmsResponse(
        $status,
        string|array $message,
    ): JsonResponse {
        Log::channel('sms')->info($message);
        return response()->json($status, $message);
    }
}