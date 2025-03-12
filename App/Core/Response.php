<?php

namespace App\Core;

/**
 * Class Response
 * 
 * Handles sending HTTP responses.
 */
class Response
{
    /**
     * Send a response to the client.
     *
     * @param string $content The content to send in the response.
     * @return void
     */
    public function send(string $content): void
    {
        echo $content;
    }
}
