<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WebhookController;
use App\Http\Controllers\Api\ClienteController;

// php artisan serve --host=192.168.10.214 --port=8000

Route::post('/webhook', [WebhookController::class, 'receive']);

Route::apiResource('clientes', ClienteController::class);
