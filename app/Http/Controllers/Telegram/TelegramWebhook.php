<?php

namespace App\Http\Controllers\Telegram;

use App\Http\Controllers\Telegram\Bots\NotificationTelegramBot;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramWebhook
{

  protected mixed $botToken;

  public function __construct()
  {
    $this->botToken = request()->route('token');
  }

  public function processWebhook()
  {

    $secret = request()->header('X-Telegram-Bot-Api-Secret-Token');
    if (!$secret || $secret !== env('TELEGRAM_WEBHOOK_SECRET')) return response()->json();

    $received_message = request()->getContent();
    if (!$received_message) return response()->json();
    $received_json = json_decode($received_message, true);

    if($this->botToken == env('NOTIFICATION_TELEGRAM_BOT_TOKEN')){
      NotificationTelegramBot::webHookMessageHandler($received_json);
    }
    return response()->json();
  }

  public function setWebHook()
  {

    $bot = null;
    switch ($this->botToken) {
      case env('NOTIFICATION_TELEGRAM_BOT_TOKEN'):
        $bot = NotificationTelegramBot::bot();
        break;
    }

    $response = $bot->setWebhook(
      [
        'url' => 'https://dnd-dusa.ru/api/telegram/' . $this->botToken . '/webhook',
        'secret_token' => env('TELEGRAM_WEBHOOK_SECRET')
      ]
    );
    return response()->json(['success' => true, 'message' => 'linked', 'data' => $response]);

  }


  public function removeWebHook()
  {
    $bot = null;
    switch ($this->botToken) {
      case env('NOTIFICATION_TELEGRAM_BOT_TOKEN'):
        $bot = NotificationTelegramBot::bot();
        break;
    }
    if (!$bot) {
      return response()->json(['success' => false, 'error' => 'unknown']);
    }

    $response = $bot->removeWebhook();
    return response()->json(['success' => true, 'message' => 'unlinked', 'data' => $response]);
  }
}
