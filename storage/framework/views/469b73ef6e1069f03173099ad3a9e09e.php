<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Tasks for Today — a simpler way to organize your day and focus on what matters.">
    <title>Welcome | Tasks for Today</title>
    <style>
        :root { color-scheme: dark; font-family: 'Segoe UI', system-ui, sans-serif; color: #f3f5f3; background: #000; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: flex; flex-direction: column; }
        a { color: inherit; }
        .container { width: min(100% - 48px, 1040px); margin-inline: auto; }
        header { display: flex; align-items: center; justify-content: space-between; gap: 24px; padding-block: 28px; }
        .brand { display: inline-flex; align-items: center; gap: 10px; font-size: 17px; font-weight: 700; text-decoration: none; }
        .mark { display: grid; place-items: center; width: 32px; height: 32px; border-radius: 10px; background: #28724f; color: white; }
        nav { display: flex; align-items: center; gap: 20px; font-size: 14px; }
        nav a { text-decoration: none; }
        nav a:hover { text-decoration: underline; }
        main { flex: 1; }
        .hero { max-width: 720px; margin-inline: auto; padding: 90px 0 72px; text-align: center; }
        .eyebrow { color: #7cdaa2; font-size: 12px; font-weight: 700; letter-spacing: .16em; text-transform: uppercase; }
        h1 { margin: 20px 0; font-size: clamp(38px, 6vw, 64px); line-height: 1.12; letter-spacing: -.045em; font-weight: 650; }
        .intro { max-width: 490px; margin: 0 auto; color: #a8b3ab; font-size: 18px; line-height: 1.7; }
        .button { display: inline-flex; align-items: center; justify-content: center; gap: 16px; margin-top: 30px; padding: 14px 24px; border-radius: 8px; background: #28724f; color: white; font-weight: 600; text-decoration: none; }
        .button:hover { background: #1d583c; }
        a:focus-visible { outline: 3px solid #aa7a27; outline-offset: 5px; }
        .features { padding-bottom: 64px; scroll-margin-top: 30px; }
        .features h2 { margin: 0 0 24px; text-align: center; font-size: 21px; letter-spacing: -.02em; }
        .grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
        .feature { padding: 28px; border: 1px solid #29332c; border-radius: 12px; background: #111713; }
        .number { color: #7cdaa2; font-size: 13px; font-weight: 700; }
        h3 { margin: 18px 0 10px; font-size: 18px; }
        .feature p { margin: 0; color: #a8b3ab; font-size: 14px; line-height: 1.7; }
        footer { padding: 24px 0; border-top: 1px solid #29332c; color: #a8b3ab; text-align: center; font-size: 13px; }
        @media (max-width: 640px) {
            .container { width: calc(100% - 32px); }
            header { flex-wrap: wrap; padding-block: 20px; }
            nav { gap: 14px; }
            .hero { padding: 56px 0; }
            .intro { font-size: 16px; }
            .grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header class="container">
        <a class="brand" href="<?php echo e(url('/')); ?>"><span class="mark" aria-hidden="true">&#10003;</span> Tasks for Today</a>
        <nav aria-label="Main navigation">
            <a href="<?php echo e(route('tasks.index')); ?>">Task List</a>
            <a href="#features">About</a>
            <?php if(Route::has('login')): ?>
                <a href="<?php echo e(route('login')); ?>">Log in</a>
            <?php endif; ?>
            <?php if(Route::has('register')): ?>
                <a href="<?php echo e(route('register')); ?>">Sign up</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">
        <section class="hero" aria-labelledby="welcome-heading">
            <p class="eyebrow">A little focus. A better day.</p>
            <h1 id="welcome-heading">Make room for what<br>matters today.</h1>
            <p class="intro">Welcome to Tasks for Today. Keep your plans in one place, take things one step at a time, and enjoy a little more clarity.</p>
            <?php if(Route::has('dashboard') && auth()->check()): ?>
                <a class="button" href="<?php echo e(route('dashboard')); ?>">Go to dashboard <span aria-hidden="true">&rarr;</span></a>
            <?php elseif(Route::has('register')): ?>
                <a class="button" href="<?php echo e(route('register')); ?>">Get started <span aria-hidden="true">&rarr;</span></a>
            <?php elseif(Route::has('login')): ?>
                <a class="button" href="<?php echo e(route('login')); ?>">Get started <span aria-hidden="true">&rarr;</span></a>
            <?php else: ?>
                <a class="button" href="#features">Explore the idea <span aria-hidden="true">&darr;</span></a>
            <?php endif; ?>
        </section>

        <section class="features" id="features" aria-labelledby="features-heading">
            <h2 id="features-heading">A simpler approach to your day</h2>
            <div class="grid">
                <article class="feature">
                    <span class="number" aria-hidden="true">01</span>
                    <h3>Clear your mind</h3>
                    <p>Start with a simple list of the things you want to get done.</p>
                </article>
                <article class="feature">
                    <span class="number" aria-hidden="true">02</span>
                    <h3>Find your focus</h3>
                    <p>Decide what matters most and take your day one task at a time.</p>
                </article>
                <article class="feature">
                    <span class="number" aria-hidden="true">03</span>
                    <h3>Celebrate progress</h3>
                    <p>Every small step counts. Give yourself credit as you move forward.</p>
                </article>
            </div>
        </section>
    </main>

    <footer>&copy; <?php echo e(date('Y')); ?> Tasks for Today. One task at a time.</footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Laravel\TSA4\resources\views/welcome.blade.php ENDPATH**/ ?>