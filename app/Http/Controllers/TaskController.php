<?php

namespace App\Http\Controllers;

use App\Mail\TaskCompleted;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class TaskController extends Controller
{
    public function today()
    {
        $tasks = Task::where('is_archived', false)
            ->whereDate('task_date', today())
            ->orderBy('id')
            ->get();

        return view('welcome', compact('tasks'));
    }

    public function index()
    {
        $tasks = Task::where('is_archived', false)
            ->orderBy('task_date')
            ->orderBy('id')
            ->get();

        return view('tasks.index', compact('tasks'));
    }

    public function archived()
    {
        $tasks = Task::where('is_archived', true)
            ->orderBy('task_date')
            ->orderBy('id')
            ->get();

        return view('tasks.archived', compact('tasks'));
    }

    public function archivedShow($id)
    {
        $task = Task::where('is_archived', true)->findOrFail($id);

        return view('tasks.archived-show', compact('task'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:150',
            'task_date' => 'required|date_format:Y-m-d',
            'status' => 'required|in:pending,done',
        ]);

        Task::create($data);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    public function edit($id)
    {
        $task = $this->findActiveTask($id);

        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $this->findActiveTask($id);

        $data = $request->validate([
            'title' => 'required|string|max:150',
            'task_date' => 'required|date_format:Y-m-d',
            'status' => 'required|in:pending,done',
        ]);

        DB::transaction(function () use ($id, $data) {
            $task = Task::where('is_archived', false)->lockForUpdate()->findOrFail($id);
            $wasDone = $task->status === 'done';

            $task->update($data);

            if (! $wasDone && $task->status === 'done') {
                Mail::to(config('mail.task_completed_to'))->send(new TaskCompleted($task));
            }
        });

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function archive($id)
    {
        $task = $this->findActiveTask($id);
        $task->update(['is_archived' => true]);

        return redirect()->route('tasks.index')->with('success', 'Task archived.');
    }

    private function findActiveTask($id)
    {
        return Task::where('is_archived', false)->findOrFail($id);
    }
}
