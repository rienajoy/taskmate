<x-app-layout>
@section('content')
<html>
   
       <head>
          <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
          <link rel="stylesheet" href="css/dashboard.css">
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
       </head>
         
        <body>
            <div class="container">
                 <div class="main-content">
                <div class="search">
                    <br>
                    <form action="{{ route('search_results') }}" method="GET">
                        <input type="text" name="query" placeholder="Search by title, category, or date">
                        <button type="submit">Search</button>
                    </form>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <button id="createTaskBtn" class="button-submit">Create Task</button>
                </div>
                <hr>
                <div id="taskModal" class="modal">
                    <div class="modal-content">
                    <span class="close-modal">&times;</span>
                    <div class="taskform">
                        <form action="{{ route('tasks.store') }}" method="POST" class="task-form">
                         @csrf 
                            <h3 class="text-lg font-semibold mb-4">Create Task</h3>
                                <label for="title" class="block mb-2">Title:</label>
                                <input
                                 type="text"
                                 name="title"
                                 class="border-gray-300 border rounded-md p-2 mb-4 w-full"
                                 placeholder="Enter Task Title"
                                 required
                                 maxlength="100">
                            <h3 style="text-align: center;">Schedule</h3>
                            <hr>
                            <div class="mt-4 mb-4 lg:mr-4">
                            <label for="schedule">Schedule:</label>
                            <input type="datetime-local" name="scheduled" id="schedule">
                        </div>
                                    <label for="category" class="block mb-2">Category:</label>
                                    <select class="border-gray-500 border rounded-md p-2 mb-4 w-full" name="category" id="category">
                                    <option value="Personal">Personal</option>
                                    <option value="Work">Work</option>
                                    </select>

                                <div class="mb-4" id="specificDay" style="display: none;">
                                    <label for="specificDate" class="block mb-2">Choose a Date:</label>
                                    <input type="date" name="specificDate" id="specificDate" class="border-gray-300 border rounded-md p-2 w-full">
                                </div>

                                    <label for="description" class="block mb-2">Description:</label>
                                    <textarea name="description" class="border-gray-300 border rounded-md p-2 mb-4 w-full" placeholder="Enter Task Description" required maxlength="1000"></textarea>

                                <div class="center-button">
                                    <button type="submit" class="button-submit">Add Task</button>
                                </div>
                        </form>
                        </div>
                    </div>
                </div>
                <script>
                    function toggleSpecificDay(value) {
                    const specificDay = document.getElementById('specificDay');
                    if (value === 'chooseday') {
                        specificDay.style.display = 'block';
                    } else {
                        specificDay.style.display = 'none';
                    }
                    }
                    const modal = document.getElementById('taskModal');
                    const btn = document.getElementById('createTaskBtn');
                    const closeBtn = document.getElementsByClassName('close')[0];
                    btn.onclick = function () {
                     modal.style.display = 'block';
                    };
                    closeBtn.onclick = function () {
                     modal.style.display = 'none';
                    };
                    window.onclick = function (event) {
                     if (event.target === modal) {
                     modal.style.display = 'none';
                    }
                    };
                    </script>

       <div class="task">
            <h3 class="text-center text-lg font-semibold mb-4 mt-4" style="color: white;">Task Lists</h3>
             @forelse($tasks as $index => $task)
             @if(!$task->completed)
             @if($index % 3 === 0)
             @endif

             

            <div class="card">
            <form action="{{ route('tasks.complete', ['taskId' => $task->id]) }}" method="POST" class="checkbox-form">
    @csrf
    @method('PUT')
    <label class="checkbox-label">
        <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>
        Completed
    </label>
