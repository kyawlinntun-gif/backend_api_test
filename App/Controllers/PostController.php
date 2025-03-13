<?php

namespace App\Controllers;

use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Core\Request;
use App\Validator\Validator;

/**
 * Class PostController
 * 
 * This controller handles requests related to the home page.
 */
class PostController
{
    /**
     * PostController constructor.
     * 
     * Initializes any dependencies or setup required for the home page.
     */
    public function __construct()
    {
        // Constructor logic
    }

    /**
     * Display the post page with Posts API Data.
     */
    public function index()
    {
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = 10;
        
        // Fetch posts using the getAllPosts method
        $post = new Post();
        $result = $post->getAllPosts();

        // Check if the API Call failed
        if ($result['status'] === 'error') {
            // Display the error message
            return view('errors.error', [
                'status' => 'error',
                'message' => $result['message']
            ]);
        }

        // Get the posts from the result
        $posts = $result['data'];
        // $posts = [];

        // Check if there are no posts
        if (empty($posts)) {
            
            $data = [
                'status' => 'success',
                'message' => 'Data not found.',
                'posts' => []
            ];

            return view('posts.index', [
                'data' => $data
            ]);
        }

        // Paginate posts
        $total = count($posts);
        $offset = ($page - 1) * $perPage;
        $paginatedPosts = array_slice($posts, $offset, $perPage);

        $paginator = new LengthAwarePaginator($paginatedPosts, $total, $perPage, $page, [
            'path' => $_SERVER['REQUEST_URI']
        ]);
        
        $data = [
            'status' => 'success',
            'posts' => $paginator->items(),
            'pagination' => $paginator, 
        ];

        return view('posts.index', [
            'data' => $data
        ]);
    }

    /**
     * Show a single post.
     * 
     * @param int $id
     */
    public function show(int $id)
    {
        
        // Fetch posts using the getPost method
        $post = new Post();
        $result = $post->getPost($id);

        // Check if the API Call failed
        if ($result['status'] === 'error') {
            // Display the error message
            return view('errors.error', [
                'status' => 'error',
                'message' => $result['message']
            ]);
        }

        // Get the post from the result
        $post = $result['data'];
        // $post = '';

        // Check if there are not exist post
        if (empty($post)) {
            
            $data = [
                'status' => 'success',
                'message' => 'Data not found.',
                'post' => ''
            ];

            return view('posts.show', [
                'data' => $data
            ]);
        }
        
        $data = [
            'status' => 'success',
            'post' => $post,
        ];

        return view('posts.show', [
            'data' => $data
        ]);
    }

    /**
     * Show post creation form.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a new post.
     * 
     * @param Request $request
     */
    public function store(Request $request)
    {
        // Get input data from the request
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'userId' => $_SESSION['user_id']
        ];
        // Validation rules
        $rules = [
            'title' => 'required|string|min:3',
            'body' => 'required|string|min:10'
        ];
        // Initialize the validator
        $validator = new Validator($data);
        // Run validation
        if (!$validator->validate($rules)) {
            // Store errors in session
            $_SESSION['errors']['post'] = $validator->getErrors();
            $_SESSION['post'] = $data;
            // Redirect back to the registration form
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        // Store post data in JSONPlaceholder Api
        $post = new Post();
        if ($post->create($data)) {
            $_SESSION['post']['success'] = "Post was created successfully!";
            header("Location: " . '/posts');
            exit;
        }
        $_SESSION['post']['fail'] = "Post can't be created!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    /**
     * Show post editing form.
     * 
     * @param int $id
     */
    public function edit(int $id)
    {
        
        // Fetch posts using the getPost method
        $post = new Post();
        $result = $post->getPost($id);

        // Check if the API Call failed
        if ($result['status'] === 'error') {
            // Display the error message
            return view('errors.error', [
                'status' => 'error',
                'message' => $result['message']
            ]);
        }

        // Get the post from the result
        $post = $result['data'];
        // $post = '';

        // Check if there are not exist post
        if (empty($post)) {
            
            $data = [
                'status' => 'success',
                'message' => 'Data not found.',
                'post' => ''
            ];

            return view('posts.edit', [
                'data' => $data
            ]);
        }
        
        $data = [
            'status' => 'success',
            'post' => $post,
        ];

        return view('posts.edit', [
            'data' => $data
        ]);
    }

    /**
     * Update an existing post.
     * 
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, int $id)
    {
        // Get input data from the request
        $data = [
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'userId' => $_SESSION['userId']
        ];
        // Validation rules
        $rules = [
            'title' => 'required|string|min:3',
            'body' => 'required|string|min:10'
        ];
        // Initialize the validator
        $validator = new Validator($data);
        // Run validation
        if (!$validator->validate($rules)) {
            // Store errors in session
            $_SESSION['errors']['post'] = $validator->getErrors();
            $_SESSION['post'] = $data;
            // Redirect back to the registration form
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit;
        }
        // Update post data in JSONPlaceholder Api
        $post = new Post();
        if ($post->update($id, $data)) {
            $_SESSION['post']['success'] = "Post Id $id was updated successfully!";
            header("Location: " . '/posts');
            exit;
        }
        $_SESSION['post']['fail'] = "Post can't be updated!";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }

    /**
     * Delete a post.
     * 
     * @param int $id
     */
    public function destroy(int $id)
    {
        $post = new Post();
        if ($post->delete($id)) {
            $_SESSION['post']['success'] = "Post Id $id was deleted successfully!";
            header("Location: " . '/posts');
            exit;
        }
        $_SESSION['post']['fail'] = "Post can't be deleted!";
        header("Location: " . '/posts');
        exit;
    }
}
