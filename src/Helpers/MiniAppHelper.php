<?php

namespace Maxkhim\MaxMessengerApiClient\Helpers;

use Illuminate\Support\Facades\Log;

class MiniAppHelper
{
    /**
     * Валидация данных InitData из MiniApp через WebAppData
     * Алгоритм:
     * 1. URL-декодирование строки
     * 2. Парсинг параметров и удаление `hash`
     * 3. Сортировка ключей по алфавиту
     * 4. Формирование строки: `key=value` с разделителем \n
     * 5. Создание secret_key: HMAC-SHA256("WebAppData", bot_token)
     * 6. Вычисление hash: hex(HMAC-SHA256(secret_key, data_check_string))
     * 7. Сравнение с переданным hash
     *
     * @param string $initData Закодированная строка InitData
     * @return array ["error" => ErrorMessage, "valid" = (bool) Validation result, "user" => Max User Object]
     */
    public static function validateInitData(string $initData): array
    {
        if (!$initData) {
            return (['error' => 'InitData not provided', 'valid' => false]);
        }

        // Шаг 1: URL-декодирование
        $decodedData = urldecode($initData);

        // Шаг 2: Парсинг параметров
        parse_str($decodedData, $params);

        if (!isset($params['hash'])) {
            return (['error' => 'Hash not found in InitData', 'valid' => false]);
        }

        $hash = $params['hash'];
        unset($params['hash']); // Исключаем hash

        // Шаг 3 и 4: Сортируем по ключу и формируем строку с \n
        ksort($params);
        $dataCheckString = implode("\n", array_map(
            fn ($k, $v) => $k . '=' . $v,
            array_keys($params),
            $params
        ));

        // Шаг 5: Создаём secret_key = HMAC-SHA256("WebAppData", bot_token)

        $botToken = env('MAX_BOT_TOKEN');
        if (!$botToken) {
            Log::error('MAX_BOT_TOKEN not set in .env');
            return (['error' => 'Internal configuration error',  'valid' => false]);
        }

        $secretKey = hash_hmac('sha256', $botToken, 'WebAppData', true);

        // Шаг 6: Вычисляем hash от data_check_string с secret_key
        $computedHash = hash_hmac('sha256', $dataCheckString, $secretKey);

        // Шаг 7: Сравниваем
        if (!hash_equals($computedHash, $hash)) {
            Log::warning('InitData validation failed', ['received_hash' => $hash]);
            return (['error' => 'Invalid hash',  'valid' => false]);
        }

        // Проверка актуальности (опционально: защита от replay-атак)
        $authDate = $params['auth_date'] ?? null;
        if ($authDate && (time() - $authDate) > 86400) {
            return (['error' => 'Auth data expired',  'valid' => false]);
        }

        // Извлекаем пользователя
        $user = json_decode($params['user'] ?? '{}', true);

        return ([
            'valid' => true,
            'user' => $user
        ]);
    }
}
