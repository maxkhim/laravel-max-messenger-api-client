<?php

namespace Maxkhim\MaxMessengerApiClient\Providers;

use Illuminate\Support\ServiceProvider;
use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\HelpCommand;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\StartCommand;

class MaxMessengerChatBotServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CommandManager::class, fn () => new CommandManager());
    }

    public function boot(): void
    {
        /** @var CommandManager $manager */
        $manager = $this->app->make(CommandManager::class);
        // Эндпоинты для получения сообщений
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        // Регистрация базовых команд
        $manager->registerCommand('start', new StartCommand());
        $manager->registerCommand('help', new HelpCommand($manager));
    }
}
