<?php

namespace Maxkhim\MaxMessengerApiClient\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Maxkhim\MaxMessengerApiClient\Services\Bot\UpdateStorageService;

class MaxWebhookController extends Controller
{
    //protected MaxWebhookService $webhookService;

    public function __construct(/*MaxWebhookService $webhookService*/)
    {
        //$this->webhookService = $webhookService;
    }

    /**
     * Основной обработчик вебхуков
     */
    public function handle(Request $request, UpdateStorageService $storageService): Response
    {
        $request = Request::capture();
        $capture = [
            "json" => $request->toArray(),
            "ip" => $request->ip(),
            "headers" => $request->headers->all(),
        ];
        /*activity("max-webhook")
            ->withProperties($capture)
            ->log('Max webhook ' . $request->url() . ' dispatched');*/
        // 1. Валидация подписи/секрета
        if (!$this->validateSignature($request)) {
            Log::warning('Invalid Max webhook signature', [
                'ip' => $request->ip(),
                'payload' => $request->all()
            ]);
            return response(["success" => false, "error" => "Unauthorized"], 401);
        }

        // 2. Проверка на дубликаты (идемпотентность)
        /*$updateId = sha1(json_encode($request->toArray()));
        if ($this->isDuplicate($updateId)) {
            return response('OK', 200); // Отвечаем 200, но не обрабатываем
        }*/

        try {
            $storageService->storeUpdate($request->toArray());
            // 3. Определение типа события
            $eventType = $request->toArray()["update_type"] ?? null;
            $payload = $request->toArray();

            // 4. Диспетчеризация события
            $this->dispatchEvent($eventType, $payload);

            // 5. Быстрый ответ (в течение 1-2 секунд)
            return response(["success" => true, "error" => null], 200);
        } catch (\Exception $e) {
            Log::error('Max webhook processing error', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            // Всегда возвращаем 200 для внешнего сервиса
            // чтобы они не считали доставку неудачной
            return response(["success" => false, "error" => $e->getMessage()], 500);
        }
    }

    /**
     * Диспетчеризация по типу события
     */
    protected function dispatchEvent(string $eventType, array $payload): void
    {

        /*switch ($eventType) {
            case 'message_received':
                //$this->webhookService->processIncomingMessage($payload);
                break;
            case 'message_delivered':
                //$this->webhookService->processDeliveryStatus($payload);
                break;
            case 'message_read':
                //$this->webhookService->processReadStatus($payload);
                break;
            default:
                Log::info("Unknown Max event type: {$eventType}", $payload);
        }*/
    }

    /**
     * Валидация подписи запроса
     */
    protected function validateSignature(Request $request): bool
    {
        $secret = env("MAX_WEBHOOK_SECRET");
        $signature = $request->header('X-Max-Bot-Api-Secret');

        if ($secret != $signature) {
            return false;
        }

        return true;

        /*$payload = $request->getContent();
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);*/
    }

    /**
     * Проверка на дубликаты (5-минутное окно)
     */
    protected function isDuplicate(string $eventId): bool
    {
        $cacheKey = "max_webhook_{$eventId}";

        if (Cache::has($cacheKey)) {
            return true;
        }

        Cache::put($cacheKey, true, now()->addMinutes(5));
        return false;
    }
}
