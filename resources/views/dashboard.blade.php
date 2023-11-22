
<x-app-layout>
    <!-- Font Awesome CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">


    <style>
        /* Modal Styles */
.modal {
    display: none;
    position: absolute;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background-color: #fefefe;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 400px;
    width: 100%;
    
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.note-icons{
    padding-left: 100px;
    position: relative;
}

.delete-note-icon{
    padding-left: 20px;
}
    </style>
<div class="flex flex-col lg:flex-row p-6">
        <!-- Create Task Interface Container -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:w-1/2 mb-4 lg:mb-0 lg:order-1">
            <div class="p-6">
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

                    <!-- Task Schedule -->
                    <label for="schedule">Schedule:</label>
                    <input type="datetime-local" name="schedule" id="schedule">

                    <!-- Task Recurring Checkbox -->
                    <label for="recurring">Recurring:</label>
                    <input type="checkbox" name="recurring" id="recurring">

                    <!-- Task Category -->
                    <label for="category">Category:</label>
                    <select name="category" id="category">
                        <option value="Personal">Personal</option>
                        <option value="Work">Work</option>
                    </select>

                    <!-- Submit Button -->
                    <button type="submit" class="bg-red-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-md">Add Task</button>
                </form>

                <!-- Reminder -->
                <label for="reminder">Reminder:</label>
                <input type="datetime-local" name="reminder" id="reminder">
            </div>
        </div>

        <!-- Task List Container -->
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg lg:w-1/2 lg:order-2 ">
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Task List</h3>

                  <!-- Display Existing Tasks as Cards in a Grid -->
                  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($tasks as $task)
                    <div class="border rounded-lg p-4 bg-blue-100">
                        <!-- Task Details -->
                        <h4 class="font-semibold">{{ $task->title }}</h4>
                        <p>Description: {{ $task->description }}</p>
                        <p>Schedule: {{ $task->schedule }}</p>
                        <p>Category: {{ $task->category }}</p>
                        <p>Recurring: {{ $task->recurring ? 'Yes' : 'No' }}</p>

<!-- Existing Task Notes Section -->
@if($task->notes)
    <div class="flex items-center mb-2">
        <div class="mr-4 flex items-center">
            <strong class="mr-2">Notes:</strong>
            <p>{{ $task->notes }}</p>
        </div>
        <div class="note-icons">
            <!-- Edit Icon -->  
            <button class="edit-note-icon" data-note="{{ $task->notes }}">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <!-- Delete Icon -->
            <button class="delete-note-icon ml-2">
                <i class="fas fa-trash-alt text-red-500 cursor-pointer"></i>
            </button>
        </div>
    </div>
@endif



      <!-- Task Notes Button -->
<button class="add-note-button bg-red-500 text-white font-semibold px-4 py-2 rounded-full">
    +
</button>

 <!-- Hidden Task Notes Form (Modal) -->
 <div class="modal hidden">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <form action="{{ route('tasks.addNote', ['taskId' => $task->id]) }}" method="POST"
                                    class="note-form">
                                    @csrf
                                   <div>
                                   <label for="note">Add Note (Max 500 characters):</label>
                                    <textarea name="note" class="border-gray-900 border rounded-md p-2 mr-2"
                                        placeholder="Enter Task Note" required maxlength="500" style="width: 100%;"></textarea>
                                   </div> 
                                     <!-- Placing the "Done" button below the textarea -->
                <button type="submit"
                    class="bg-red-500 text-white font-semibold px-4 py-2 rounded-md mt-2">
                    Done
                </button>
                                </form>

                                 <!-- Edit and Delete Buttons -->
        <div class="mt-4 flex justify-between">
            <button class="edit-note-button bg-blue-500 text-white font-semibold px-4 py-2 rounded-md">Edit</button>
            <button class="delete-note-button bg-red-500 text-white font-semibold px-4 py-2 rounded-md">Delete</button>
        </div>
                            </div>
                        </div>


                        <!-- Task Progress Tracking -->
                        <input type="checkbox" name="task_complete" id="task_complete_{{ $task->id }}" {{ $task->is_complete ? 'checked' : '' }}>

                        <!-- Task Deletion -->
<form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-500 hover:text-red-600 font-semibold ml-2">Delete</button>
</form>

                    </div>
                    @empty
                    <p>No tasks available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    </div>

<script>
    // JavaScript to display/hide the modal
const modal = document.getElementById('deleteConfirmationModal');
const deleteButtons = document.querySelectorAll('.delete-button');

deleteButtons.forEach(button => {
    button.addEventListener('click', () => {
        modal.style.display = 'block';
    });
});

closeButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close the modal if the user clicks outside of it
window.addEventListener('click', (event) => {
    if (event.target === modal) {
        modal.style.display = 'none';
    }
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
<!-- ... (Previous HTML code remains unchanged) ... -->

<!-- ... (Previous HTML code remains unchanged) ... -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editNoteButtons = document.querySelectorAll('.edit-note-icon');
        const deleteNoteButtons = document.querySelectorAll('.delete-note-icon');
        const modals = document.querySelectorAll('.modal');
        const noNotesMessage = document.getElementById('no-notes-message');

        editNoteButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const noteId = button.dataset.noteId;
                const noteTextElement = button.parentElement.previousElementSibling.querySelector('p');
                const noteText = noteTextElement.textContent.trim();
                const modal = modals[index];
                const noteTextarea = modal.querySelector('textarea[name="note"]');
                noteTextarea.value = noteText;
                modal.style.display = 'block';

                const doneButton = modal.querySelector('button[type="submit"]');
                doneButton.dataset.noteElement = noteTextElement; // Store the note element

                doneButton.addEventListener('click', function (event) {
                    event.preventDefault();
                    const newNote = noteTextarea.value;
                    const storedNoteElement = event.target.dataset.noteElement;

                    if (storedNoteElement) {
                        storedNoteElement.textContent = newNote; // Replace existing note with edited note
                    }

                    // Update the note in the database using AJAX
                    fetch(`/update-note/${noteId}`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ note: newNote }),
                    })
                        .then(response => response.json())
                        .then(data => console.log(data)) // Handle response as needed
                        .catch(error => console.error('Error:', error));

                    modal.style.display = 'none';
                });
            });
        });

        deleteNoteButtons.forEach((button, index) => {
            button.addEventListener('click', () => {
                const noteId = button.dataset.noteId;
                const noteTextElement = button.parentElement.previousElementSibling.querySelector('p');
                noteTextElement.textContent = ''; // Remove the note content
                const modal = modals[index];
                modal.style.display = 'none'; // Hide the modal after deleting

                // Delete the note from the database using AJAX
                fetch(`/delete-note/${noteId}`, {
                    method: 'DELETE',
                })
                    .then(response => response.json())
                    .then(data => console.log(data)) // Handle response as needed
                    .catch(error => console.error('Error:', error));
            });
        });

        // Show no notes message if no notes are available
        if (!document.querySelector('.edit-note-icon')) {
            noNotesMessage.style.display = 'block';
        }
    });
</script>


</x-app-layout>

