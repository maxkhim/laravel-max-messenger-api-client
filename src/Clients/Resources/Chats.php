<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Resources;

use Maxkhim\MaxMessengerApiClient\Clients\Requests\MaxBotRequest;
use Maxkhim\MaxMessengerApiClient\Clients\Requests\ResourceRequest;

class Chats extends ResourceRequest
{
    public const TYPING_ON = 'typing_on';
    public const SENDING_PHOTO = 'sending_photo';
    public const SENDING_VIDEO = 'sending_video';
    public const SENDING_AUDIO = 'sending_audio';
    public const SENDING_FILE = 'sending_file';
    public const MARK_SEEN = 'mark_seen';

    public const ALL_ACTIONS = [
        Chats::TYPING_ON,
        Chats::SENDING_PHOTO,
        Chats::SENDING_VIDEO,
        Chats::SENDING_AUDIO,
        Chats::SENDING_FILE,
        Chats::MARK_SEEN,
    ];

    public const CHAT_STATUS_ACTIVE = 'active';
    public const CHAT_STATUS_REMOVED = 'removed';
    public const CHAT_STATUS_LEFT = 'left';
    public const CHAT_STATUS_CLOSED = 'closed';

    public function getChats(int $count = 50, ?int $marker = null)
    {
        return $this->getRequest()->get('/chats', ["query" => [
            'count' => $count,
            'marker' => $marker,
        ]]);
    }

    public function getChat(int $chatId)
    {
        return $this->getRequest()->get("/chats/{$chatId}");
    }

    public function getChatByLink(string $chatLink)
    {
        return $this->getRequest()->get("/chats/{$chatLink}");
    }

    public function editChat(int $chatId, array $data)
    {
        return $this->getRequest()->patch("/chats/{$chatId}", $data);
    }

    public function deleteChat(int $chatId)
    {
        return $this->getRequest()->delete("/chats/{$chatId}");
    }

    public function sendAction(int $chatId, string $action)
    {
        return $this->getRequest()->post("/chats/{$chatId}/actions", [ "json" => ['action' => $action]]);
    }

    public function getMembers(int $chatId, array $userIds = [], ?int $marker = null, int $count = 20)
    {
        return $this->getRequest()->get("/chats/{$chatId}/members", ["query" => [
            'user_ids' => $userIds ? implode(',', $userIds) : null,
            'marker' => $marker,
            'count' => $count,
        ]]);
    }

    public function addMembers(int $chatId, array $userIds)
    {
        return $this->getRequest()->post("/chats/{$chatId}/members", ["json" => ['user_ids' => $userIds]]);
    }

    public function removeMember(int $chatId, int $userId, bool $block = false)
    {
        return $this->getRequest()->delete("/chats/{$chatId}/members", ["query" => [
            'user_id' => $userId,
            'block' => $block,
        ]]);
    }

    public function getAdmins(int $chatId)
    {
        return $this->getRequest()->get("/chats/{$chatId}/members/admins");
    }

    public function setAdmins(int $chatId, array $admins)
    {
        return $this->getRequest()->post("/chats/{$chatId}/members/admins", ['admins' => $admins]);
    }

    public function removeAdmin(int $chatId, int $userId)
    {
        return $this->getRequest()->delete("/chats/{$chatId}/members/admins/{$userId}");
    }

    public function getPinnedMessage(int $chatId)
    {
        return $this->getRequest()->get("/chats/{$chatId}/pin");
    }

    public function pinMessage(int $chatId, string $messageId, bool $notify = true)
    {
        return $this->getRequest()->put("/chats/{$chatId}/pin", [
            'message_id' => $messageId,
            'notify' => $notify,
        ]);
    }

    public function unpinMessage(int $chatId)
    {
        return $this->getRequest()->delete("/chats/{$chatId}/pin");
    }

    public function leaveChat(int $chatId)
    {
        return $this->getRequest()->delete("/chats/{$chatId}/members/me");
    }

    public function getMembership(int $chatId)
    {
        return $this->getRequest()->get("/chats/{$chatId}/members/me");
    }
}