<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class ShareAttachment implements AttachmentInterface
{
    private ?string $url;
    private ?string $token;
    private ?string $title;
    private ?string $description;
    private ?string $imageUrl;

    public function __construct(
        ?string $url = null,
        ?string $token = null,
        ?string $title = null,
        ?string $description = null,
        ?string $imageUrl = null
    ) {
        if (!$url && !$token) {
            throw new \InvalidArgumentException('Либо $url либо $token должны быть указаны.');
        }
        $this->url = $url;
        $this->token = $token;
        $this->title = $title;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
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

        $data = [
            'type' => 'share',
            'payload' => $payload,
        ];

        if ($this->title) {
            $data['title'] = $this->title;
        }

        if ($this->description) {
            $data['description'] = $this->description;
        }

        if ($this->imageUrl) {
            $data['image_url'] = $this->imageUrl;
        }

        return $data;
    }
}
