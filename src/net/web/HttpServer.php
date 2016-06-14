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

    const HOST = '127.0.0.1';
    const PORT = 80;

    public function __construct()
    {
        parent::__construct(HttpServer::HOST, HttpServer::PORT);
    }

    public function connected($socket)
    {

    }

    public function received($socket, $data)
    {

    }

}
