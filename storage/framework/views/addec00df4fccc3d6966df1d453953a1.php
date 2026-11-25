<?php if(auth()->guard()->check()): ?>
    <span class="nav-user"><?php echo e(auth()->user()->name); ?></span>
    <form method="POST" action="<?php echo e(route('logout')); ?>">
        <?php echo csrf_field(); ?>
        <button type="submit" class="nav-logout">Log out</button>
    </form>
<?php else: ?>
    <a class="nav-login" href="<?php echo e(route('login')); ?>" <?php if(request()->routeIs('login')): ?> aria-current="page" <?php endif; ?>>Log in</a>
    <a href="<?php echo e(route('register')); ?>" <?php if(request()->routeIs('register')): ?> aria-current="page" <?php endif; ?>>Register</a>
<?php endif; ?>
<?php /**PATH C:\Users\johnm\Downloads\TSA4_proj\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel--main\resources\views/partials/auth-navigation.blade.php ENDPATH**/ ?>