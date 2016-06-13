<?php

namespace Server\Router\Handler;

use \Server\Router\RouteContext;

/**
 * Represents a handler that is called for a given route
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
abstract class RouteHandler
{

    /**
     * Handles a given route request
     *
     * @param RouteContext $ctx The route context
     *
     * @return bool|null If true further routes are ignored
     */
    public abstract function handle(RouteContext $ctx);

}
