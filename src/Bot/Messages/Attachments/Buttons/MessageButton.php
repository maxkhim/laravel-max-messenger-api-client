<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;

class MessageButton extends AbstractButton
{
    public function __construct(
        string $text
    ) {
        parent::__construct('message', $text);
    }
}
