<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Dialogs;

use Illuminate\Support\Str;
use Maxkhim\MaxMessengerApiClient\Bot\Dialogs\AbstractDialog;
use Maxkhim\MaxMessengerApiClient\Models\BotConversation;

class OrderDialog extends AbstractDialog
{
    protected ?BotConversation $currentDialog = null;
    public function __construct()
    {
        $this->steps = [
            ['question' => 'Введите название товара:'],
            ['question' => 'Введите количество:'],
            ['question' => 'Введите ваш комментарий:']
        ];
    }



    public function start(string $userId, string $chatId): string
    {
        $currentDialog = $this->getCurrentConversation($userId, $chatId);

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

        $this->currentDialog->is_active = false;
        $this->currentDialog->metadata = [
            "product" => $product,
            "quantity" => $quantity,
            "comment" => $comment
        ];
        $this->currentDialog->save();

        return "Заказ создан! Товар: $product, Количество: $quantity [DIALOG_END]";
    }
}
