<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title'); ?> | Tasks for Today</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/tasks.css')); ?>">
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="brand" href="<?php echo e(route('welcome')); ?>">Tasks for Today<span>.</span></a>
            <nav aria-label="Main navigation">
                <a href="<?php echo e(route('welcome')); ?>" <?php if(request()->routeIs('welcome')): ?> aria-current="page" <?php endif; ?>>Home</a>
                <a href="<?php echo e(route('tasks.index')); ?>" <?php if(request()->routeIs('tasks.index')): ?> aria-current="page" <?php endif; ?>>Task List</a>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer class="site-footer">&copy; <?php echo e(date('Y')); ?> Tasks for Today. One task at a time.</footer>
</body>
</html>
<?php /**PATH C:\Users\Hansoy\OneDrive\Documents\GitHub\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel-\resources\views/layouts/main.blade.php ENDPATH**/ ?>