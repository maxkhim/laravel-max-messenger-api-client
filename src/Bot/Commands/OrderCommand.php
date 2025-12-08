<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\Dialogs\OrderDialog;

class OrderCommand implements CommandInterface
{
    public function execute(array $params): ?string
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
        return "Сделать заказ товара";
    }
}
