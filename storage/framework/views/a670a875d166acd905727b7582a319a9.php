<?php $__env->startSection('title', 'Archived Tasks'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-heading">
    <div>
        <h1>Archived Tasks</h1>
        <p class="muted">Archived tasks remain saved and can be viewed here.</p>
    </div>
    <a class="button" href="<?php echo e(route('tasks.index')); ?>">Active Tasks</a>
</div>

<section class="card" aria-labelledby="archived-tasks-heading">
    <div class="card-heading">
        <h2 id="archived-tasks-heading">Archived Tasks <span class="count"><?php echo e($tasks->count()); ?></span></h2>
        <p class="muted">Ordered by task date. Select a title to view the task details.</p>
    </div>
    <?php if($tasks->isEmpty()): ?>
        <div class="empty-state">
            <h3>No archived tasks</h3>
            <p class="muted">Tasks you archive will appear here.</p>
        </div>
    <?php else: ?>
        <div class="table-scroll" role="region" aria-label="Archived task list" tabindex="0">
            <table>
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Task Date</th>
                        <th scope="col">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="muted">#<?php echo e($task->id); ?></td>
                            <td class="task-title"><a href="<?php echo e(route('tasks.archived.show', $task->id)); ?>"><?php echo e($task->title); ?></a></td>
                            <td><span class="badge <?php echo e($task->status === 'done' ? 'badge-done' : 'badge-pending'); ?>"><?php echo e(ucfirst($task->status)); ?></span></td>
                            <td class="date-cell"><?php echo e($task->task_date); ?></td>
                            <td class="date-cell muted"><?php echo e($task->created_at?->format('Y-m-d H:i:s')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel\githubrepos\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel-\resources\views/tasks/archived.blade.php ENDPATH**/ ?>