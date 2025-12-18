<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Requests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Maxkhim\MaxMessengerApiClient\Exceptions\MaxBotException;

class MaxBotRequest
{
    protected Client $client;
    protected string $accessToken;
    protected string $apiBaseUri;

    protected bool $error = false;
    protected ?array $errorResponse = null;

    public function __construct($apiBaseUri, $accessToken)
    {
        $this->accessToken = $accessToken;
        $this->apiBaseUri = $apiBaseUri;
        $this->client = new Client([
            'base_uri' => $this->apiBaseUri,
            'timeout' => config('max-messenger-client.timeout', 30),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => $this->accessToken,
            ],
        ]);
    }

    protected function request(string $method, string $endpoint, array $options = [])
    {
        try {
            $this->error = false;
            $this->errorResponse = null;
            $response = $this->client->request($method, $endpoint, $options);
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->error = true;
            $this->errorResponse = json_decode(
                $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : '',
                true
            );
            Log::error('MaxBot API Request Failed', [
                'method' => $method,
                'endpoint' => $endpoint,
                'options' => $options,
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null
            ]);
            throw new MaxBotException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function hasError(): bool
    {
        return $this->error;
    }

    public function getErrorResponse(): ?array
    {
        return $this->errorResponse;
    }


    public function get(string $endpoint, array $data = [])
    {
        return $this->request('GET', $endpoint, $data);
    }

    public function post(string $endpoint, array $data = [])
    {
        return $this->request('POST', $endpoint, $data);
    }

    public function put(string $endpoint, array $data = [])
    {
        return $this->request('PUT', $endpoint, $data);
    }

    public function patch(string $endpoint, array $data = [])
    {
        return $this->request('PATCH', $endpoint, $data);
    }

    public function delete(string $endpoint, array $data = [])
    {
        return $this->request('DELETE', $endpoint, $data);
    }
}
