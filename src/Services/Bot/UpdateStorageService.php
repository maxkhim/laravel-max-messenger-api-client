<?php

namespace Maxkhim\MaxMessengerApiClient\Services\Bot;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Maxkhim\MaxMessengerApiClient\Models\Update;
use Illuminate\Support\Facades\DB;
use Maxkhim\MaxMessengerApiClient\Clients\Resources\Updates;

class UpdateStorageService
{
    public function storeUpdate(array $updateData): ?Update
    {
        return DB::transaction(function () use ($updateData) {
            // Сохраняем основное обновление
            $hashUpdateData = $updateData;
            unset($hashUpdateData['timestamp']);
            $updateHash = sha1(json_encode($hashUpdateData)) ?? uniqid("_", true);

            $updateId = sha1(json_encode($updateData)) ?? uniqid("_", true);

            $updateDuplicate = $this->getDuplicatedUpdate($updateHash, $updateData['timestamp']);

            $updateData['event_at'] = Carbon::createFromTimestampMs(
                $updateData['timestamp'],
                config("app.timezone")
            );

            $update = Update::query()
                ->createOrFirst(
                    [
                        'update_id' => $updateId
                    ],
                    [
                        'update_id' => $updateId,
                        'update_type' => $updateData['update_type'],
                        'timestamp' => $updateData['timestamp'],
                        'chat_id' => $this->extractChatId($updateData),
                        'user_id' => $this->extractUserId($updateData),
                        'raw_data' => $updateData,
                        'event_at' => $updateData['event_at'],
                        'update_hash' => $updateHash,
                        'process_status' =>
                            $updateDuplicate ? Update::PROCESS_STATUS_DUPLICATED : Update::PROCESS_STATUS_PENDING,
                    ]
                );

            // Сохраняем данные в зависимости от типа
            switch ($updateData['update_type']) {
                case Updates::MESSAGE_CREATED:
                case Updates::MESSAGE_EDITED:
                    //$this->storeMessage($update, $updateData);
                    break;

                case Updates::MESSAGE_CALLBACK:
                    //$this->storeCallback($update, $updateData);
                    break;

                case Updates::BOT_ADDED:
                case Updates::BOT_REMOVED:
                case Updates::USER_ADDED:
                case Updates::USER_REMOVED:
                case Updates::CHAT_TITLE_CHANGED:
                    //$this->storeChatEvent($update, $updateData);
                    break;

                case Updates::BOT_STARTED:
                    //$this->storeBotEvent($update, $updateData);
                    break;

                case Updates::MESSAGE_CHAT_CREATED:
                    //$this->storeChatCreation($update, $updateData);
                    break;

                    // Опционально: default для отладки
                    // default:
                    //     \Log::warning('Неизвестный тип обновления', ['type' => $updateData['update_type']]);
            }
            // Сохраняем пользователей и чаты в кеш
            //$this->cacheUsersAndChats($updateData);

            return $update;
        });
    }

    private function getDuplicatedUpdate(string $hashUpdate, $timestamp): ?Update
    {

        $cacheKey = "max_webhook_update_$hashUpdate";


        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        /** @var Update $update */
        $updateQ = Update::query()
            ->where('update_hash', $hashUpdate)
            ->whereBetween('timestamp', [
                Carbon::createFromTimestampMs(
                    $timestamp,
                    config("app.timezone")
                )
                    ->subMinutes(5)
                    ->getTimestampMs(),
                $timestamp
            ]);

        $update = $updateQ
            ->first();

        Cache::put($cacheKey, $update, now()->addMinutes(5));

        return $update;
    }
    protected function storeMessage(Update $update, array $data): void
    {
        $messageData = $data['message'] ?? [];

        /*Message::create([
            'update_id' => $update->id,
            'message_id' => $messageData['body']['mid'] ?? null,
            'seq' => $messageData['body']['seq'] ?? null,
            'text' => $messageData['body']['text'] ?? null,
            'attachments' => $messageData['body']['attachments'] ?? null,
            'sender_id' => $messageData['sender']['user_id'] ?? null,
            'chat_id' => $messageData['recipient']['chat_id'] ?? null,
            'timestamp' => $messageData['timestamp'] ?? null,
            'format' => $messageData['body']['format'] ?? null,
            'link' => $messageData['link'] ?? null,
            'stat' => $messageData['stat'] ?? null,
            'url' => $messageData['url'] ?? null,
        ]);*/
    }

    /*protected function storeCallback(Update $update, array $data): void
    {
        Callback::create([
            'update_id' => $update->id,
            'callback_id' => $data['callback']['callback_id'] ?? null,
            'payload' => $data['callback']['payload'] ?? null,
            'user_id' => $data['callback']['user']['user_id'] ?? null,
            'message_id' => $data['message']['body']['mid'] ?? null,
            'chat_id' => $data['message']['recipient']['chat_id'] ?? null,
            'user_locale' => $data['user_locale'] ?? null,
        ]);
    }

    protected function cacheUsersAndChats(array $data): void
    {
        // Кешируем пользователей из различных частей обновления
        $this->cacheUser($data['user'] ?? null);
        $this->cacheUser($data['callback']['user'] ?? null);
        $this->cacheUser($data['message']['sender'] ?? null);

        // Кешируем чаты
        if (isset($data['chat'])) {
            $this->cacheChat($data['chat']);
        }
    }

    protected function cacheUser(?array $userData): void
    {
        if (!$userData || !isset($userData['user_id'])) {
            return;
        }

        User::updateOrCreate(
            ['user_id' => $userData['user_id']],
            [
                'first_name' => $userData['first_name'] ?? $userData['name'] ?? null,
                'last_name' => $userData['last_name'] ?? null,
                'username' => $userData['username'] ?? null,
                'is_bot' => $userData['is_bot'] ?? false,
                'last_activity_time' => $userData['last_activity_time'] ?? null,
            ]
        );
    }

    protected function cacheChat(array $chatData): void
    {
        Chat::updateOrCreate(
            ['chat_id' => $chatData['chat_id']],
            [
                'type' => $chatData['type'],
                'status' => $chatData['status'],
                'title' => $chatData['title'],
                'description' => $chatData['description'],
                'last_event_time' => $chatData['last_event_time'],
                'participants_count' => $chatData['participants_count'],
                'owner_id' => $chatData['owner_id'] ?? null,
                'is_public' => $chatData['is_public'],
                'link' => $chatData['link'] ?? null,
            ]
        );
    }*/

    protected function extractChatId(array $data): ?int
    {
        return $data['chat_id']
            ?? $data['message']['recipient']['chat_id']
            ?? $data['chat']['chat_id']
            ?? null;
    }

    protected function extractUserId(array $data): ?int
    {
        return $data['user']['user_id']
            ?? $data['callback']['user']['user_id']
            ?? $data['message']['sender']['user_id']
            ?? $data['user_id']
            ?? null;
    }
}
