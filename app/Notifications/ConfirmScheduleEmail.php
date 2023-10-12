<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmScheduleEmail extends Notification
{
    use Queueable;
    protected $user;
    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, Appointment $appointment)
    {
        $this->appointment = $appointment;
        $this->user = $user;
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
                    ->subject('Cita confirmada')
                    ->greeting('Hola, ' . $this->user->name)
                    ->line('Nos complace informar que su cita médica con el doctor ' . $this->appointment->doctor->name . ' programada con fecha ' . $this->appointment->schedule_date . '
                            a la hora ' . $this->appointment->schedule_time . ' ha sido confirmada.')
                    ->line('Llegue al menos 10 minutos antes de la hora de su cita.')
                    ->line('¡Lo esperamos!');
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
