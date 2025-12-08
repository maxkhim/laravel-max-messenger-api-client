<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Links;

class ForwardLink implements LinkInterface
{
    /** @var string */
    private string $messageId;

    public function __construct(string $messageId)
    {
        if (empty(trim($messageId))) {
            throw new \InvalidArgumentException('Message ID не может быть пустым.');
        }
        $this->messageId = $messageId;
    }

    public function toArray(): array
    {
        return [
            'type' => 'forward',
            'mid' => $this->messageId,
        ];
    }

    public function getMessageId(): string
    {
        return $this->messageId;
    }

    public function setMessageId(string $messageId): self
    {
        if (empty(trim($messageId))) {
            throw new \InvalidArgumentException('Message ID не может быть пустым.');
        }
        $this->messageId = $messageId;
        return $this;
    }
}
