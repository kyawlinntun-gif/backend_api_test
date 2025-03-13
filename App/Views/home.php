<?php view('layouts.header', ['title' => 'Home']); ?>
<div class="outer-width">
    <!-- Navbar -->
    <?php view('layouts.navbar'); ?>
    <!-- End Navbar -->
    <div class="content h-[90vh] relative">
        <h1 class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]">Welcome to home page</h1>
    </div><!-- /.content -->
</div><!-- /.outer-width -->    
<?php view('layouts.footer'); ?>
