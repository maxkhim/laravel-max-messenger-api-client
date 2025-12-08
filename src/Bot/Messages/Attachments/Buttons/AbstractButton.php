<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

abstract class AbstractButton implements ButtonInterface
{
    protected string $type;

    protected string $text;

    public function __construct(string $type, string $text)
    {
        $this->type = $type;
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'text' => $this->text,
        ];
    }
}
