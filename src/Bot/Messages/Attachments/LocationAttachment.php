<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;

class LocationAttachment implements AttachmentInterface
{
    /** @var float */
    private float $latitude;

    /** @var float */
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function toArray(): array
    {
        return [
            'type' => 'location',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
