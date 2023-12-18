@extends('layouts.app')
<html>
<body>
    
@section('content')
<link rel="stylesheet" href="css/dashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">


<div class="container">
<a href="{{ route('dashboard') }}" class="back-to-dashboard-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="searchcontainer mx-auto px-4">
        <div class="flex flex-wrap -mx-4">
            @forelse($tasks as $index => $task)
                @php
                    // Array of pastel colors
                    $pastelColors = [
                        '#ffd6ba', // pastel orange
                        '#bae1ff', // pastel blue
                        '#c7e2c0', // pastel green
                        '#ffd8e8', // pastel pink
                        // Add more pastel colors as needed
                    ];

                    // Get a color from the pastel colors array based on the index
                    $colorIndex = $index % count($pastelColors);
                    $colorStyle = 'style="background-color: ' . $pastelColors[$colorIndex] . ';"';
                @endphp
            <div class=" w-full md:w-1/2 lg:w-1/3 px-4 mb-4">
                    <div class="result bg-white shadow-lg rounded-lg p-4" {!! $colorStyle !!}>
                        <div class="border-b mb-4 pb-2 flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-blue-600 text-center">{{ $task->title }}</h2>


                            <!-- Form for deleting the task -->
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-task-btn">
                                <i class="fa fa-trash"></i> <!-- Font Awesome trash icon -->
                                </button>                            </form>
                            <!-- End of deletion form -->
                        </div>

                        <div class="mb-4">
                            <p><strong>Description:</strong> {{ $task->description }}</p>
                            <p><strong>Schedule:</strong> {{ $task->scheduled }}</p>
                            <p><strong>Category:</strong> {{ $task->category }}</p>
                            <p><strong>Recurring:</strong> {{ $task->recurring ? 'Yes' : 'No' }}</p>

                            <!-- Display notes if available -->
                            @if($task->notes)
                                <div class="flex items-center mb-2">
                                    <div class="mr-4 flex items-center">
                                        <p class="mr-2"><strong>Notes:</strong></p>
                                        <p>{{ $task->notes }}</p>
                                    </div>

                                    <!-- Icons for editing and deleting notes -->
                                    <div class="note-icons">
                                        <a href="{{ route('tasks.editNote', $task->id) }}" class="text-blue-500"><i class="fas fa-pencil-alt"></i></a>

                                        <form action="{{ route('tasks.deleteNote', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this note?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500"><i class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <!-- Button to add a note -->
                            <button class="bg-red-500 text-white font-semibold px-4 py-2 rounded-full mb-4">+</button>

                            <!-- Modal for adding a note -->
                            <div class="modal hidden">
                                <div class="modal-content">
                                    <span class="close">&times;</span>

                                    <form action="{{ route('tasks.addNote', ['taskId' => $task->id]) }}" method="POST" class="note-form">
                                        @csrf

                                        <div>
                                            <label for="note">Add Note (Max 500 characters):</label>
                                            <textarea name="note" class="border rounded-md p-2 mr-2 block w-full" placeholder="Enter Task Note" required maxlength="500"></textarea>
                                        </div>

                                        <button type="submit" class="bg-red-500 text-white font-semibold px-4 py-2 rounded-md mt-2">Done</button>
                                    </form>
                                </div>
                            </div>
                            <!-- End of note addition modal -->
                        </div>
                    </div>
                </div>

                @if(($index + 1) % 3 === 0 || $loop->last)
                    </div><!-- Closing the row if the condition is met -->
                @endif
            @empty
                <p class="w-full text-center">No tasks available</p>
            @endforelse
        </div><!-- Closing the main row div -->
    </div><!-- Closing the container div -->
</div>
    

    
@endsection
</body>
</html>