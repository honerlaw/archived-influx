<?php

namespace Server\Http;

/**
 * Stores / reads all of the data associated with a request
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class Request
{

    /**
     * @return string The request method
     */
    public function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return string The request uri
     */
    public function getURI(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

}
