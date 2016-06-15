<?php

namespace Server\Net\Web\Http\Handler;

use \Server\Application;
use \Server\Service\Router\RouteContext;
use \Server\Service\Router\Handler\RouteHandler;

/**
 * Loads static resources from the webroot
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class StaticHandler extends RouteHandler
{

    /**
     * @var string The directory of the webroot
     */
    private $webroot;

    /**
     * Initialize the static handler and set the webroot path
     */
    public function __construct()
    {
        $this->webroot = realpath(Application::getConfig()->webroot);
    }

    /**
     * Handle an incoming request for a static resource
     *
     * @param RouteContext $ctx The route context
     *
     * @return HttpResponse
     */
    public function handle(RouteContext $ctx)
    {
        // get the path to the resource
        $path = $this->webroot . DIRECTORY_SEPARATOR . $ctx->getRequest()->getURI();

        // check if the resource exists
        if(file_exists($path)) {

            // if so get the mime type and content and send it out
            $contentType = mime_content_type($path);
            $content = file_get_contents($path);
            return $ctx->getResponse()
                ->setHeader('Content-Type', $contentType)
                ->setContent($content);
        }

        // if not send out a 404
        return $ctx->getResponse()
            ->setStatusCode(404)
            ->setStatusMessage('Not Found.')
            ->setContent('404 Not Found.');
    }

}
