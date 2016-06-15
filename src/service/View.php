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

    private $viewDir;
    private $ctx;

    public function __construct(RouteContext $ctx)
    {
        $this->viewDir = Application::getConfig()->viewDir;
        $this->ctx = $ctx;
    }

    /**
     * Render the view
     *
     * @return string
     */
    public function render()
    {
        // check if there is a view for this route
        if($this->ctx->getRoute()->getView() === null) {
            return null;
        }

        // if there is check that it exists
        $path = realpath($this->viewDir . DIRECTORY_SEPARATOR . $this->ctx->getRoute()->getView());
        if(!file_exists($path)) {
            return null;
        }

        // include the contents to execute it and get the output
        ob_start();
        include $path;
        $contents = ob_get_contents();
        ob_end_clean();

        // return the contents
        return $contents;
    }

}
