<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class AudioAttachment implements AttachmentInterface
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function toArray(): array
    {
        return [
            'type' => 'audio',
            'payload' => [
                'token' => $this->token,
            ],
        ];
    }
}
