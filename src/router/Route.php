<?php

namespace Server\Router;

use \Server\Router\Handler\RouteHandler;

/**
 * Represents a route in the application
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
final class Route
{

    /**
     * @var string The method for the route (GET, POST, PUT, DELETE, etc)
     */
    private $method;

    /**
     * @var string The route's uri
     */
    private $uri;

    /**
     * @var RouteHandler The handler for the route
     */
    private $handler;

    /**
     * Initialize the route
     *
     * @param string $method The route method
     * @param string $uri The route's uri
     * @param RouteHandler $handle The route handler
     */
    public function __construct(string $method, string $uri, RouteHandler $handler)
    {
        $this->method = $method;
        $this->route = $uri;
        $this->handler = $handler;
    }

    /**
     * @return string The route method
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string The route's uri
     */
    public function getURI(): string
    {
        return $this->uri;
    }

    /**
     * @return RouteHandler The route handler
     */
    public function getHandler(): RouteHandler
    {
        return $this->handler;
    }

}
