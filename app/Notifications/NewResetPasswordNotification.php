<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewResetPasswordNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Сброс пароля')
                    ->greeting('Добрый день!')
                    ->line('Вы получили это электронное письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.')
                    ->action('Сменить пароль', url('reset-password', $this->token))
                    ->line("Срок действия этой ссылки для сброса пароля истечет через 60 минут.")
                    ->line("Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
