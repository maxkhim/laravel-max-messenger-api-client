<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;

class OpenAppButton extends AbstractButton
{
    private ?string $web_app;
    private ?int $contact_id;
    private ?string $payload;

    public function __construct(
        string $text,
        ?string $web_app = null,
        ?int $contact_id = null,
        ?string $payload = null
    ) {
        parent::__construct('open_app', $text);
        $this->web_app = $web_app;
        $this->contact_id = $contact_id;
        $this->payload = $payload;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        if ($this->web_app) {
            $data['web_app'] = $this->web_app;
        }

        if ($this->contact_id) {
            $data['contact_id'] = $this->contact_id;
        }

        if ($this->payload) {
            $data['payload'] = $this->payload;
        }

        return $data;
    }
}
