<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Notifications\TaskApproachingNotification;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $tasks = Task::where('user_id', auth()->user()->id)->get();
            return view('dashboard', compact('tasks'));
        } else {
            // Handle the case when the user is not authenticated
            return redirect()->route('login');
        }
    }
    
    


public function store(Request $request)
{
    $validatedData = $request->validate([
        'title' => 'required|max:100',
        'description' => 'required|max:1000',
        'scheduled' => 'nullable|date_format:Y-m-d\TH:i', // Adjust format based on your form
        'is_recurring' => 'boolean',
        'category' => 'in:Personal,Work',
    ]);

    $task = new Task();
    $task->title = $validatedData['title'];
    $task->description = $validatedData['description'];

    // Check if 'scheduled' key exists in validated data
    if (isset($validatedData['scheduled'])) {
        $scheduledDateTime = \DateTime::createFromFormat('Y-m-d\TH:i', $validatedData['scheduled']);

        if ($scheduledDateTime !== false) {
            $formattedScheduled = $scheduledDateTime->format('Y-m-d H:i:s');
            $task->scheduled = $formattedScheduled;
        }
    }

    $task->is_recurring = $validatedData['is_recurring'] ?? false;
    $task->category = $validatedData['category'];
    $task->user_id = auth()->user()->id;

    // Save the task to the database
    $task->save();

    // Redirect or return a response as needed
    // For example:
    return redirect()->route('tasks.index')->with('success', 'Task created successfully');
}



    public function destroy(Task $task)
    {
        $task->delete();
    
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }


    
    public function addNote(Request $request, $taskId) {
        $task = Task::findOrFail($taskId);
    
        
        $validatedData = $request->validate([
            'note' => 'required|max:500', 
        ]);
    
       
        $notes = $task->notes ?? '';
        $newNote = $validatedData['note'];
        $notes .= ($notes !== '' ? "\n" : '') . $newNote;
    
        
        $task->notes = $notes;
        $task->save();
    
        return redirect()->back()->with('success', 'Note added successfully');
    }
    
    public function edit($taskId)
    {
        // Fetch the task based on the provided ID
        $task = Task::findOrFail($taskId);

        // Pass the task data to the view for editing the note
        return view('tasks.editNote', compact('task'));
    }

    public function updateNote(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'note' => 'required|max:500',
        ]);

        
        $task->notes = $validatedData['note'];
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Note updated successfully.');
    }


    public function deleteNote(Task $task)
    {
        
        $task->notes = null;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Note deleted successfully.');
    }
    

    public function deleteCompleted($taskId)
    {
        $task = Task::find($taskId);
    
        if ($task && $task->completed) {
            $task->delete();
            return redirect()->back()->with('success', 'Task deleted successfully');
        }
    
        return redirect()->back()->with('error', 'Task not found or not completed');
    }
    
    

    public function markTaskAsCompleted(Request $request, $taskId)
    {
        // Find the task by ID
        $task = Task::find($taskId);

        if ($task) {
            // Update task completion status
            $task->completed = true;
            $task->save();
            
            // Redirect or return the updated task list view
            return redirect()->route('tasks.index')->with('success', 'Task marked as completed.');
        } else {
            // Task not found, handle the error (e.g., redirect with error message)
            return redirect()->route('tasks.index')->with('error', 'Task not found.');
        }
    }




    public function searchResults(Request $request)
    {
        $query = $request->input('query');
    
        $tasks = Task::where('user_id', auth()->user()->id) // Assuming the user_id column relates to the user's ID in the tasks table
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('title', 'like', "%$query%")
                    ->orWhere('category', 'like', "%$query%")
                    ->orWhere('scheduled', 'like', "%$query%");
            })
            ->get();
    
        return view('search_results', compact('tasks'));
    }


    public function createTask(Request $request)
    {
        // Logic to create the task
        $taskDetails = $request->input('task_details');
        $userEmail = $request->input('user_email');

        // Schedule the notification to be sent 5 minutes before the task time
        $scheduledTime = now()->addMinutes(5);

        Notification::route('mail', $userEmail)
            ->notify((new TaskApproachingNotification($taskDetails))->delay($scheduledTime));

        // Rest of your code to create the task...
    }
}



    