<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Commands;

use Illuminate\Support\Str;
use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Models\BotConversation;

abstract class AbstractCommand implements CommandInterface
{
    protected ?BotConversation $currentDialog = null;

    private function getCurrentConversation(string $userId, string $chatId): BotConversation
    {
        if (!$this->currentDialog) {
            $currentDialog = new BotConversation(
                [
                    "user_id" => $userId,
                    "chat_id" => $chatId,
                    "class" => get_class($this),
                    "is_active" => false,
                    "current_dialog_key" => Str::uuid()
                ]
            );
            $currentDialog->save();
            $this->currentDialog = $currentDialog;
        }
        return $this->currentDialog;
    }

    public function execute(string $userId, string $chatId, array $params): ?string
    {
        $this->currentDialog = $this->getCurrentConversation($userId, $chatId);
        return null;
    }

    public function shouldStartDialog(): bool
    {
        return false;
    }

    public function getDialogClass(): ?string
    {
        return null;
    }

    public function displayInHelp(): bool
    {
        return false;
    }
}
