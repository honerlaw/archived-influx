<?php

namespace Server\Router;

use \Server\Router\RouteContext;
use \Server\Router\Route;
use \Server\Router\Handler\RouteHandler;

/**
 * A simple router that directs a request uris to a handlers.
 * Multiple handlers per route allows middleware.
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class Router
{

    /**
     * @var array Holds the routes associated with this router
     */
    private $routes;

    /**
     * Initialize a new router
     */
    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * Register a handler that is called for all requests
     *
     * @param string $uri The route's uri for the request
     * @param RouteHandler $handler The handler for the route
     *
     * @return Router
     */
    public function all(string $uri, RouteHandler $handler): self
    {
        return $this->route('*', $uri, $handler);
    }

    /**
     * Register a route for a given handler on the router
     *
     * @param string $method The method for the request
     * @param string $uri The route's uri for the request
     * @param RouteHandler $handler The handler for the route
     *
     * @return Router
     */
    public function route(string $method, string $uri, RouteHandler $handler): self
    {
        $this->routes[] = new Route($method, $uri, $handler);
        return $this;
    }

    /**
     * @return array The array of routes
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    /**
     * Handle the incoming web request and route it appropriately
     * This means creating the RouteContext and passing it through all of the
     * routes and middleware
     *
     * @return void
     */
    public function handle()
    {
        // create the route context (initializing any request data)
        $ctx = new RouteContext();

        // loop through all of the routes
        foreach($this->getRoutes() as $route) {

            // Check if the request data has the same method as the route
            if($ctx->getRequest()->getMethod() === $route->getMethod()) {

                // generate the pattern string to be used for preg match
                $pattern = '/^' . str_replace('/', '\/', $route->getURI()) . '$/';

                // check if the route's pattern matches the request uri
                if(preg_match($pattern, $ctx->getRequest()->getURI(), $params)) {

                    // if it does then we set the params generated from preg_match
                    // and call the handler
                    array_shift($params);
                    $ctx->getRequest()->setParams($params);
                    if($handler->handle($ctx) === true) {
                        break;
                    }
                }
            }
        }
    }

}
