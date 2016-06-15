<?php

namespace Server\Service;

use \Server\Application;
use \Server\Service\Router\RouteContext;

/**
 * Represents a single view (php page)
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class View
{

    /**
     * @var RouteContext The route context for the view
     */
    private $ctx;

    /**
     * @var string The path to the views directory
     */
    private $viewDir;

    /**
     * Initialize a new view
     *
     * @param RouteContext $ctx The route context for the request calling this view
     */
    public function __construct(RouteContext $ctx)
    {
        $this->ctx = $ctx;
        $this->viewDir = Application::getConfig()->viewDir;
    }

    /**
     * Render the view
     *
     * @return string|null If null, no view was found to render
     */
    public function render()
    {
        // check if there is a view for this route
        if($this->ctx->getRoute()->getView() === null) {
            return null;
        }

        // if there is check that it exists
        $path = realpath($this->viewDir . DIRECTORY_SEPARATOR . $this->ctx->getRoute()->getView());
        if($path === false || !file_exists($path)) {
            return null;
        }

        // include the contents and execute it to get the output
        ob_start();
        include $path;
        $contents = ob_get_contents();
        ob_end_clean();

        // return the contents
        return $contents;
    }

    /**
     * Used to include another view inside of a view
     *
     * @param string $viewPath The relative path to the view to include
     */
    public function include($viewPath)
    {
        $path = realpath($this->viewDir . DIRECTORY_SEPARATOR . $viewPath);
        if($path !== false && file_exists($path)) {
            include $path;
        }
    }

}
