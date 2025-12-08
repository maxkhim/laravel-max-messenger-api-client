<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Resources;

use Maxkhim\MaxMessengerApiClient\Clients\Requests\MaxBotRequest;
use Maxkhim\MaxMessengerApiClient\Clients\Requests\ResourceRequest;

class Subscriptions extends ResourceRequest
{
    public function getSubscriptions()
    {
        return $this->getRequest()->get('/subscriptions');
    }

    public function subscribe(array $data)
    {
        return $this->getRequest()->post('/subscriptions', $data);
    }

    public function unsubscribe(string $url)
    {
        return $this->getRequest()->delete('/subscriptions', ['url' => $url]);
    }
}