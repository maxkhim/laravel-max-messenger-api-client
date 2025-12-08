<?php

namespace Maxkhim\MaxMessengerApiClient\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Maxkhim\MaxMessengerApiClient\Clients\MaxMessengerClient;
use Maxkhim\MaxMessengerApiClient\Commands\CheckMaxBotClient;
use Maxkhim\MaxMessengerApiClient\Commands\CheckMaxMessengerClient;

class MaxMessengerApiServiceProvider extends ServiceProvider
{
    public static function getMigrationPath(): string
    {
        return __DIR__ . '/../../database/migrations';
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadMigrationsFrom(self::getMigrationPath());
        $this->mergeConfigFrom(__DIR__ . '/../../config/max-messenger-client.php', 'max-messenger-client');
        $this->app->singleton('max-messenger-api-client', MaxMessengerClient::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Exception
     */
    public function boot()
    {
        if (App::runningInConsole()) {
            $this->registerCommands();
            $this->app->booted(function () {
            });
        }
    }

    /**
     * Регистрация консольных команд
     */
    private function registerCommands()
    {
        $this->commands([
            CheckMaxMessengerClient::class,
        ]);
    }
}
