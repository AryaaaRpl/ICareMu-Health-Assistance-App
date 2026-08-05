<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SystemAlertNotification extends Notification
{
    use Queueable;

    public array $data;

    /**
     * Create a new notification instance.
     *
     * @param array $data ['title' => string, 'message' => string, 'url' => string, 'type' => string]
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->data['title'] ?? 'Pemberitahuan Sistem',
            'message' => $this->data['message'] ?? '',
            'url' => $this->data['url'] ?? '#',
            'type' => $this->data['type'] ?? 'info',
        ];
    }
}
