<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('is_archived', false)
            ->orderBy('task_date')
            ->orderBy('id')
            ->get();

        return view('tasks.index', compact('tasks'));
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
        $task = $this->findActiveTask($id);

        $data = $request->validate([
            'title' => 'required|string|max:150',
            'task_date' => 'required|date_format:Y-m-d',
            'status' => 'required|in:pending,done',
        ]);

        $task->update($data);

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