</form>

                <div class="card-body">
                    <div class="box">
                        <div class="flex justify-between items-center">
                            <b><h2 class="card-subtitle mb-2 ml-4 text-body-secondary" style="font-size: 24px; font-family: 'Roboto Condensed', sans-serif;">{{ $task->title }}</h2></b>

                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                            @csrf
                            @method('DELETE')
                                 <button type="submit" class="delete-note-button bg-red-500 text-white font-semibold px-2 py-2 rounded-md">Delete</button>
                            </form>
                        </div>
                        <p class="ml-4" style="color: white">Description: {{ $task->description }}</p>
                        <p class="ml-4">Schedule: {{ $task->scheduled }}</p>
                        <p class="ml-4" style="color: white">Category: {{ $task->category }}</p>
                         @if($task->notes)
                        <div class="flex items-center mb-2">
                            <div class="mr-4 flex items-center">
                                <p class="mr-2 ml-4">Notes:</p>
                                <p>{{ $task->notes }}</p>
                            </div>
                             <form action="{{ route('tasks.deleteNote', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this note?');">
                             @csrf
                              @method('DELETE')
                              <button type="submit" class="delete-note-button">
                                <i class="fas fa-trash-alt m-4 text-red-500 cursor-pointer"></i>
                             </form>
                        </div>
                            @endif
                            <button class="ml-4 mb-4 mt-4 add-note-button bg-red-500 text-white font-semibold px-4 py-2 rounded-full"> +</button>
                        <div class="modal hidden">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <form action="{{ route('tasks.addNote', ['taskId' => $task->id]) }}" method="POST" class="note-form">
                                     @csrf
                                    <div>
                                        <label for="note">Add Note (Max 500 characters):</label>
                                        <textarea name="note" class="border-gray-900 border rounded-md p-2 mr-2" placeholder="Enter Task Note" required maxlength="500" style="width: 100%;"></textarea>
                                    </div>
                                    <button type="submit" class="bg-red-500 text-white font-semibold px-4 py-2 rounded-md mt-2 mr-auto">Done</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(($index + 1) % 3 === 0 || $loop->last) 
               @endif
               @endif
               @empty
               <p style="text-align: center;">No tasks available</p>
                @endforelse
             </div>
            </div>

            <div class="sidebar">
            <h3 class="text-lg font-semibold mb-4">Completed Task List</h3>
            <div class="task-list-container">
              @php
             $pastelColors = ['#FFD1DC', '#FFDAB9', '#B0E0E6', '#98FB98', '#FFA07A']; // List of pastel colors
             @endphp
            @foreach($tasks as $index => $task)
            @if($task->completed)
                <div class="task-item-container" style="align-items: justify;">
                    <div class="card" style="background-color: {{ $pastelColors[$index % count($pastelColors)] }};">
                        <div class="card-content" style="display: flex; justify-content: space-between; align-items: center;">
                            <h2 class="card-subtitle text-body-secondary">{{ ucfirst($task->title) }}</h2>
                                <div class="button-group">
                                    <button onclick="showTaskDetails('{{ $task->id }}')" class="view-details-btn">View Details</button>
                                    <div id="taskModal_{{ $task->id }}" class="viewmodal" style="display: none;">
                                        <div class="viewmodal-content">
                                        <span class="close" onclick="hideTaskDetails('{{ $task->id }}')">&times;</span>
                                        <h2 class="title card-subtitle text-body-secondary">{{ ucfirst($task->title) }}</h2>   
                                    <div class="taskbox ml-4">
                                        <p style="color: white">Description: {{ $task->description }}</p>
                                        <p style="color: white "> {{ \Carbon\Carbon::parse($task->scheduled)->isoFormat('MMMM D, YYYY HH:mm') }}</p>

                                        <p  style="color: white">Category: {{ $task->category }}</p>
                                        @if($task->notes)
                                        <div class="flex items-center mb-2">
                                            <div class="mr-4 flex items-center">
                                            <p class="mr-2"  style="color: white">Notes: {{ $task->notes }}</p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                 </div>
                        </div>
                        <form action="{{ route('tasks.deleteCompleted', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                         @csrf
                        @method('DELETE')
                            <button type="submit" class="delete-task-btn">
                                <i class="fa fa-trash"></i> 
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>
            <script>
                function deleteCompletedTask(taskId) {
                    fetch(`/tasks/delete-completed/${taskId}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            const taskItem = document.getElementById(`taskItem_${taskId}`);
                            if (taskItem) {
                                taskItem.remove();
                            }
                        } else {
                            console.error('Failed to delete task');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            </script>


            <script>
                    const completedTasksBtn = document.getElementById('completedTasksBtn');
                    const completedTasksModal = document.getElementById('completedTasksModal');

                    function toggleCompletedTasks() {
                        if (completedTasksModal.style.display === 'none') {
                        completedTasksModal.style.display = 'block';
                        } else {
                        completedTasksModal.style.display = 'none';
                        }
                    }

                    function closeCompletedTasksModal() {
                        completedTasksModal.style.display = 'none';
                    }

                    completedTasksBtn.addEventListener('click', toggleCompletedTasks);
            </script>

            <script>
                function showTaskDetails(taskId) {
                    var modal = document.getElementById('taskModal_' + taskId);
                    if (modal) {
                        modal.style.display = 'block';
                    }
                }

                function hideTaskDetails(taskId) {
                    var modal = document.getElementById('taskModal_' + taskId);
                    if (modal) {
                        modal.style.display = 'none';
                    }
                }
            </script>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const closeModalBtn = document.querySelector('.close-modal');

                if (closeModalBtn) {
                    closeModalBtn.addEventListener('click', function() {
                        const modal = document.getElementById('taskModal');
                        if (modal) {
                            modal.style.display = 'none';
                        }
                    });
                }
            });

            </script>
            <script>
                const addNoteButtons = document.querySelectorAll('.add-note-button');

                addNoteButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const modal = button.nextElementSibling;
                        modal.style.display = 'block';
                    });
                });

                document.addEventListener('click', (event) => {
                    if (event.target.classList.contains('close')) {
                        const modal = event.target.closest('.modal');
                        modal.style.display = 'none';
                    }
                });
            </script>
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
                flatpickr('#date-picker', {
                    altInput: true, 
                    altFormat: 'F j, Y', 
                    dateFormat: 'Y-m-d',
                });

              
                flatpickr('#time-picker', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: 'h:i K',
                    time_24hr: false,
                });
            </script>
            @endsection    

        </body>
    </html>
</x-app-layout>


