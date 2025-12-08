<?php

namespace Maxkhim\MaxMessengerApiClient\Bot;

use Maxkhim\MaxMessengerApiClient\Bot\Commands\CommandInterface;

class CommandManager
{
    protected array $commands = [];

    public function registerCommand(string $name, CommandInterface $command): void
    {
        $this->commands[$name] = $command;
    }

    public function getCommand(string $name): ?CommandInterface
    {
        return $this->commands[$name] ?? null;
    }

    public function getAvailableCommands(): array
    {
        return array_keys($this->commands);
    }
}
