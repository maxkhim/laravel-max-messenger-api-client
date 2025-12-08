<?php

namespace Maxkhim\MaxMessengerApiClient\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maxkhim\MaxMessengerApiClient\Bot\Messages\Message;
use Maxkhim\MaxMessengerApiClient\Exceptions\MaxBotException;
use Maxkhim\MaxMessengerApiClient\Facades\MaxMessengerApiClient;

class SentMessageRequestJob implements ShouldQueue
{
    use Queueable;

    protected Message $message;
    protected ?int $userId = null;
    protected ?int $chatId = null;
    public ?int $tries = 10;

    /**
     * Создать новый экземпляр задания.
     */
    public function __construct(
        Message $message,
        ?int $userId = null,
        ?int $chatId = null
    ) {
        $this->delay = now()->addSeconds(5);
        $this->message = $message;
        $this->userId = $userId;
        $this->chatId = $chatId;
    }

    /**
     * @return string|null
     */
    public function getQueue(): ?string
    {
        return $this->queue;
    }

    /**
     * Прогрессивная задержка 5, 10, 30, 60 сек
     */
    public function backoff(): array
    {
        return [5, 10, 30, 60, 300, 600, 1800, 3600];
    }

    /**
     * Выполнить задание.
     */
    public function handle(): void
    {

        try {
            MaxMessengerApiClient::messages()
                ->sendMessage(
                    $this->message->toArray(),
                    $this->userId,
                    $this->chatId
                );
        } catch (MaxBotException $exception) {
            Log::error("Ошибка задания очереди: " . $exception->getMessage());
        }
    }
}
