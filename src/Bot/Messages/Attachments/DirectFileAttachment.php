<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Upload;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class DirectFileAttachment implements AttachmentInterface
{
    private string $token;

    private string $pathToFile;

    private ?string $filename;

    public function __construct(string $pathToFile, ?string $filename = null)
    {
        $this->pathToFile = $pathToFile;
        $this->filename = $filename;
        $token = null;
        $url = MaxMessengerApiClient::upload()->getUploadUrl(Upload::UPLOAD_TYPE_FILE);
        if ($url) {
            $upload = MaxMessengerApiClient::upload()->uploadFileToUrl(
                $url,
                $this->pathToFile,
                $this->filename
            );
            $token = $upload["token"] ?? null;
        }
        $this->token = $token;
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
