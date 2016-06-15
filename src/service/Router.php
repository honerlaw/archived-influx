<?php

namespace Server\Service;

use \Server\Service\Router\RouteContext;
use \Server\Service\Router\Route;
use \Server\Service\Router\Handler\RouteHandler;

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
    public function __construct($routes = [])
    {
        $this->routes = [];
        if(empty($routes) === false) {
            foreach($routes as $route) {
                $this->routes[] = new Route($route->method, $route->uri, new $route->class(), isset($route->view) ? $route->view : null);
            }
        }
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
     * @return Response|null
     */
    public function handle(RouteContext $ctx)
    {
        // loop through all of the routes
        foreach($this->getRoutes() as $route) {

            // Check if the request data has the same method as the route
            if($route->getMethod() === '*' || $ctx->getRequest()->getMethod() === $route->getMethod()) {

                // generate the pattern string to be used for preg match
                $pattern = '/^' . str_replace('/', '\/', $route->getURI()) . '$/';

                // check if the route's pattern matches the request uri
                if(preg_match($pattern, $ctx->getRequest()->getURI(), $params)) {

                    // set the current route that is being handled
                    $ctx->setRoute($route);

                    // if it does then we set the params generated from preg_match
                    // and call the handler
                    array_shift($params);
                    $ctx->getRequest()->setParams($params);
                    $resp = $route->getHandler()->handle($ctx);
                    if($resp !== null) {
                        return $resp;
                    }
                }
            }
        }
        return null;
    }

}
