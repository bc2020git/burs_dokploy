<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Şifrenizi Sıfırlayın')
            ->line('Bu e-postayı, şifrenizi sıfırlama talebinde bulunduğunuz için alıyorsunuz.')
            ->action('Şifreyi Sıfırla', url(config('app.url').route('password.reset', $this->token, false)))
            ->line('Bu şifre sıfırlama bağlantısının süresi 60 dakika sonra dolacaktır.')
            ->line('Eğer şifre sıfırlama talebinde bulunmadıysanız, herhangi bir işlem yapmanıza gerek yoktur.');
    }
}
