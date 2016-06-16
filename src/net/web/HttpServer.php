<?php

namespace Server\Net\Web;

use \Server\Application;
use \Server\Net\Server;
use \Server\Net\Web\Http\HttpRequest;
use \Server\Net\Web\Http\HttpResponse;
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
        $request = HttpRequest::create($data);

        // if the request was successfully parsed
        if($request !== null) {

            // generate the route context
            $ctx = new RouteContext($socket, $request, new HttpResponse());

            // handle the route context
            $resp = $this->router->handle($ctx);

            // if the handlers returned a response send it out
            if($resp instanceof HttpResponse) {

                // if there is no content associated with the response
                if(strlen($resp->getContent()) === 0) {

                    // but there is a view associated with it, so set it
                    // as the content body if it renders
                    $data = $ctx->getView()->render();
                    if($data !== null) {
                        $resp->setHeader('Content-Type', 'text/html')->setContent($data);
                    }
                }
                $this->write($socket, $resp->build());
            } else {
                // otherwise send out a 404 not found
                $this->write($socket, (new HttpResponse())
                    ->setStatusCode(404)
                    ->setStatusMessage('Not Found.')
                    ->setContent('404 Not Found.')
                    ->build());
            }
        } else {

            // failed to parse request so send out 400 error
            $this->write($socket, (new HttpResponse())
                ->setStatusCode(400)
                ->setStatusMessage('Bad Request.')
                ->setContent('400 Bad Request.')
                ->build());
        }

        // shutdown and close the socket after the response is written
        $this->close($socket);
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
