<?php

namespace Server\Net\Web;

use \Server\Net\Server;

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
        parent::__construct(HttpServer::PORT);
    }

    public function connected($socket)
    {
        var_dump($socket);
    }

    public function received($socket, $data)
    {
        var_dump($socket, $data);
    }

    public function disconnected($socket)
    {
        var_dump($socket);
    }

}
