<!-- resources/views/tasks/create.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create New Task</h2>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required maxlength="100">
            </div>
            <!-- Add other form fields based on your requirements -->
            <button type="submit" class="btn btn-primary">Create Task</button>
        </form>
    </div>
@endsection
