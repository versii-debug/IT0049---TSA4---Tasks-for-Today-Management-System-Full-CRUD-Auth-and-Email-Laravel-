<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', [TaskController::class, 'today'])->name('welcome');
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/tasks/archived', [TaskController::class, 'archived'])->name('tasks.archived');
    Route::get('/tasks/archived/{id}', [TaskController::class, 'archivedShow'])->whereNumber('id')->name('tasks.archived.show');
    Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
    Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->whereNumber('id')->name('tasks.edit');
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->whereNumber('id')->name('tasks.update');
    Route::patch('/tasks/{id}/archive', [TaskController::class, 'archive'])->whereNumber('id')->name('tasks.archive');
});

require __DIR__.'/auth.php';
