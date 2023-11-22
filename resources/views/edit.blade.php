<!-- resources/views/tasks/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Task</h2>
        <form action="{{ route('tasks.update', $task) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required maxlength="100" value="{{ $task->title }}">
            </div>
            <!-- Add other form fields based on your requirements -->
            <button type="submit" class="btn btn-primary">Update Task</button>
        </form>
    </div>
@endsection
