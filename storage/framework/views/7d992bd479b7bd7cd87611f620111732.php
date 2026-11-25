<?php $__env->startSection('title', 'Task List'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-heading">
    <div>
        <h1>Task List</h1>
        <p class="muted">Keep your tasks organized, one day at a time.</p>
    </div>
    <?php if(auth()->guard()->check()): ?>
        <a class="button" href="<?php echo e(route('tasks.create')); ?>"><span aria-hidden="true">+</span> Add Task</a>
    <?php else: ?>
        <a class="button" href="<?php echo e(route('login')); ?>">Log in to manage tasks</a>
    <?php endif; ?>
</div>

<?php if(session('success')): ?>
    <p class="alert" role="status"><?php echo e(session('success')); ?></p>
<?php endif; ?>

<section class="card" aria-labelledby="all-tasks-heading">
    <div class="card-heading">
        <h2 id="all-tasks-heading">All Tasks <span class="count"><?php echo e($tasks->count()); ?></span></h2>
        <p class="muted">Active tasks, ordered by date. Sign in to create, edit, or archive tasks.</p>
    </div>
<?php if($tasks->isEmpty()): ?>
    <div class="empty-state">
        <h3>No tasks yet</h3>
        <p class="muted">Add your first task to get started.</p>
        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('tasks.create')); ?>">Create a task &rarr;</a>
        <?php endif; ?>
    </div>
<?php else: ?>
    <div class="table-scroll" role="region" aria-label="Task list" tabindex="0">
    <table>
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">Title</th>
            <th scope="col">Status</th>
            <th scope="col">Task Date</th>
            <th scope="col">Created At</th>
            <?php if(auth()->guard()->check()): ?> <th scope="col">Actions</th> <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="muted">#<?php echo e($task->id); ?></td>
                <td class="task-title"><?php echo e($task->title); ?></td>
                <td><span class="badge <?php echo e($task->status === 'done' ? 'badge-done' : 'badge-pending'); ?>"><?php echo e(ucfirst($task->status)); ?></span></td>
                <td class="date-cell"><?php echo e($task->task_date); ?></td>
                <td class="date-cell muted"><?php echo e($task->created_at->format('Y-m-d H:i:s')); ?></td>
                <?php if(auth()->guard()->check()): ?>
                <td>
                    <div class="task-actions">
                    <a href="<?php echo e(route('tasks.edit', $task->id)); ?>">Edit</a>
                    <form method="POST" action="<?php echo e(route('tasks.archive', $task->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <button class="archive-button" type="submit">Archive</button>
                    </form>
                    </div>
                </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    </div>
<?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel\githubrepos\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel-\resources\views/tasks/index.blade.php ENDPATH**/ ?>