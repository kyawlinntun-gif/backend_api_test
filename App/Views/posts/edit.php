<?php
$errors = isset($_SESSION['errors']['post']) ? $_SESSION['errors']['post'] : '';
$post = isset($_SESSION['post']) ? $_SESSION['post'] : $data['post'];
?>
<?php view('layouts.header', ['title' => 'Posts Edit']); ?>
<div class="outer-width">
    <!-- Navbar -->
    <?php view('layouts.navbar'); ?>
    <!-- End Navbar -->
    <div class="content <?= isset($data['status']) && empty($data['post']) ? 'h-[90vh] relative' : ''; ?>">
        <div class="inner-width px-[10px]">
            <?php if (isset($data['status']) && empty($data['post'])): ?>
                <h1 class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]"><?= $data['message']; ?></h1>
            <?php endif; ?>
            <?php if (isset($data['status']) && !empty($data['post'])): ?>
                <div class="w-[50%] border-1 rounded-md m-auto mt-[60px] px-[16px] py-[8px]">
                    <?php if (isset($_SESSION['post']['fail'])): ?>
                        <div class="text-center bg-red-500 rounded-md text-white py-[2px] px-[4px] mb-[20px]">
                            <?= $_SESSION['post']['fail']; ?>
                        </div>
                    <?php endif; ?>
                    <?php unset($_SESSION['post']['fail']); ?>
                    <h1 class="text-[24px] font-semibold mb-[20px]">Edit Post</h1>
                    <form action="/posts/<?= $data['post']['id'] ?>" method="post">
                        <input type="hidden" name="_method" value="put" >
                        <div class="mb-[10px]">
                            <label for="title">Title:</label>
                            <input type="text" name="title" id="title" class="block w-full border-1 rounded-md px-[4px] py-[2px] mt-[5px]" value="<?= isset($post['title']) ? $post['title'] : ''; ?>">
                            <?php if(isset($errors['title'])): ?>
                                <span class="inline-block text-red-500 text-sm mt-2"><?= $errors['title'][0]; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mb-[10px]">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" class="block border-1 px-[4px] w-full rounded-md mt-[5px] min-h-[200px]"><?= isset($post['body']) ? $post['body'] : ''; ?></textarea>
                            <?php if(isset($errors['body'])): ?>
                                <span class="inline-block text-red-500 text-sm mt-2"><?= $errors['body'][0]; ?></span>
                            <?php endif; ?>
                            <?php unset($_SESSION['post']); ?>
                            <?php unset($_SESSION['errors']['post']); ?>
                        </div>
                        <div class="mb-[10px] flex flex-wrap justify-between items-center">
                            <div>
                                <input type="submit" value="Edit" class="inline-block border-1 border-yellow-500 text-white bg-yellow-500 rounded-md px-[8px] py-[4px] hover:bg-transparent hover:text-yellow-500 cursor-pointer">
                            </div>
                            <a href="/posts" class="inline-block bg-gray-500 text-white px-[8px] py-[4px] rounded-md hover:bg-transparent hover:border-1 hover:border-blue-500 hover:text-blue-500">Back</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div><!-- /.content -->
</div><!-- /.outer-width -->
<?php view('layouts.footer'); ?>