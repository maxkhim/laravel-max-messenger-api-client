<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;

class HelpCommand implements CommandInterface
{
    protected CommandManager $commandManager;

    public function __construct(CommandManager $commandManager)
    {
        $this->commandManager = $commandManager;
    }

    public function execute(array $params): ?string
    {
        $availableCommands = $this->commandManager->getAvailableCommands();

        if (empty($availableCommands)) {
            return "Нет доступных команд";
        }

        $response = "📋 Доступные команды:\n\n";

        foreach ($availableCommands as $command) {
            $commandInstance = $this->commandManager->getCommand($command);

            if ($commandInstance) {
                $icon = $commandInstance->shouldStartDialog() ? "💬" : "⚡";
                $response .= "{$icon} /{$command}";

                $response .= " - " . $commandInstance->getDescription();

                $response .= "\n";
            }
        }

        $response .= "\nДля использования команды введите /имя_команды";

        return $response;
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
        return "Показать список всех доступных команд";
    }
}
