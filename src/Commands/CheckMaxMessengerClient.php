<?php

namespace Maxkhim\MaxMessengerApiClient\Commands;

use Illuminate\Console\Command;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class CheckMaxMessengerClient extends Command
{
    protected $signature = 'max-messenger-client:check';
    protected $description = 'Проверка настройки клиента';

    protected function getTestChatId()
    {
        return (int)env("TEST_CHAT_ID");
    }
    public function handle()
    {

        $this->info("Пробуем выполнить минимальный запрос к REST Api");
        dump(MaxMessengerApiClient::bots()->getMyInfo());
    }
}
