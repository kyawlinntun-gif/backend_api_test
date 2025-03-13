<?php view('layouts.header', ['title' => 'Posts Show']); ?>
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
                <ul class="flex flex-wrap justify-center mt-[40px]">
                    <li class="border-1 w-[50%] p-[10px] mb-[10px] rounded-md">
                        <h1>UserId: <?= $data['post']['userId']; ?></h1>
                        <h2>
                            <a href="/posts/<?= $data['post']['id']; ?>" class="underline text-blue-500">Id: <?= $data['post']['id']; ?></a>
                        </h2>
                        <h3 class="text-[20px] font-semibold">
                            <span>Title:</span>
                            <span class="block indent-[20px]"><?= $data['post']['title'] ?></span>
                        </h3>
                        <p>
                            Body:
                            <span class="indent-[20px] block"><?= $data['post']['body'] ?></span>
                        </p>
                        <a href="/posts" class="inline-block bg-gray-500 text-white px-[6px] py-[3px] rounded-md hover:bg-transparent hover:border-1 hover:border-blue-500 hover:text-blue-500 mt-[20px]">Back</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div><!-- /.content -->
</div><!-- /.outer-width -->
<?php view('layouts.footer'); ?>