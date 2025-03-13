<?php
$errors = isset($_SESSION['errors']['login']) ? $_SESSION['errors']['login'] : '';
?>
<?php view('layouts.header', ['title' => 'Login']); ?>
<div class="outer-width">
    <!-- Navbar -->
    <?php view('layouts.navbar'); ?>
    <!-- End Navbar -->
    <div class="content">
        <div class="inner-width">
            <div class="border-1 w-[50%] m-auto mt-[40px] rounded-md p-[10px]">
                <?php if (isset($_SESSION['login']['fail'])): ?>
                    <div class="text-center bg-red-500 rounded-md text-white py-[2px] px-[4px] mb-[20px]">
                        <?= $_SESSION['login']['fail']; ?>
                    </div>
                <?php endif; ?>
                <?php unset($_SESSION['login']['fail']); ?>
                <h1 class="text-[24px] mb-[20px]">Login</h1>
                <form action="/admin/login" method="post">
                    <div class="mb-[10px]">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="border-1 block w-full rounded-md py-[2px] px-[4px] mt-[4px]" value="<?= isset($_SESSION['login']['email']) ? $_SESSION['login']['email'] : '';?>">
                        <?php unset($_SESSION['login']['email']); ?>
                        <?php if(isset($errors['email'])): ?>
                            <span class="inline-block text-red-500 text-sm mt-2"><?= $errors['email'][0]; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="mb-[10px]">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="border-1 block w-full rounded-md py-[2px] px-[4px] mt-[4px]">
                        <?php if(isset($errors['password'])): ?>
                            <span class="inline-block text-red-500 text-sm mt-2"><?= $errors['password'][0]; ?></span>
                        <?php endif; ?>
                        <?php unset($_SESSION['errors']['login']); ?>
                    </div>
                    <div>
                        <input type="submit" value="Login" class="inline-block border-1 border-blue-500 bg-blue-500 text-white py-[4px] px-[8px] rounded-md cursor-pointer hover:bg-transparent hover:text-blue-500">
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.content -->
</div><!-- /.outer-width -->
<?php view('layouts.footer'); ?>