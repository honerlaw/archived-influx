<?php

namespace Server\Service\Router;

use \Server\Service\Router\Handler\RouteHandler;

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
     * @var string The view's file name relative to the views directory
     */
    private $view;

    /**
     * Initialize the route
     *
     * @param string $method The route method
     * @param string $uri The route's uri
     * @param RouteHandler $handle The route handler
     * @param string $view The route's view (optional)
     */
    public function __construct(string $method, string $uri, RouteHandler $handler, $view = null)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->handler = $handler;
        $this->view = $view;
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

    /**
     * @return string|null The route's view (if it has one)
     */
    public function getView()
    {
        return $this->view;
    }

}
