<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Resources;

use Maxkhim\MaxMessengerApiClient\Clients\Requests\MaxBotRequest;
use Maxkhim\MaxMessengerApiClient\Clients\Requests\ResourceRequest;

class Bots extends ResourceRequest
{
    public function getMyInfo()
    {
        return $this->getRequest()->get('/me');
    }

    public function updateBotInfo(array $data)
    {
        return $this->getRequest()->patch('/me', $data);
    }
}
