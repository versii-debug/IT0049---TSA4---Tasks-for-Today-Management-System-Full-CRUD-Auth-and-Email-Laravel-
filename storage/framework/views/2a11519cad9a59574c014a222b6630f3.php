<?php $__env->startSection('title', 'Welcome'); ?>

<?php $__env->startSection('content'); ?>
<section class="welcome" aria-labelledby="welcome-heading">
    <p class="eyebrow">A little focus. A better day.</p>
    <h1 id="welcome-heading">Make room for what matters today.</h1>
    <p class="muted">Welcome to Tasks for Today. Keep your plans in one place, take things one step at a time, and enjoy a little more clarity.</p>
    <div class="welcome-actions">
        <a class="button" href="#features">Explore the idea <span aria-hidden="true">&darr;</span></a>
    </div>
</section>

<section id="features" aria-labelledby="features-heading">
    <h2 id="features-heading">A simpler approach to your day</h2>
    <div class="features">
        <article class="card feature">
            <h3>Clear your mind</h3>
            <p class="muted">Start with a simple list of the things you want to get done.</p>
        </article>
        <article class="card feature">
            <h3>Find your focus</h3>
            <p class="muted">Decide what matters most and take your day one task at a time.</p>
        </article>
        <article class="card feature">
            <h3>Celebrate progress</h3>
            <p class="muted">Every small step counts. Give yourself credit as you move forward.</p>
        </article>
    </div>
</section>

<section class="card" aria-labelledby="today-heading">
    <div class="card-heading">
        <h2 id="today-heading">Today's Tasks <span class="count"><?php echo e($tasks->count()); ?></span></h2>
        <p class="muted"><?php echo e(today()->format('Y-m-d')); ?> &middot; <a href="<?php echo e(route('tasks.index')); ?>">View all active tasks</a></p>
    </div>
    <?php if($tasks->isEmpty()): ?>
        <div class="empty-state">
            <h3>No tasks for today</h3>
            <p class="muted">Check the Task List for your other plans.</p>
        </div>
    <?php else: ?>
        <div class="table-scroll" role="region" aria-label="Today's tasks" tabindex="0">
            <table>
                <thead>
                    <tr><th scope="col">ID</th><th scope="col">Title</th><th scope="col">Status</th><th scope="col">Task Date</th></tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="muted">#<?php echo e($task->id); ?></td>
                            <td class="task-title"><?php echo e($task->title); ?></td>
                            <td><span class="badge <?php echo e($task->status === 'done' ? 'badge-done' : 'badge-pending'); ?>"><?php echo e(ucfirst($task->status)); ?></span></td>
                            <td class="date-cell"><?php echo e($task->task_date); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\johnm\Downloads\TSA4_proj\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel--main\resources\views/welcome.blade.php ENDPATH**/ ?>