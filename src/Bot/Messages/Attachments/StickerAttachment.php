<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class StickerAttachment implements AttachmentInterface
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function toArray(): array
    {
        return [
            'type' => 'sticker',
            'payload' => [
                'code' => $this->code,
            ],
        ];
    }
}
