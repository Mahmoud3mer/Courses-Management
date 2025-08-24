<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateStudent extends Notification
{
    use Queueable;

    // معلومات الطالب اللي هضيفها في الاشعار
    protected $studentName;
    protected $content;

    /**
     * Create a new notification instance.
     */
    public function __construct($studentName, $content)
    {
        $this->studentName = $studentName;
        $this->content = $content;
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
     * Get the mail representation of the notification.
     */

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // هذه الدالة مسؤولة عن تحويل بيانات الإشعار إلى مصفوفة
        return [
            'studentName' => $this->studentName,
            'content' => $this->content,
        ];
    }
}
