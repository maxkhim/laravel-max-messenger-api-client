<?php

namespace Maxkhim\MaxMessengerApiClient\Clients;

use Maxkhim\MaxMessengerApiClient\Clients\Requests\MaxBotRequest;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Bots;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Chats;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Messages;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Subscriptions;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Updates;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Upload;

class MaxMessengerClient
{
    private ?Bots $bots = null;
    private ?Chats $chats = null;
    private ?Messages $messages = null;
    private ?Updates $updates = null;
    private ?Subscriptions $subscriptions = null;
    private ?Upload $upload = null;
    private MaxBotRequest $request;
    public function __construct(?string $apiToken = null, ?string $apiHost = null)
    {
        if (!$apiHost) {
            $apiHost = config("max-messenger-client.base_uri");
        }

        if (!$apiToken) {
            $apiToken = config("max-messenger-client.access_token");
        }

        $this->request = new MaxBotRequest($apiHost, $apiToken);
    }

    public function bots(): Bots
    {
        return $this->bots ??= new Bots($this->request);
    }

    public function chats(): Chats
    {
        return $this->chats ??= new Chats($this->request);
    }

    public function messages(): Messages
    {
        return $this->messages ??= new Messages($this->request);
    }

    public function updates(): Updates
    {
        return $this->updates ??= new Updates($this->request);
    }

    public function upload(): Upload
    {
        return $this->upload ??= new Upload($this->request);
    }

    public function subscriptions(): Subscriptions
    {
        return $this->subscriptions ??= new Subscriptions($this->request);
    }

    // Магические методы для удобного доступа
    public function __call($method, $parameters)
    {
        if (method_exists($this->chats(), $method)) {
            return $this->chats()->$method(...$parameters);
        }

        if (method_exists($this->messages(), $method)) {
            return $this->messages()->$method(...$parameters);
        }

        throw new \BadMethodCallException("Метод {$method} не существует.");
    }
}
