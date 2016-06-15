<?php

namespace Server\Net\Web\Http;

use \Server\Service\Router\RouteContext;
use \Server\Service\Router\Handler\RouteHandler;

class IndexHandler extends RouteHandler
{

    public function handle(RouteContext $ctx)
    {
        return $ctx->getResponse()->setContent('Hello World!');
    }

}
