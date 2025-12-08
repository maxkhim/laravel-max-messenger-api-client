<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Attachment;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class DashboardCommand implements CommandInterface
{
    public function execute(array $params): ?string
    {
        $chatId = $params[0] ?? null;
        $buttonsAttachment = Attachment::inlineKeyboard([
            [
                Button::callbackButton("Студенты", "/dashboard_stud"),
                Button::callbackButton("Кадры", "/dashboard_kadr"),
                Button::callbackButton("Финансы", "/dashboard_fin"),
            ],
        ]);

        $messageList = Message::message("Выберите панель")
            ->addAttachment($buttonsAttachment);
        MaxMessengerApiClient::messages()
            ->sendMessage($messageList->toArray(), null, $chatId);

        return "Экран меню";
    }

    public function shouldStartDialog(): bool
    {
        return false;
    }

    public function getDialogClass(): ?string
    {
        return null;
    }

    // Опционально: метод для получения описания команды
    public function getDescription(): string
    {
        return "Панель управления: меню";
    }
}
