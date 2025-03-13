<!-- Navbar -->
<nav class="mt-[10px]">
    <div class="inner-width flex justify-between items-center px-[10px]">
        <a href="/" class="font-bold">Backend Api</a>
        <ul class="flex justify-content items-center">
            <li class="mr-[4px]">
                <a href="/" class="inline-block border-1 border-gray-500 px-[4px] rounded-[4px] py-[2px] hover:bg-blue-500 hover:text-white <?= $_SERVER['REQUEST_URI'] === '/' ? 'bg-blue-500 text-white' : ''; ?>">Home</a>
            </li>
            <li class="mr-[4px]">
                <a href="/posts" class="inline-block border-1 border-gray-500 px-[4px] rounded-[4px] py-[2px] hover:bg-blue-500 hover:text-white <?= strpos($_SERVER['REQUEST_URI'], '/posts') === 0 ? 'bg-blue-500 text-white' : ''; ?>">Post</a>
            </li>
            <?php if (!(isset($_SESSION['user_id']))): ?>
            <li>
                <a href="/admin/login" class="inline-block border-1 border-gray-500 px-[4px] rounded-[4px] py-[2px] hover:bg-blue-500 hover:text-white <?= $_SERVER['REQUEST_URI'] === '/admin/login' ? 'bg-blue-500 text-white' : ''; ?>">Admin Login</a>
            </li>
            <?php else: ?>
                <li>
                    <a href="#" class="inline-block border-1 border-gray-500 px-[4px] rounded-[4px] py-[2px] hover:bg-blue-500 hover:text-white <?= $_SERVER['REQUEST_URI'] === '/admin/logout' ? 'bg-blue-500 text-white' : ''; ?>" onclick="event.preventDefault(); document.getElementById('logout').submit();">Admin Logout</a>
                    <form action="/admin/logout" method="post" id="logout">
                    </form>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>