<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Attachment;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class DashboardFinCommand implements CommandInterface
{
    public function execute(array $params): ?string
    {
        $chatId = $params[0] ?? null;
        $messageWithAttach = Message::message("Информация о финансах (" . date("H:i:s") . ")")
            ->addAttachment(
                Attachment::directImage("/home/tandem/i/f.png", "Картинка изображение f.png")
            );

        $res = MaxMessengerApiClient::messages()
            ->sendMessage(
                $messageWithAttach->toArray(),
                null,
                $chatId
            );
        return "Экран информации о финансах";
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
        return "Панель управления: Финансы";
    }
}
