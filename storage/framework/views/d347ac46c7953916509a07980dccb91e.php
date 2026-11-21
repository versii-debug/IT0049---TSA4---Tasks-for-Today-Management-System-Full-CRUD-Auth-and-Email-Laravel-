<?php $__env->startSection('title', 'Task List'); ?>

<?php $__env->startSection('content'); ?>
<h2>All Tasks</h2>

<?php if(session('success')): ?>
    <p><?php echo e(session('success')); ?></p>
<?php endif; ?>

<p><a href="<?php echo e(route('tasks.create')); ?>">Add Task</a></p>

<?php if($tasks->isEmpty()): ?>
    <p>No tasks found.</p>
<?php else: ?>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Status</th>
            <th>Date</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($task->id); ?></td>
                <td><?php echo e($task->title); ?></td>
                <td><?php echo e($task->status); ?></td>
                <td><?php echo e($task->task_date); ?></td>
                <td><?php echo e($task->created_at->format('Y-m-d H:i:s')); ?></td>
                <td>
                    <a href="<?php echo e(route('tasks.edit', $task->id)); ?>">Edit</a>
                    <form method="POST" action="<?php echo e(route('tasks.archive', $task->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button type="submit">Archive</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hansoy\OneDrive\Documents\GitHub\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel-\resources\views/tasks/index.blade.php ENDPATH**/ ?>