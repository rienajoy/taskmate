<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\TaskApproachingNotification;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'scheduled', // Update to 'scheduled_time' to hold the task's schedule time
        'is_recurring',
        'category',
        'notified', // Flag to avoid duplicate notifications
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Method to send notification when task is approaching
    public function sendApproachingNotification()
    {
        // Check if the scheduled time is within 5 minutes and notification hasn't been sent
        if ($this->scheduled <= now()->addMinutes(5) && !$this->notified) {
            // Send the notification
            $this->user->notify(new TaskApproachingNotification($this));
            
            // Update the 'notified' flag to avoid duplicate notifications
            $this->update(['notified' => true]);
        }
    }

}
