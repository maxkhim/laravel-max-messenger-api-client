<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Upload;

class FileAttachment implements AttachmentInterface
{
    private string $token;

    private ?string $filename;

    public function __construct(string $token, ?string $filename = null)
    {
        $this->token = $token;
        $this->filename = $filename;
    }

    public function toArray(): array
    {
        $result =  [
            'type' => Upload::UPLOAD_TYPE_FILE,
            'payload' => [
                'token' => $this->token,
            ]
        ];

        if ($this->filename) {
            $result['filename'] = $this->filename;
        }

        return $result;
    }
}
