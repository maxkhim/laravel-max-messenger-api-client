<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;

class CallbackButton extends AbstractButton
{
    /** @var string */
    private string $payload;

    /** @var string|null */
    private string $intent;


    public const INTENT_POSITIVE = "positive";
    public const INTENT_NEGATIVE = "negative";
    public const INTENT_DEFAULT = "default";

    public function __construct(string $text, string $payload, ?string $intent = CallbackButton::INTENT_DEFAULT)
    {
        parent::__construct('callback', $text);
        $this->payload = $payload;
        $this->intent = $intent === null ? CallbackButton::INTENT_DEFAULT : $intent;
    }

    public function getPayload(): string
    {
        return $this->payload;
    }

    public function getIntent(): ?string
    {
        return $this->intent;
    }

    public function toArray(): array
    {
        $data = parent::toArray();
        $data['payload'] = $this->payload;
        if ($this->intent) {
            $data['intent'] = $this->intent;
        }
        return $data;
    }
}
