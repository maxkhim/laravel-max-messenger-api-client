<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;

class RequestGeoLocationButton extends AbstractButton
{
    private bool $quick;

    public function __construct(string $text, ?bool $quick = false)
    {
        parent::__construct('request_geo_location', $text);
        $this->quick = $quick ?? false;
    }

    public function isQuick(): bool
    {
        return $this->quick;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['quick'] = $this->quick;
        return $data;
    }
}
