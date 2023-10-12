<?php

namespace App\Notifications;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelScheduleDoctorEmail extends Notification
{
    use Queueable;
    protected $user;
    protected $appointment;
    protected $justification;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, Appointment $appointment, $justification)
    {
        $this->appointment = $appointment;
        $this->user = $user;
        $this->justification = $justification;
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
                    ->subject('Cita cancelada')
                    ->greeting('Hola')
                    ->line('Se le informa que su cita médica con el paciente ' . $this->appointment->patient->name . ' programada con fecha ' . $this->appointment->schedule_date . '
                            a la hora ' . $this->appointment->schedule_time . ' ha sido cancelada por el siguiente motivo: ' . $this->justification . '.')
                    ->line('Gracias por su comprensión!');
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
