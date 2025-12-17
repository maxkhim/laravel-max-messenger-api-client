<?php

namespace Maxkhim\MaxMessengerApiClient\Services\Bot;

use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\CommandInterface;
use Maxkhim\MaxMessengerApiClient\Bot\Dialogs\AbstractDialog;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class BotService
{
    private CommandManager $commandManager;
    private array $activeDialogs = [];

    public function __construct(CommandManager $commandManager)
    {
        $this->commandManager = $commandManager;
    }

    public function handleMessage(string $userId, string $chatId, string $message): void
    {
        if (config("max-messenger-client.is_test_mode")) {
            MaxMessengerApiClient::messages()
                ->sendMessage(
                    Message::message(
                        '🧪  Чат-бот находится в режиме пробной эксплуатации - возможны задержки при ответах. ' .
                        'Все сообщения логируются для улучшения сервиса. Спасибо за терпение!'
                    ),
                    $userId,
                    $chatId
                );
        }

        // Проверка на активный диалог
        if (isset($this->activeDialogs[$userId])) {
            $this->continueDialog($userId, $chatId, $message);
            return;
        }

        // Обработка команды
        if (str_starts_with($message, '/')) {
            $this->handleCommand($userId, $chatId, $message);
            return;
        }

        MaxMessengerApiClient::messages()
            ->sendMessage(
                Message::message('Используйте команды, начинающиеся с / (например, /help)'),
                $userId,
                $chatId
            );

        return;
    }

    private function handleCommand(string $userId, string $chatId, string $message): string
    {
        $parts = explode(' ', trim($message));
        $commandName = strtolower(substr($parts[0], 1)); // Убираем '/'
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
            return $this->startDialog($userId, $chatId, $command);
        }

        $message = $command->execute($userId, $chatId, $params);
        return $message ?? 'Команда выполнена.';
    }

    private function startDialog(string $userId, string $chatId, CommandInterface $command): string
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
        if (!$dialog instanceof AbstractDialog) {
            throw new \InvalidArgumentException(
                "Класс '{$dialogClass}' должен реализовывать " . AbstractDialog::class
            );
        }

        $this->activeDialogs[$userId] = $dialog;

        return $dialog->start($userId, $chatId) ?? 'Начало диалога.';
    }

    private function continueDialog(string $userId, string $chatId, string $input): string
    {
        $dialog = $this->activeDialogs[$userId];

        try {
            $result = $dialog->handleInput($userId, $chatId, $input);

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
