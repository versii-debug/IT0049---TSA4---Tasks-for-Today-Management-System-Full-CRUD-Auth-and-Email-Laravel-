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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Hansoy\OneDrive\Documents\GitHub\IT0049---TSA4---Tasks-for-Today-Management-System-Full-CRUD-Auth-and-Email-Laravel-\resources\views/welcome.blade.php ENDPATH**/ ?>