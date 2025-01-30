<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Distribution extends Notification
{
    use Queueable;

    public $shipment;

    /**
     * Create a new notification instance.
     */
    public function __construct($shipment)
    {
        $this->shipment = $shipment;
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
                    ->line('Diberitahukan pada semua pengawai lapangan dan sopir')
                    ->line('akan diadakan pembongkaran pada tanggal '. Carbon::parse($this->shipment->unloading_date)->locale('id')->isoFormat('DD-MM-YYYY'));
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
