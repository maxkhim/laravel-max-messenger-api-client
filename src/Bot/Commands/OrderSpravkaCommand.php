<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\Dialogs\OrderDialog;

class OrderSpravkaCommand extends AbstractCommand implements CommandInterface
{
    public function execute(string $userId, string $chatId, array $params): ?string
    {
        return null; // Для диалога сразу не возвращаем ответ
    }

    public function shouldStartDialog(): bool
    {
        return true;
    }

    public function getDialogClass(): ?string
    {
        return OrderDialog::class;
    }

    public function getDescription(): string
    {
        return "Заказать справку";
    }
}
