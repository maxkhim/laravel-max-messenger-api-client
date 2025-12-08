<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;

class LinkButton extends AbstractButton
{
    private string $url;

    public function __construct(string $text, string $url)
    {
        parent::__construct('link', $text);
        $this->url = $url;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['url'] = $this->url;
        return $data;
    }
}
