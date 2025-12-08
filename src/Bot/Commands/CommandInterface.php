<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

interface CommandInterface
{
    public function execute(array $params): ?string;
    public function shouldStartDialog(): bool;
    public function getDialogClass(): ?string;

    public function getDescription(): string;
}
