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

    /**
     * Handle the http request and send out the correct response
     *
     * @param resource $socket The socket for the request
     * @param string $data The data read from the socket
     */
    public function received($socket, $data)
    {
        // generate a new route context with the correct request payload

        $request = Request::create($data);

        if($request !== null) {
            $ctx = new RouteContext($socket, $request);

            // handle the route context
            $resp = $this->router->handle($ctx);

            // if the handlers returned a response send it out
            if($resp instanceof Response) {
                socket_write($socket, $resp->build());
            } else {
                // otherwise send out a 404 not found
                socket_write($socket, (new Response())
                    ->setStatusCode(404)
                    ->setStatusMessage('Not Found.')
                    ->setContent('404 Not Found.')
                    ->build());
            }
        } else {

            // failed to parse request so send out 400 error
            socket_write($socket, (new Response())
                ->setStatusCode(400)
                ->setStatusMessage('Bad Request.')
                ->setContent('400 Bad Request.')
                ->build());
        }

        // shutdown and close the socket after the response is written
        @socket_shutdown($socket);
        socket_close($socket);
    }

    /**
     * Called when a socket is connected
     *
     * @param resource $socket The connected socket
     */
    public function connected($socket) { }

    /**
     * Called when a socket is disconnected
     *
     * @param resource $socket The disconnected socket
     */
    public function disconnected($socket) { }

}
