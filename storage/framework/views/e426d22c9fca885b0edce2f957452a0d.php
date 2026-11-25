<?php $__env->startSection('title', 'Create Task'); ?>

<?php $__env->startSection('content'); ?>
<h2>Create Task</h2>

<form method="POST" action="<?php echo e(route('tasks.store')); ?>">
    <?php echo csrf_field(); ?>
    <p>
        <label for="title">Title</label><br>
        <input id="title" name="title" type="text" maxlength="150" value="<?php echo e(old('title')); ?>" required>
        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </p>
    <p>
        <label for="task_date">Date</label><br>
        <input id="task_date" name="task_date" type="date" value="<?php echo e(old('task_date')); ?>" required>
        <?php $__errorArgs = ['task_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </p>
    <p>
        <label for="status">Status</label><br>
        <select id="status" name="status" required>
            <option value="pending" <?php echo e(old('status', 'pending') === 'pending' ? 'selected' : ''); ?>>pending</option>
            <option value="done" <?php echo e(old('status') === 'done' ? 'selected' : ''); ?>>done</option>
        </select>
        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </p>
    <button type="submit">Create Task</button>
    <a href="<?php echo e(route('tasks.index')); ?>">Cancel</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Laravel\TSA4\resources\views/tasks/create.blade.php ENDPATH**/ ?>