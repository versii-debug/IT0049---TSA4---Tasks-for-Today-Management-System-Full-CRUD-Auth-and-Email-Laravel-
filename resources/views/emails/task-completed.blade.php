<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Task completed</title></head>
<body>
    <h1>Task completed</h1>
    <p>The following task has been marked done.</p>
    <p>ID: {{ $task->id }}</p>
    <p>Title: {{ $task->title }}</p>
    <p>Task date: {{ $task->task_date }}</p>
    <p>Status: {{ $task->status }}</p>
</body>
</html>
