<x-app-layout>
    <!-- Font Awesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


<style>  
    .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%; /* Adjust width as needed */
            border-radius: 5px;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
        }
        
        .modal-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .modal-btn:hover {
            background-color: #0056b3;
        }

        .bg-blue {
            width: 50%; /* Adjust this value to fit your desired width */
            height: fit-content; /* Adjust this if you want to set a fixed height */
            float: left; 
           
        }

        .bg-red {
            width: 50%; /* Adjust this value to fit your desired width */
            height: fit-content; /* Adjust this if you want to set a fixed height */
            float: right; 
            border-style: solid black;
           
        }
</style>
    



 <div class="flex flex-col lg:flex-row p-6">
        <!-- First Column: Create Task Interface -->
        <div class="lg:w-1/2 mb-4 lg:mb-0 lg:order-1">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Create Task</h3>
               
                <!-- Create Task Form -->
                <form action="{{ route('tasks.store') }}" method="POST" class="mb-4">
                    @csrf
                    <!-- Task Title -->
                    <label for="title">Title:</label>
                    <input type="text" name="title" class="border-gray-300 border rounded-md p-2 mr-2" placeholder="Enter Task Title" required maxlength="100">

                    <!-- Task Description -->
                    <label for="description">Description:</label>
                    <textarea name="description" class="border-gray-300 border rounded-md p-2 mr-2" placeholder="Enter Task Description" required maxlength="1000"></textarea>

                    <div class="flex lg:flex-row flex-col">
                        <!-- Task Schedule -->
                        <div class="mt-4 mb-4 lg:mr-4">
                            <label for="schedule">Schedule:</label>
                            <input type="datetime-local" name="scheduled" id="schedule">
                        </div>
                        

                        <!-- Task Category -->
                        <div class="mb-4">
                            <label for="category">Category:</label>
                            <select name="category" id="category">
                                <option value="Personal">Personal</option>
                                <option value="Work">Work</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="repeat">Repeat:</label>
                        <select name="repeat" id="repeat">
                            <option value="everyday">Everyday</option>
                            <option value="chooseday">Choose a Day</option>
                        </select>
                    </div>

                       <!-- Specific Day for Recurrence -->
    <div class="mb-4" id="specificDay" style="display: none;">
        <label for="specificDate">Choose a Date:</label>
        <input type="date" name="specificDate" id="specificDate">
    </div>
                
                    <!-- Submit Button -->
                    <button type="submit" class="bg-red-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md">Add Task</button>
                </form>

            </div>
        </div>


        

        <div class="container-fluid">
    <div class="row">
        <!-- Task List Section -->
        <div class="col">
            <div class="bg-blue shadow-lg sm:rounded-lg p-6">
                <h3 class="container text-center text-lg font-semibold mb-4">Task List</h3>
                
                <div class="overflow-auto">
                    <div class="row">
                        @forelse($tasks as $index => $task)
                            @if(!$task->completed) <!-- Checking if task is not completed -->
                                @if($index % 3 === 0)
                                    <div class="row">
                                @endif

                                <form action="{{ route('tasks.complete', ['taskId' => $task->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : '' }}>Completed
                                </form>

                                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card">
              <div class="card-body">
                <div class="border rounded-lg p-4 bg-blue-100">
                  <div class="flex justify-between items-center">
                    <b><h2 class="card-subtitle mb-2 ml-4 text-body-secondary">{{ $task->title }}</h2></b>
      
                  


                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="delete-note-button bg-red-500 text-white font-semibold px-2 py-2 rounded-md">Delete</button>
                    </form>
                  </div>

                  <hr>
                  <p class="ml-4">Description: {{ $task->description }}</p>
                  <p class="ml-4">Schedule: {{ $task->scheduled }}</p>
                  <p class="ml-4">Category: {{ $task->category }}</p>
                  <p class="ml-4">Recurring: {{ $task->recurring ? 'Yes' : 'No' }}</p>

                  @if($task->notes)
                    <div class="flex items-center mb-2">
                      <div class="mr-4 flex items-center">
                        <p class="mr-2 ml-4">Notes:</p>
                        <p>{{ $task->notes }}</p>
                      </div>


                      <div class="note-icons">
                        <a href="{{ route('tasks.editNoteForm', $task->id) }}">
                          <i class="fas fa-pencil-alt"></i> Edit
                        </a>

                        <form action="{{ route('tasks.deleteNote', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this note?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="delete-note-button">
                            <i class="fas fa-trash-alt text-red-500 cursor-pointer"></i> Delete
                          </button>
                        </form>
                      </div>
                    </div>
                  @endif

                  <button class="add-note-button bg-red-500 text-white font-semibold px-4 py-2 rounded-full">
                    +
                  </button>

                  <div class="modal hidden">
                    <div class="modal-content">
                      <span class="close">&times;</span>

                      <form action="{{ route('tasks.addNote', ['taskId' => $task->id]) }}" method="POST" class="note-form">
                        @csrf

                        <div>
                          <label for="note">Add Note (Max 500 characters):</label>
                          <textarea name="note" class="border-gray-900 border rounded-md p-2 mr-2" placeholder="Enter Task Note" required maxlength="500" style="width: 100%;"></textarea>
                        </div>

                        <button type="submit" class="bg-red-500 text-white font-semibold px-4 py-2 rounded-md mt-2 mr-auto">
                          Done
                        </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        @if(($index + 1) % 3 === 0 || $loop->last)
                                    </div>
                                @endif
                            @endif
                        @empty
                            <p>No tasks available</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>



        
  <div class="col">
    <div class="bg-red overflow-hidden shadow-xl sm:rounded-lg p-6">
        <h3 class="container text-center text-lg font-semibold mb-4">Completed Tasks</h3>

        <div class="overflow-auto">
            <div class="row">
                @foreach($tasks as $task)
                
                    @if($task->completed)
                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="border rounded-lg p-4 bg-blue-100">
                                        <div class="flex justify-between items-center">
                                            <b><h2 class="card-subtitle mb-2 ml-4 text-body-secondary">{{ $task->title }}</h2></b>
                                            @csrf
                      @method('DELETE')
                      <button type="submit" class="delete-note-button bg-red-500 text-white font-semibold px-2 py-2 rounded-md">Delete</button>
                    </form>
                                        </div>
                                         <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                     
                                        <hr>
                                        <p class="ml-4">Description: {{ $task->description }}</p>
                                        <p class="ml-4">Schedule: {{ $task->schedule }}</p>
                                        <p class="ml-4">Category: {{ $task->category }}</p>
                                        <p class="ml-4">Recurring: {{ $task->recurring ? 'Yes' : 'No' }}</p>
                                        @if($task->notes)
                                            <div class="flex items-center mb-2">
                                                <div class="mr-4 flex items-center">
                                                    <p class="mr-2 ml-4">Notes:
                                                    {{ $task->notes }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    @endif
                @endforeach
               
            </div>
        </div>
    </div>
</div>
         


   







<script>
    const seeMoreButton = document.getElementById('seeMoreButton');
    const remainingTasks = document.getElementById('remainingTasks');

    seeMoreButton.addEventListener('click', (event) => {
        event.preventDefault();
        remainingTasks.classList.toggle('hidden');
        seeMoreButton.textContent = remainingTasks.classList.contains('hidden') ? 'See More' : 'See Less';
    });
</script>


<!-- ... Other HTML code remains unchanged ... -->
<script>
    // JavaScript to control modal visibility
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



</x-app-layout>

