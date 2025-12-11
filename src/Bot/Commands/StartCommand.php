<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Attachment;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class StartCommand extends AbstractCommand implements CommandInterface
{
    public function execute(string $userId, string $chatId, array $params): ?string
    {
        parent::execute($userId, $chatId, $params);
        MaxMessengerApiClient::messages()
            ->sendMessage(
                Message::message("Добро пожаловать! Выберите действие")
                    ->addAttachment(
                        Attachment::inlineKeyboard([
                            [
                                Button::callbackButton("Справка", "/help"),
                            ],
                            [
                                Button::linkButton("Канал САФУ в MAX", "https://max.ru/id2901039102_biz")
                            ]
                        ])
                    ),
                $userId,
                $chatId
            );
        return null;
    }

    public function displayInHelp(): bool
    {
        return true;
    }

    public function getDescription(): string
    {
        return "Начать работу с ботом";
    }
}
