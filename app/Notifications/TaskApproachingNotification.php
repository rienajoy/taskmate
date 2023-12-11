<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TaskApproachingNotification extends Notification
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Task Reminder: ' . $this->task->title)
            ->line('Your task "' . $this->task->title . '" is approaching in 5 minutes!')
            ->action('View Task', route('tasks.show', $this->task->id))
            ->line('Thank you for using our application!');
    }
}
