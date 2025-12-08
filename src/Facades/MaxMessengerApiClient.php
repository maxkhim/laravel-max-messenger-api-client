<?php

namespace Maxkhim\MaxMessengerApiClient\Facades;

use Illuminate\Support\Facades\Facade;
use Maxkhim\MaxMessengerApiClient\Clients\MaxMessengerClient;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Bots;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Chats;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Messages;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Subscriptions;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Updates;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Upload;

/**
 * @method static Bots bots()
 * @method static Chats chats()
 * @method static Messages messages()
 * @method static Updates updates()
 * @method static Subscriptions subscriptions()
 * @method static Upload upload()
 * @method static mixed getChats(int $count = 50, ?int $marker = null)
 * @method static mixed getChat(int $chatId)
 * @method static mixed sendMessage(array $data, ?int $userId = null, ?int $chatId = null, bool $disableLinkPreview = false)
 * @method static mixed getMessages(?int $chatId = null, ?array $messageIds = null, ?int $from = null, ?int $to = null, int $count = 50)
 *
 * @see MaxMessengerClient
 */
class MaxMessengerApiClient extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'max-messenger-api-client';
    }
}
