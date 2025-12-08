<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Attachment;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class DashboardKadrCommand implements CommandInterface
{
    public function execute(array $params): ?string
    {
        $chatId = $params[0] ?? null;
        $messageWithAttach = Message::message("Информация о кадрах (" . date("H:i:s") . ")")
            ->addAttachment(
                Attachment::directImage("/home/tandem/i/k.png", "Картинка изображение k.png")
            );

        $res = MaxMessengerApiClient::messages()
            ->sendMessage(
                $messageWithAttach->toArray(),
                null,
                $chatId
            );
        return "Экран информации о кадрах";
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
        return "Панель управления: Кадры";
    }
}
