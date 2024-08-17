<?php

namespace App\Http\Controllers\Telegram\Bots;
use Telegram\Bot\Laravel\Facades\Telegram;

abstract class TelegramBot{

    public static function bot(){
        return Telegram::bot(static::getBotName());
    }
    abstract public static function getBotName();

    abstract public static function webHookMessageHandler($received_json);

    public static function createStartChatLink($params){
        return 'https://t.me/'. static::getBotName() . '?start=' . $params;
    }

    protected static function getChatIdFromMessage($message){
        return isset($message["chat"]["id"]) ? $message["chat"]["id"] : null;
    }

}
