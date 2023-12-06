<!-- resources/views/tasks/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Task List</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>
        
        @if($tasks->isEmpty())
            <p>No tasks available.</p>
        @else
            <ul class="list-group">
                @foreach($tasks as $task)
                    <li class="list-group-item">
                        {{ $task->title }}
                        <a href="{{ route('tasks.index', $task) }}" class="btn btn-info btn-sm float-end">View</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
