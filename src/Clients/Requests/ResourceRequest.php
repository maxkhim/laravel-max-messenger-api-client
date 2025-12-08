<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Requests;

abstract class ResourceRequest
{
    private MaxBotRequest $request;

    /**
     * ResourceRequest constructor.
     *
     * @param MaxBotRequest $request
     */
    public function __construct(MaxBotRequest $request)
    {
        $this->request = $request;
    }

    public function getRequest(): MaxBotRequest
    {
        return $this->request;
    }
}