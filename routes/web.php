<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::resource('tasks', TaskController::class);
// In your routes/web.php or routes/web.php


//Route::get('/tasks/search', [TaskController::class, 'search'])->name('tasks.search');
Route::get('/dashboard', [TaskController::class, 'index'])->name('dashboard');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');



Route::put('/tasks/{taskId}/complete', [TaskController::class, 'markTaskAsCompleted'])->name('tasks.complete');
Route::delete('/tasks/delete-completed/{taskId}', [TaskController::class, 'deleteCompleted'])->name('tasks.deleteCompleted');



Route::post('/tasks/addNote/{taskId}', [TaskController::class, 'addNote'])->name('tasks.addNote');
Route::get('tasks/{taskId}/editNote', [TaskController::class, 'edit'])->name('tasks.editNote');
Route::patch('/tasks/{task}/updateNote', [TaskController::class, 'updateNote'])->name('tasks.updateNote');
Route::delete('/tasks/{task}/deleteNote', [TaskController::class, 'deleteNote'])->name('tasks.deleteNote');



Route::post('/register', [UserController::class, 'register'])->name('register');






// Define a route to display the feedback modal
Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');




Route::get('/feedback', function () {return view('feedback');})->name('feedback.form');
Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');


Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');



Route::get('/search-results', [TaskController::class, 'searchResults'])->name('search_results');
