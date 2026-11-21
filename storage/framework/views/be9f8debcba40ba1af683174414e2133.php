<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> | Tasks for Today</title>
</head>
<body>
    <h1>Tasks for Today</h1>
    <a href="<?php echo e(route('welcome')); ?>">Welcome</a> |
    <a href="<?php echo e(route('tasks.index')); ?>">Task List</a>
    <hr>

    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH C:\Users\Hansoy\OneDrive\Documents\GitHub\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel-\resources\views/layouts/main.blade.php ENDPATH**/ ?>