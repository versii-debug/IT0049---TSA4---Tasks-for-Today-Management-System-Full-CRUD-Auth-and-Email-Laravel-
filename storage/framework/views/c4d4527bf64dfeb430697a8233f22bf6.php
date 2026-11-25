<?php $__env->startSection('title', 'Profile'); ?>

<?php $__env->startSection('content'); ?>
<h1>Profile</h1>

<?php if($user === null): ?>
    <p class="muted">No user found.</p>
<?php else: ?>
    <section class="card">
        <div class="card-heading">
            <h2><?php echo e($user->name); ?></h2>
            <p>ID: <?php echo e($user->id); ?></p>
            <p>Email: <?php echo e($user->email); ?></p>
            <p>Created At: <?php echo e($user->created_at?->format('Y-m-d H:i:s')); ?></p>
        </div>
    </section>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\johnm\Downloads\TSA4_proj\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel--main\resources\views/profile/index.blade.php ENDPATH**/ ?>