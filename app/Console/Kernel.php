<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Task;
use App\Notifications\TaskApproachingNotification;


class Kernel extends ConsoleKernel
{
    

    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $tasksApproaching = Task::where('scheduled', '<=', now()->addMinutes(5))
                                    ->where('notified', false) // Flag to avoid duplicate notifications
                                    ->get();

            foreach ($tasksApproaching as $task) {
                $task->user->notify(new TaskApproachingNotification($task));
                $task->update(['notified' => true]); // Update flag to avoid duplicate notifications
            }
        })->everyMinute(); // Adjust frequency as needed
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

