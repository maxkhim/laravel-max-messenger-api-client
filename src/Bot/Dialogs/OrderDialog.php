<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Dialogs;

use Maxkhim\MaxMessengerApiClient\Bot\Dialogs\AbstractDialog;

class OrderDialog extends AbstractDialog
{
    public function __construct()
    {
        $this->steps = [
            ['question' => 'Введите название товара:'],
            ['question' => 'Введите количество:'],
            ['question' => 'Введите ваш комментарий:']
        ];
    }

    public function start(string $userId): string
    {
        $this->currentStep = 0;
        return $this->steps[0]['question'];
    }

    protected function finalize(string $userId): string
    {
        // Обработка собранных данных
        $product = $this->userData[0];
        $quantity = $this->userData[1];
        $comment = $this->userData[2];

        // Сохранение заказа и т.д.

        return "Заказ создан! Товар: $product, Количество: $quantity [DIALOG_END]";
    }
}
