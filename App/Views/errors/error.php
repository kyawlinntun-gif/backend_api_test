<?php view('layouts.header', ['title' => 'Posts']); ?>
<div class="outer-width">
    <div class="content h-screen relative">
        <?php if (!empty($status)): ?>
            <h1 class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%] text-center text-red-500"><?= $message; ?></h1>
        <?php endif; ?>
    </div><!-- /.content -->
</div><!-- /.outer-width -->
<?php view('layouts.footer'); ?>
