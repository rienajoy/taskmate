<!-- resources/views/tasks/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Task Details</h2>
        <div>
            <strong>Title:</strong> {{ $task->title }}
        </div>
        <div>
            <strong>Description:</strong> {{ $task->description ?? 'N/A' }}
        </div>
        <!-- Add other task details as needed -->
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-warning">Edit Task</a>
    </div>
@endsection
