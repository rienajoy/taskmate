<!-- resources/views/tasks/task-list.blade.php -->

@extends('layouts.app') <!-- If you have a layout file -->

@section('content')
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
                        <a href="{{ route('tasks.editNote', $task->id) }}">
                          <i class="fas fa-pencil-alt"></i>
                        </a>
                        

                        
                        <form action="{{ route('tasks.deleteNote', $task->id) }}" method="POST" class="delete-form inline" onsubmit="return confirm('Are you sure you want to delete this note?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="delete-note-button">
                            <i class="fas fa-trash-alt text-red-500 cursor-pointer"></i>
                          </button>
                        </form>
                      </div>
                    </div>
                  @endif

                  <button class="ml-4 mb-4 mt-4 add-note-button bg-red-500 text-white font-semibold px-4 py-2 rounded-full">
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


                </div>
            @endforeach
        </div>
    </div>
@endsection
