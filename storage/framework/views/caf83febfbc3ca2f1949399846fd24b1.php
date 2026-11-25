<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Task completed</title></head>
<body>
    <h1>Task completed</h1>
    <p>The following task has been marked done.</p>
    <p>ID: <?php echo e($task->id); ?></p>
    <p>Title: <?php echo e($task->title); ?></p>
    <p>Task date: <?php echo e($task->task_date); ?></p>
    <p>Status: <?php echo e($task->status); ?></p>
</body>
</html>
<?php /**PATH C:\Users\johnm\Downloads\TSA4_proj\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel--main\resources\views/emails/task-completed.blade.php ENDPATH**/ ?>