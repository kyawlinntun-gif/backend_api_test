<?php

namespace App\Models;

use GuzzleHttp\Client;

/**
 * Class Post
 * 
 * Represents the Post API Data for interacting with the JSONPlaceholder API Data Server.
 */
class Post
{
    /**
     * @var Client Guzzle HTTP clent instance for making API requests.
     */
    private Client $client;

    /**
     *
     * @var string Base URL for the JSONPlaceholder posts API.
     */
    private string $apiUrl = 'https://jsonplaceholder.typicode.com/posts';

    /**
     * PostService constructor.
     * Initializes the Guzzle HTTP client.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Makes an HTTP request to the API.
     *
     * @param string $method HTTP method (GET, POST, PUT, PATCH, DELETE).
     * @param string $url API endpoint URL.
     * @param array $data Optional data payload for POST, PUT, PATCH request.
     * @return array Associative array containing the response status and data or error message.
     */
    public function makeRequest(string $method, string $url, array $data = []): array
    {
        try {
            $options = empty($data) ? [] : ['json' => $data];
            $response = $this->client->request($method, $url, $options);

            return [
                'status' => 'success',
                'data' => json_decode($response->getBody()->getContents(), true)
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Unexpected error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Fetches all posts.
     *
     * @return array List of posts or an error message.
     */
    public function getAllPosts(): array
    {
        $response = $this->makeRequest('GET', $this->apiUrl);
        if ($response['status'] === 'success') {
            // Sort posts by Id in descending order
            usort($response['data'], fn($a, $b) => $b['id'] <=> $a['id']);
        }
        return $response;
    }

    /**
     * Fetches a single post by ID.
     *
     * @param integer $postId The ID of the post.
     * @return array The post details or an error message
     */
    public function getPost(int $postId): array
    {
        return $this->makeRequest('GET', "$this->apiUrl/$postId");
    }

    /**
     * Creates a new post.
     *
     * @param array $post Associative array with 'title', 'body', and 'userId.
     * @return array The created post details or an error message.
     */
    public function create(array $post): array
    {
        return $this->makeRequest('POST', $this->apiUrl, $post);
    }

    /**
     * Updates an existing post.
     * 
     * @param int  $di The ID of the post to update.
     * @param array $post Updated post data (title, body, userId).
     * @return array The updated post details or an error message.
     */
    public function update(int $id, array $post): array
    {
        return $this->makeRequest('PUT', '$this->apiUrl/$id', $post);
    }

    /**
     * Deletes a post by ID.
     * 
     * @param int $id The ID of the post to delete.
     * @return array Success or error message
     */
    public function delete(int $id): array
    {
        return $this->makeRequest('DELETE', "$this->apiUrl/$id");
    }
}
