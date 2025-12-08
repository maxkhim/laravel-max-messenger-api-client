<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Upload;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class DirectImageAttachment implements AttachmentInterface
{
    private string $token;

    private string $pathToFile;

    private ?string $filename;

    public function __construct(string $pathToFile, ?string $filename = null)
    {
        $this->pathToFile = $pathToFile;
        $this->filename = $filename;
        $token = null;
        $url = MaxMessengerApiClient::upload()->getUploadUrl(Upload::UPLOAD_TYPE_IMAGE);
        if ($url) {
            $upload = MaxMessengerApiClient::upload()->uploadFileToUrl(
                $url,
                $this->pathToFile,
                $this->filename
            );
            $keyBatch = array_key_first($upload);
            $key = array_key_first($upload[$keyBatch]);
            $token = $upload[$keyBatch][$key]["token"] ?? null;
        }
        $this->token = $token;
    }

    public function toArray(): array
    {
        $result =  [
            'type' => Upload::UPLOAD_TYPE_IMAGE,
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
