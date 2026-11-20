<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->whereNumber('id')->name('tasks.edit');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->whereNumber('id')->name('tasks.update');
Route::patch('/tasks/{id}/archive', [TaskController::class, 'archive'])->whereNumber('id')->name('tasks.archive');
