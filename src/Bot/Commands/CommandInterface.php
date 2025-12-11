<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;

interface CommandInterface
{
    public function execute(string $userId, string $chatId, array $params): ?string;
    public function shouldStartDialog(): bool;
    public function getDialogClass(): ?string;
    public function getDescription(): string;
    public function displayInHelp(): bool;
}
