<?php

use Illuminate\Support\Facades\Route;
use Maxkhim\MaxMessengerApiClient\Http\Controllers\MaxWebhookController;

Route::post('/api/v1/max-apps/webhook', [MaxWebhookController::class, 'handle'])
    ->name('webhook.max');

Route::post('/api/v1/max-apps/webhook-x', [MaxWebhookController::class, 'handle'])
    ->name('webhook.max-x');
