<?php

namespace Server\Router;

use \Server\DI\Injectable;
use \Server\Http\Request;

/**
 * Context used for routing, contains data associated with a route
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class RouteContext extends Injectable
{

    /**
     * @var array The array of data that is stored on the context
     */
    private $data;

    /**
     * @var Request The request object containing request data
     */
    private $request;

    /**
     * Initialize the RouteContext
     */
    public function __construct()
    {
        $this->data = [];
        $this->request = new Request();
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Store a value on the context to be used later
     *
     * @param string $key The key for the value
     * @param mixed $value The value to store
     *
     * @return RouteContext
     */
    public function set(string $key, $value): self
    {
        $this->data[$key] = $value;
    }

    /**
     * Get data that is stored in the context
     *
     * @param string $key The key for the data
     *
     * @return mixed|null
     */
    public function get(string $key)
    {
        if(array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return null;
    }

}
