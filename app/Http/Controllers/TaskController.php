<?php


namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('dashboard', compact('tasks'));
    }
    

    

    public function create()
    {
        return view('tasks.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
            'description' => 'required|max:1000',
            'schedule_at' => 'nullable|date',
            'recurring' => 'boolean',
            'category' => 'in:Personal,Work',
            'reminder' => 'nullable|date', // Add the new field
        ]);
    
        // Store reminder date and time
        $validatedData['reminder_at'] = $request->input('reminder');
    
        Task::create($validatedData);
    
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }
    
    public function searchTasks(Request $request)
    {
        $keywords = $request->input('keywords');
        $category = $request->input('category');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $filteredTasks = Task::query()
            ->when($keywords, function ($query) use ($keywords) {
                $query->where('title', 'like', "%$keywords%")
                    ->orWhere('description', 'like', "%$keywords%");
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->when($startDate, function ($query) use ($startDate) {
                $query->whereDate('schedule', '>=', $startDate);
            })
            ->when($endDate, function ($query) use ($endDate) {
                $query->whereDate('schedule', '<=', $endDate);
            })
            ->get();
    
            return view('dashboard', compact('filteredTasks'));
    }
    public function showDashboard()
{
    // Your existing code to retrieve all tasks
    $tasks = Task::all(); // Or any method to fetch tasks from your database

    // Assuming you want to show all tasks initially when the dashboard loads
    return view('dashboard', compact('tasks'));
}





    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
            'description' => 'nullable|max:1000',
            'scheduled_at' => 'required|date',
            'is_recurring' => 'boolean',
            'category' => 'required|in:Personal,Work',
        ]);

        $task->update($validatedData);

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
    
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
    
    public function addNote(Request $request, $taskId) {
        $task = Task::findOrFail($taskId);
    
        // Validate the note input
        $validatedData = $request->validate([
            'note' => 'required|max:500', // Validate the 'note' field
        ]);
    
        // Retrieve existing notes and append the new note to them
        $notes = $task->notes ?? '';
        $newNote = $validatedData['note'];
        $notes .= ($notes !== '' ? "\n" : '') . $newNote;
    
        // Update the task's notes column with the new note
        $task->notes = $notes;
        $task->save();
    
        // Redirect or return a response as needed
        return redirect()->back()->with('success', 'Note added successfully');
    }
    
    
}
