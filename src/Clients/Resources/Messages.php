<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Resources;

use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Clients\Requests\MaxBotRequest;
use Maxkhim\MaxMessengerApiClient\Clients\Requests\ResourceRequest;

class Messages extends ResourceRequest
{
    public function sendMessage(array $data, ?int $userId = null, ?int $chatId = null, bool $disableLinkPreview = false)
    {
        $submitData["json"] = $data;
        $submitData["query"] = [
            "chat_id" => $chatId,
            "disable_link_preview" => $disableLinkPreview,
            "user_id" => $userId
        ];
        return $this->getRequest()->post('/messages', $submitData);
    }

    public function getMessages(
        ?int $chatId = null,
        ?array $messageIds = null,
        ?int $from = null,
        ?int $to = null,
        int $count = 50
    ) {
        return $this->getRequest()->get('/messages', ["query" => [
            'chat_id' => $chatId,
            'message_ids' => $messageIds ? implode(',', $messageIds) : null,
            'from' => $from,
            'to' => $to,
            'count' => $count,
        ]]);
    }

    public function getMessageById(string $messageId)
    {
        return $this->getRequest()->get("/messages/{$messageId}");
    }

    public function editMessage(
        string $messageId,
        Message $message
    ) {
        $data = $message->toArray();
        $submitData["query"] = [
            "message_id" => $messageId
        ];
        $submitData["json"] = $data;
        return $this->getRequest()->put("/messages", $submitData);
    }

    public function deleteMessage(string $messageId)
    {
        return $this->getRequest()->delete('/messages', ["query" => ['message_id' => $messageId]]);
    }

    public function answerCallback(string $callbackId, array $data)
    {
        $requestData = [
            "query" => [
                "callback_id" => $callbackId,
            ],
            "json" => $data,
        ];
        return $this->getRequest()->post('/answers', $requestData);
    }

    public function getVideoAttachmentDetails(string $videoToken)
    {
        return $this->getRequest()->get("/videos/{$videoToken}");
    }
}
