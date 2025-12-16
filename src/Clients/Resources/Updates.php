<?php

namespace Maxkhim\MaxMessengerApiClient\Clients\Resources;

use Maxkhim\MaxMessengerApiClient\Clients\Requests\ResourceRequest;

class Updates extends ResourceRequest
{
    public const MESSAGE_CREATED = 'message_created';
    public const MESSAGE_CALLBACK = 'message_callback';
    public const MESSAGE_EDITED = 'message_edited';
    public const MESSAGE_REMOVED = 'message_removed';
    public const BOT_ADDED = 'bot_added';
    public const BOT_REMOVED = 'bot_removed';
    public const USER_ADDED = 'user_added';
    public const USER_REMOVED = 'user_removed';
    public const BOT_STARTED = 'bot_started';
    public const CHAT_TITLE_CHANGED = 'chat_title_changed';
    public const MESSAGE_CHAT_CREATED = 'message_chat_created';


    /**
     * Возвращает все типы обновлений как массив
     *
     * @return string[]
     */
    public static function getTypes(): array
    {
        return [
            self::MESSAGE_CREATED,
            self::MESSAGE_CALLBACK,
            self::MESSAGE_EDITED,
            self::MESSAGE_REMOVED,
            self::BOT_ADDED,
            self::BOT_REMOVED,
            self::USER_ADDED,
            self::USER_REMOVED,
            self::BOT_STARTED,
            self::CHAT_TITLE_CHANGED,
            self::MESSAGE_CHAT_CREATED,
        ];
    }

    public function getUpdates(?int $limit = 100, int $timeout = 30, ?int $marker = null, ?array $types = null)
    {
        return $this->getRequest()->get('/updates', array_filter([
            'limit' => $limit,
            'timeout' => $timeout,
            'marker' => $marker,
            'types' => $types ? implode(',', $types) : null,
        ]));
    }

    public function extractPhoneNumberFromContactUpdate(array $update): ?string
    {
        // Проверяем, что это сообщение и есть вложения
        $message = $update['message'] ?? null;
        if (!$message || !isset($message['body']['attachments'])) {
            return null;
        }

        $attachments = $message['body']['attachments'];
        foreach ($attachments as $attachment) {
            if (
                isset($attachment['type']) &&
                $attachment['type'] === 'contact' &&
                isset($attachment['payload']['vcf_info'])
            ) {
                $vcf = $attachment['payload']['vcf_info'];

                // Используем регулярное выражение для поиска телефона после TEL;TYPE=cell:
                if (preg_match('/TEL;TYPE=cell:(\d+)/i', $vcf, $matches)) {
                    return $matches[1];
                }

                // Альтернатива: ищем любое TEL (без учёта подтипа)
                if (preg_match('/TEL[^:]*:(\d+)/i', $vcf, $matches)) {
                    return $matches[1];
                }
            }
        }

        return null;
    }
}