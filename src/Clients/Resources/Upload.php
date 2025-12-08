<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Resources;

use Illuminate\Support\Facades\Http;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\FileAttachment;
use Maxkhim\MaxMessengerApiClient\Clients\Requests\MaxBotRequest;
use Maxkhim\MaxMessengerApiClient\Clients\Requests\ResourceRequest;

class Upload extends ResourceRequest
{
    public const UPLOAD_TYPE_IMAGE = 'image';
    public const UPLOAD_TYPE_VIDEO = 'video';
    public const UPLOAD_TYPE_AUDIO = 'audio';
    public const UPLOAD_TYPE_FILE = 'file';


    // Дополнительно можно добавить метод для получения всех типов
    public static function getTypes(): array
    {
        return [
            self::UPLOAD_TYPE_IMAGE,
            self::UPLOAD_TYPE_VIDEO,
            self::UPLOAD_TYPE_AUDIO,
            self::UPLOAD_TYPE_FILE,
        ];
    }

    public function getUploadUrl(string $type): ?string
    {
        $response = $this
            ->getRequest()
            ->post('/uploads', ["query" => ["type" => $type]]);
        return $response["url"] ?? null;
    }

    public function uploadFileToUrl(
        $url,
        $file,
        string $fileName = null
    ): array {
        return Http::asMultipart()
            ->attach('data', file_get_contents($file), $fileName ?? basename($file))
            ->post($url)
            ->json();
    }
}
