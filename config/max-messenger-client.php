<?php

return [
    'base_uri' => env('MAX_API_BASE', 'https://platform-api.max.ru'),
    'access_token' => env('MAX_BOT_TOKEN'),
    'timeout' => env('MAXBOT_TIMEOUT', 30),
    'retry_times' => env('MAXBOT_RETRY_TIMES', 3),
    'retry_sleep' => env('MAXBOT_RETRY_SLEEP', 100),
];
