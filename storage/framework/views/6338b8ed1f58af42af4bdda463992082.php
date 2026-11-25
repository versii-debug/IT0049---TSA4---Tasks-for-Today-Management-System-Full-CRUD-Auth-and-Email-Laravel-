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
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('tasks.archived')); ?>" <?php if(request()->routeIs('tasks.archived*')): ?> aria-current="page" <?php endif; ?>>Archived Tasks</a>
                <?php endif; ?>
                <a href="<?php echo e(route('profile')); ?>" <?php if(request()->routeIs('profile')): ?> aria-current="page" <?php endif; ?>>Profile</a>
                <a href="<?php echo e(route('about')); ?>" <?php if(request()->routeIs('about')): ?> aria-current="page" <?php endif; ?>>About</a>
                <?php echo $__env->make('partials.auth-navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </nav>
        </div>
    </header>
    <main class="container">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <footer class="site-footer">&copy; <?php echo e(date('Y')); ?> Tasks for Today. One task at a time.</footer>
</body>
</html>
<?php /**PATH C:\Users\johnm\Downloads\TSA4_proj\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel--main\resources\views/layouts/main.blade.php ENDPATH**/ ?>