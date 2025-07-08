<?php

namespace App\Notifications\v1;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    protected $token;

    /**
     * The user model.
     *
     * @var string
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, User $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(trans('passwords.reset_password.subject'))
            ->greeting(trans('passwords.reset_password.greeting'))
            ->line(trans('passwords.reset_password.intro'))
            ->action(trans('passwords.reset_password.action'), $this->user->hasRole('Cliente') ?
                config('services.company.url_api_fronted_client') . '/reset-password?token=' . $this->token
                :  config('services.company.url_api_fronted_admin') . '/reset-password?token=' . $this->token)
            ->line(trans('passwords.reset_password.expired'))
            ->line(trans('passwords.reset_password.outro'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
