<?php

namespace Server\Net\Web;

use \Server\Application;
use \Server\Net\Server;
use \Server\Http\Request;
use \Server\Http\Response;
use \Server\Service\Router\RouteContext;

/**
 * Handles incoming http requests
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class HttpServer extends Server
{

    const PORT = 8080;

    public function __construct()
    {
        parent::__construct(HttpServer::PORT, Application::getConfig()->routes);
    }

    public function connected($socket)
    {
        var_dump($socket);
    }

    public function received($socket, $data)
    {
        $ctx = new RouteContext($socket, Request::create($data));
        $resp = $this->router->handle($ctx);
        if($resp instanceof Response) {
            socket_write($socket, $resp->build());
        } else {
            socket_write($socket, (new Response())->setStatusCode(404)->setStatusMessage('Not Found.')->setContent('404 Not Found.')->build());
        }
        socket_close($socket);
    }

    public function disconnected($socket)
    {
        var_dump($socket);
    }

}
