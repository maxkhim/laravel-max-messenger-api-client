<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class VideoAttachment implements AttachmentInterface
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
            'type' => 'video',
            'payload' => [
                'token' => $this->token,
            ],
        ];
    }
}
