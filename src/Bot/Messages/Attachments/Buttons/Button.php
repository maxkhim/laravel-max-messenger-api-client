<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

class Button
{
    public static function callbackButton(string $text, string $payload, string $intent = 'default'): CallbackButton
    {
        return new CallbackButton($text, $payload, $intent);
    }

    public static function linkButton(string $text, string $url): LinkButton
    {
        return new LinkButton($text, $url);
    }

    public static function requestContactButton(string $text): RequestContactButton
    {
        return new RequestContactButton($text);
    }

    public static function requestLocationButton(string $text, bool $quick = false): RequestGeoLocationButton
    {
        return new RequestGeoLocationButton($text, $quick);
    }

    public static function messageButton(string $text): MessageButton
    {
        return new MessageButton($text);
    }


    public static function openAppButton(string $text, string $webApp): OpenAppButton
    {
        return new OpenAppButton($text, $webApp);
    }

}
