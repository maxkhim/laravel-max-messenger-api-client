<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;

class ChatButton extends AbstractButton
{
    private string $chatTitle;
    private ?string $chatDescription;
    private ?string $startPayload;
    private ?int $uuid;

    public function __construct(
        string $text,
        string $chatTitle,
        ?string $chatDescription = null,
        ?string $startPayload = null,
        ?int $uuid = null
    ) {
        parent::__construct('chat', $text);
        $this->chatTitle = $chatTitle;
        $this->chatDescription = $chatDescription;
        $this->startPayload = $startPayload;
        $this->uuid = $uuid;
    }

    public function getChatTitle(): string
    {
        return $this->chatTitle;
    }

    public function getChatDescription(): ?string
    {
        return $this->chatDescription;
    }

    public function getStartPayload(): ?string
    {
        return $this->startPayload;
    }

    public function getUuid(): ?int
    {
        return $this->uuid;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['chat_title'] = $this->chatTitle;

        if ($this->chatDescription !== null) {
            $data['chat_description'] = $this->chatDescription;
        }
        if ($this->startPayload !== null) {
            $data['start_payload'] = $this->startPayload;
        }
        if ($this->uuid !== null) {
            $data['uuid'] = $this->uuid;
        }

        return $data;
    }
}
