<?php

namespace Maxkhim\MaxMessengerApiClient\Bot;

use Maxkhim\MaxMessengerApiClient\Bot\Commands\CommandInterface;
use Maxkhim\MaxMessengerApiClient\Bot\Dialogs\DialogInterface;

class BotService
{
    private CommandManager $commandManager;
    private array $activeDialogs = [];

    public function __construct(CommandManager $commandManager)
    {
        $this->commandManager = $commandManager;
    }

    public function handleMessage(string $userId, string $message): string
    {
        // Проверка на активный диалог
        if (isset($this->activeDialogs[$userId])) {
            return $this->continueDialog($userId, $message);
        }

        // Обработка команды
        if (str_starts_with($message, '/')) {
            return $this->handleCommand($userId, $message);
        }

        return 'Используйте команды, начинающиеся с / (например, /help)';
    }

    private function handleCommand(string $userId, string $message): string
    {
        $parts = explode(' ', trim($message));
        $commandName = substr($parts[0], 1); // Убираем '/'
        $params = array_slice($parts, 1);

        // Проверка на пустое имя команды
        if ($commandName === '') {
            return 'Не указана команда. Используйте /help для списка команд.';
        }

        $command = $this->commandManager->getCommand($commandName);

        if (!$command) {
            return "Неизвестная команда: /{$commandName}. Используйте /help для списка команд.";
        }

        if ($command->shouldStartDialog()) {
            return $this->startDialog($userId, $command);
        }

        return $command->execute($params) ?? 'Команда выполнена.';
    }

    private function startDialog(string $userId, CommandInterface $command): string
    {
        $dialogClass = $command->getDialogClass();

        if (!$dialogClass) {
            return 'Ошибка: команда не поддерживает диалог.';
        }

        // Проверка существования класса
        if (!class_exists($dialogClass)) {
            throw new \InvalidArgumentException("Класс диалога '{$dialogClass}' не найден.");
        }

        // Проверка реализации интерфейса
        $dialog = new $dialogClass();
        if (!$dialog instanceof DialogInterface) {
            throw new \InvalidArgumentException(
                "Класс '{$dialogClass}' должен реализовывать " . DialogInterface::class
            );
        }

        $this->activeDialogs[$userId] = $dialog;

        return $dialog->start($userId) ?? 'Начало диалога.';
    }

    private function continueDialog(string $userId, string $input): string
    {
        $dialog = $this->activeDialogs[$userId];

        try {
            $result = $dialog->handleInput($userId, $input);

            // Диалог завершён — очищаем состояние
            if ($result === null || $result === '' || str_contains($result, '[DIALOG_END]')) {
                unset($this->activeDialogs[$userId]);
                return trim(str_replace('[DIALOG_END]', '', $result ?? ''));
            }

            return $result;
        } catch (\Throwable $e) {
            unset($this->activeDialogs[$userId]);
            return 'Произошла ошибка при обработке диалога. Диалог завершён.';
        }
    }
}
