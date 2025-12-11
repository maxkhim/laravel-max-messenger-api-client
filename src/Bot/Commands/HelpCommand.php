<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Attachment;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Attachments\Buttons\Button;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class HelpCommand extends AbstractCommand implements CommandInterface
{
    protected CommandManager $commandManager;

    public function __construct(CommandManager $commandManager)
    {
        $this->commandManager = $commandManager;
    }

    public function execute(string $userId, string $chatId, array $params): ?string
    {
        parent::execute($userId, $chatId, $params);
        $availableCommands = $this->commandManager->getAvailableCommands();

        if (!count($availableCommands)) {
            MaxMessengerApiClient::messages()
                ->sendMessage(Message::message("Нет доступных команд"), $userId, $chatId);
            return "Нет доступных команд";
        }

        $response = "📋 Доступные команды:\n\n";

        foreach ($availableCommands as $command) {
            $commandInstance = $this->commandManager->getCommand($command);

            if ($commandInstance) {
                if ($commandInstance->displayInHelp()) {
                    $icon = $commandInstance->shouldStartDialog() ? "💬" : "⚡";
                    $response .= "{$icon} /{$command}";

                    $response .= " - " . $commandInstance->getDescription();

                    $response .= "\n";
                }
            }
        }

        $response .= "\nДля использования команды введите /имя_команды";

        MaxMessengerApiClient::messages()
            ->sendMessage(
                Message::message($response)
                ->addAttachment(Attachment::inlineKeyboard([[
                    Button::linkButton("Канал САФУ в MAX", "https://max.ru/id2901039102_biz")
                ]])),
                $userId,
                $chatId
            );

        return "Ok";
    }

    public function displayInHelp(): bool
    {
        return true;
    }

    // Опционально: метод для получения описания команды
    public function getDescription(): string
    {
        return "Показать список всех доступных команд";
    }
}
