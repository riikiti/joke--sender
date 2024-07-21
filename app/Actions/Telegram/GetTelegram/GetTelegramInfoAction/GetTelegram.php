<?php

namespace App\Actions\Telegram\GetTelegram\GetTelegramInfoAction;

use App\Enums\TelegramApiMethodsEnum;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class GetTelegram
{
    public Client $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => config('app.tgApi'),]);
    }

    /**
     * @throws GuzzleException
     */
    protected function getObject(string $method)
    {
        $response = $this->client->request(
            'GET', $method,
            ['query' => ['chat_id' => intval(config('app.tgChannel'))]]
        );
        return json_decode($response->getBody()->getContents());
    }

}