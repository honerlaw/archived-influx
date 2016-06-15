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
    const PORT = 8080;

    public function __construct()
    {
        parent::__construct(HttpServer::HOST, HttpServer::PORT);
    }

    public function connected($socket)
    {
        var_dump($socket);
    }

    public function received($socket, $data)
    {
        // how do we know we are done reading data though?
        // seems we always retreive 3 empty strings after we read the header
        var_dump($socket, $data);
    }

}
