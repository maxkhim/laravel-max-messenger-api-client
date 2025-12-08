<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class Attachment
{
    public static function image(string $url): ImageAttachment
    {
        return new ImageAttachment($url);
    }

    public static function video(string $token): VideoAttachment
    {
        return new VideoAttachment($token);
    }

    public static function file(string $token, ?string $filename = null): FileAttachment
    {
        return new FileAttachment($token, $filename);
    }

    public static function directFile(string $pathToFile, ?string $filename = null): DirectFileAttachment
    {
        return new DirectFileAttachment($pathToFile, $filename);
    }

    public static function directImage(string $pathToFile, ?string $filename = null): DirectImageAttachment
    {
        return new DirectImageAttachment($pathToFile, $filename);
    }

    public static function location(float $latitude, float $longitude): LocationAttachment
    {
        return new LocationAttachment($latitude, $longitude);
    }

    public static function contact(string $name, ?int $contactId = null): ContactAttachment
    {
        return new ContactAttachment($name, $contactId);
    }

    public static function share(string $url): ShareAttachment
    {
        return new ShareAttachment($url);
    }

    public static function inlineKeyboard(array $buttons): InlineKeyboardAttachment
    {
        return new InlineKeyboardAttachment(collect($buttons));
    }

}
