<?php

namespace Server\Service\Router;

use \Server\Net\Request;
use \Server\Net\Response;
use \Server\Service\View;

/**
 * Context used for routing, contains data associated with a route
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class RouteContext
{

    /**
     * @var array The array of data that is stored on the context
     */
    private $data;

    /**
     * @var resource The client socket
     */
    private $socket;

    /**
     * @var Request The request object containing request data
     */
    private $request;

    /**
     * @var Response The response object containing response data
     */
    private $response;

    /**
     * @var View The view object to render views
     */
    private $view;

    /**
     * @var Route The current route that is being handled
     */
    private $route;

    /**
     * Initialize the RouteContext
     */
    public function __construct($socket, Request $request, Response $response)
    {
        $this->data = [];
        $this->socket = $socket;
        $this->request = $request;
        $this->response = $response;
        $this->view = new View($this);
    }

    /**
     * @return resource The client socket
     */
    public function getSocket()
    {
        return $this->socket;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return View
     */
    public function getView(): View
    {
        return $this->view;
    }

    /**
     * Set the current route
     *
     * @param Route $route The current route
     *
     * @return RouteContext
     */
    public function setRoute(Route $route): self
    {
        $this->route = $route;
        return $this;
    }

    /**
     * Get the current route
     *
     * @return Route|null
     */
    public function getRoute()
    {
        return $this->route;
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
        return $this;
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
