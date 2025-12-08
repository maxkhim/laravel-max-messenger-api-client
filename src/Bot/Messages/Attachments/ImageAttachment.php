<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class ImageAttachment implements AttachmentInterface
{
    private string $url;

    private ?string $token;

    public function __construct(?string $url = null, ?string $token = null)
    {
        if (!$url && !$token) {
            throw new \InvalidArgumentException('Либо $url либо $token должны быть указаны');
        }
        $this->url = $url;
        $this->token = $token;
    }

    public function toArray(): array
    {
        $payload = [];
        if ($this->url) {
            $payload['url'] = $this->url;
        }
        if ($this->token) {
            $payload['token'] = $this->token;
        }

        return [
            'type' => 'image',
            'payload' => $payload,
        ];
    }
}
