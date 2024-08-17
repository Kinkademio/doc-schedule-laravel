<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Telegram\TelegramWebhook;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * TELEGRAM BOTS
 */
Route::post('/telegram/{token}/webhook', [TelegramWebhook::class, 'processWebhook']);
Route::get('/telegram/{token}/setHook', [TelegramWebhook::class, 'setWebHook']);
Route::get('/telegram/{token}/removeHook', [TelegramWebhook::class, 'removeWebHook']);
