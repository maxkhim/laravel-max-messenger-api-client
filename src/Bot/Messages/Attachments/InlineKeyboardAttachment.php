<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments;

use Illuminate\Support\Collection;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\ButtonInterface;

class InlineKeyboardAttachment implements AttachmentInterface
{
    private Collection $buttons;

    public function __construct(Collection $buttons)
    {
        $this->buttons = $buttons;
    }

    public function getButtons(): Collection
    {
        return $this->buttons;
    }

    public function addButton(ButtonInterface $button): InlineKeyboardAttachment
    {
        if (is_null($this->buttons)) {
            $this->buttons = new Collection();
        }
        $this->buttons->push($button);
        return $this;
    }

    public function toArray(): array
    {
        return [
            'type' => 'inline_keyboard',
            'payload' => [
                'buttons' => $this->buttons->map(function ($row) {
                    return array_map(function ($button) {
                        return $button->toArray();
                    }, $row);
                })->values()->all(),
            ],
        ];
    }
}
