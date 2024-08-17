<?php

namespace App\Http\Controllers\Telegram\Bots;
use App\Http\Controllers\Telegram\Bots\TelegramBot;
use App\Models\User;


class NotificationTelegramBot extends TelegramBot
{

    public static function getBotName(){
        return env('NOTIFICATION_TELEGRAM_BOT_NAME');
    }

    public static function webHookMessageHandler($received_json){

        if(!isset($received_json["message"])) return;
        $message = $received_json["message"];

        //Получаем chat_id
        $user_chat_id = self::getChatIdFromMessage($message);
        if(!$user_chat_id) return;

        //Обрабатываем отправку сообщения в чат
        if(isset($message['text'])){
            $message_text = trim($message['text']);
            //Обрабатывем текстовое сообщение
            self::processTextMessage($message_text, $user_chat_id);
        }
    }

    private static function sayIamNotUnderstand($user_chat_id){

        self::bot()->sendMessage([
            'text' => 'Извините, я понимаю только команды!',
            'chat_id' => $user_chat_id
        ]);

    }

    private static function sayIDontKnowU($user_chat_id){

        self::bot()->sendMessage([
            'text' =>  'Я не могу идентифицировать вас, пожалуйста, начните диалог с помощью ссылки в вашем личном кабинете.',
            'chat_id' => $user_chat_id
        ]);
    }

    private static function sayHello($user_chat_id){

        self::bot()->sendMessage([
            'chat_id' => $user_chat_id,
            'text' => "Привет, я бот, от  <b>сервиса автоматизации составления графика работы врачей-рентгенологов</b>",
            'parse_mode' => 'HTML'
        ]);
    }

    private static function sayLinked($user_chat_id){

        $keyboard = array(
            "inline_keyboard" => array(
                array(
                    array(
                        'text' => 'Посмотреть график',
                        'web_app' => [
                                'url'=>'https://dnd-dusa.ru/telegram/web/schedule'
                            ]
                    ),
                ),
            )
        );

        self::bot()->sendMessage([
            'chat_id' => $user_chat_id,
            'text' => "Вы успешно привязали уведомления!",
            'parse_mode' => 'HTML',
            'reply_markup' => json_encode($keyboard)
        ]);
    }


    private static function say($user_chat_id, $message){
        self::bot()->sendMessage([
            'chat_id' => $user_chat_id,
            'text' => "$message",
            'parse_mode' => 'HTML'
        ]);
    }

    private static function processTextMessage($message_text, $user_chat_id){

        $command_regex = '/^[\/][a-zA-z]*\s*/';

        //В тексте присудствует команда для бота
        if(preg_match($command_regex, $message_text, $command_search)){
            //Очищаем команду от пробелов
            $command = str_replace(' ', '', $command_search[0]);
            //Параметры команды
            $command_params = substr($message_text, strlen($command_search[0]), strlen($message_text) - strlen($command_search[0]));

            self::processCommand($command, $user_chat_id, $command_params);
        }
        //Указан какой-то текст без команды
        else{
            //Бот пока тупенький так что текст скипаем
            self::sayIamNotUnderstand($user_chat_id);
        }
    }

    private static function processCommand($command, $user_chat_id, $command_params){
        switch($command){
            case "/start":

                self::sayHello($user_chat_id);

                //Обработка параметров команды start
                if(!$command_params){
                    self::sayIDontKnowU($user_chat_id);
                    return;
                }

                $user = User::where(['id' => $command_params])->first();

                if(!$user){
                    self::sayIDontKnowU($user_chat_id);
                    return;
                }

                $user->telegram_id = $user_chat_id;
                $user->telegram_notifications = true;
                $user->save();

                self::sayLinked($user_chat_id);

                break;
            default:
                self::bot()->sendMessage([
                    'text' => 'К сожалению, я не знаю такую команду',
                    'chat_id' => $user_chat_id
                ]);
        }
    }
}
