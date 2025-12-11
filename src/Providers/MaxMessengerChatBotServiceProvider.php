<?php

namespace Maxkhim\MaxMessengerApiClient\Providers;

use Illuminate\Support\ServiceProvider;
use Maxkhim\MaxMessengerApiClient\Bot\CommandManager;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\DashboardCommand;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\DashboardFinCommand;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\DashboardKadrCommand;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\DashboardStudCommand;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\GetScheduleCommand;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\HelpCommand;
use Maxkhim\MaxMessengerApiClient\Bot\Commands\OrderSpravkaCommand;
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

        // Регистрация базовых команд
        $manager->registerCommand('start', new StartCommand());
        $manager->registerCommand('help', new HelpCommand($manager));
    }
}
