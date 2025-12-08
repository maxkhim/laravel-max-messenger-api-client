<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

class StartCommand implements CommandInterface
{
    public function execute(array $params): ?string
    {
        return "Добро пожаловать! Используйте /help для списка команд";
    }

    public function shouldStartDialog(): bool
    {
        return false;
    }

    public function getDialogClass(): ?string
    {
        return null;
    }

    public function getDescription(): string
    {
        return "Начать работу с ботом";
    }
}
