<?php $__env->startSection('title', 'Log in'); ?>

<?php $__env->startSection('content'); ?>
<h1>Welcome back</h1>
<p class="muted">Log in to manage today's tasks.</p>

<?php if(session('status')): ?>
    <p class="alert" role="status"><?php echo e(session('status')); ?></p>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('login.store')); ?>">
    <?php echo csrf_field(); ?>
    <p>
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" maxlength="255" value="<?php echo e(old('email')); ?>" autocomplete="username" required autofocus <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="email-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span id="email-error" role="alert"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </p>
    <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password" maxlength="255" autocomplete="current-password" required <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> aria-invalid="true" aria-describedby="password-error" <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span id="password-error" role="alert"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </p>
    <button type="submit">Log in</button>
    <a href="<?php echo e(route('register')); ?>">Create an account</a>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hansoy\OneDrive\Documents\GitHub\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel-\resources\views/auth/login.blade.php ENDPATH**/ ?>