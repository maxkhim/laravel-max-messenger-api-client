<?php

namespace Maxkhim\MaxMessengerApiClient\Bot\Messages\Links;

class Link
{
    /**
     * Создаёт ссылку-ответ
     *
     * @param string $messageId ID сообщения, на которое отвечаем
     * @return ReplyLink
     */
    public static function reply(string $messageId): ReplyLink
    {
        return new ReplyLink($messageId);
    }

    /**
     * Создаёт ссылку-пересылку
     *
     * @param string $messageId ID исходного сообщения
     * @return ForwardLink
     */
    public static function forward(string $messageId): ForwardLink
    {
        return new ForwardLink($messageId);
    }
}