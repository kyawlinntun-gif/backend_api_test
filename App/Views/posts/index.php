<?php view('layouts.header', ['title' => 'Posts']); ?>
<div class="outer-width">
    <!-- Navbar -->
    <?php view('layouts.navbar'); ?>
    <!-- End Navbar -->
    <div class="content <?= isset($data['status']) && empty($data['posts']) ? 'h-[90vh] relative' : ''; ?>">
        <div class="inner-width px-[10px]">
            <?php if (isset($_SESSION['post']['success'])): ?>
                <div class="text-center bg-green-500 rounded-md text-white py-[4px] px-[8px] my-[20px]">
                    <?= $_SESSION['post']['success']; ?>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['post']['success']); ?>
            <?php if (isset($_SESSION['post']['fail'])): ?>
                <div class="text-center bg-red-500 rounded-md text-white py-[4px] px-[8px] my-[20px]">
                    <?= $_SESSION['post']['fail']; ?>
                </div>
            <?php endif; ?>
            <?php unset($_SESSION['post']['fail']); ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/posts/create" class="inline-block border-1 border-green-500 bg-green-500 text-white rounded-md px-[8px] py-[4px] mt-[20px]">Create Post</a>
            <?php endif; ?>
            <?php if (isset($data['status']) && empty($data['posts'])): ?>
                <h1 class="absolute top-[50%] left-[50%] translate-x-[-50%] translate-y-[-50%]"><?= $data['message']; ?></h1>
            <?php endif; ?>
            <?php if (isset($data['status']) && count($data['posts']) > 0): ?>
                <ul class="flex flex-wrap justify-between mt-[20px]">
                    <?php foreach ($data['posts'] as $post): ?>
                        <li class="border-1 w-[32%] p-[10px] mb-[10px] rounded-md">
                            <h1>UserId: <?= $post['userId']; ?></h1>
                            <h2>
                                <a href="/posts/<?= $post['id']; ?>" class="underline text-blue-500 hover:text-blue-950">Id: <?= $post['id']; ?></a>
                            </h2>
                            <h3 class="text-[20px] font-semibold">
                                <span>Title:</span>
                                <span class="block indent-[20px]"><?= $post['title'] ?></span>
                            </h3>
                            <p>
                                Body:
                                <span class="indent-[20px] block"><?= $post['body'] ?></span>
                            </p>
                            <?php if (isset($_SESSION['user_id'])): ?>
                            <div class="mt-[20px] flex flex-wrap justify-between">
                                <a href="/posts/<?= $post['id'] ?>/edit" class="border-1 border-yellow-500 rounded-md bg-yellow-500 text-white px-[8px] py-[4px] hover:bg-transparent hover:text-yellow-500">Edit</a>
                                <a href="#" class="border-1 border-red-500 rounded-md bg-red-500 text-white px-[8px] py-[4px] hover:bg-transparent hover:text-red-500" onclick="event.preventDefault(); document.getElementById('delete<?= $post['id']; ?>').submit();">Delete</a>
                                <form action="/posts/<?= $post['id']?>/delete" class="hidden" method="post" id="delete<?= $post['id']; ?>">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>
                            </div>
                            <?php endif; ?>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <!-- Pagination Links -->
                <?php if ($data['pagination']->hasPages()): ?>
                    <ul class="flex flex-wrap my-[20px] justify-center">
                        <?php
                        $queryParams = $_GET;
                        unset($queryParams['page']); // Remove any existing 'page' parameter
                        $currentPage = $data['pagination']->currentPage();
                        $lastPage = $data['pagination']->lastPage();

                        $startPage = max(1, $currentPage - 2);
                        $endPage = min($lastPage, $currentPage + 2);
                        ?>

                        <!-- Previous -->
                        <?php if (!$data['pagination']->onFirstPage()): ?>
                            <li>
                                <a href="?<?= http_build_query(array_merge($queryParams, ['page' => $data['pagination']->currentPage() - 1])); ?>" class="border-1 px-[8px] py-[4px] rounded-md mr-[4px] hover:bg-[#00f] hover:text-white">
                                    Prev
                                </a>
                            </li>
                        <?php endif; ?>

                        <!-- Page Numbers -->
                        <?php for($i = $startPage; $i <= $endPage; $i++): ?>
                            <li>
                                <a href="?<?= http_build_query(array_merge($queryParams, ['page' => $i])); ?>" class="border-1 px-[8px] py-[4px] rounded-md mr-[4px] <?= $i == $currentPage ? 'active' : ''; ?> hover:bg-[#00f] hover:text-white"><?= $i; ?></a>
                            </li>
                        <?php endfor; ?>

                        <!-- Next -->
                        <?php if ($data['pagination']->hasMorePages()): ?>
                            <li>
                                <a href="?<?= http_build_query(array_merge($queryParams, ['page' => $data['pagination']->currentPage() + 1])); ?>" class="border-1 px-[8px] py-[4px] rounded-md hover:bg-[#00f] hover:text-white">
                                    Next
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>

                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div><!-- /.content -->
</div><!-- /.outer-width -->
<?php view('layouts.footer'); ?>
