<?php

namespace Server\Net;

use \Thread;
use \Server\DI\Injector;

/**
 * A very simple server implementation that can be extended to different
 * types of servers
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
abstract class Server extends Thread
{

    /**
     * @var int The number of bytes to read from the socket
     */
    const READ_LENGTH = 2048;

    /**
     * @var int The port to bind to
     */
    private $port;

    /**
     * Initialize the socket
     *
     * @param int $port The port to bind to
     */
    public function __construct(int $port)
    {
        $this->port = $port;
    }

    /**
     * Main loop for reading incoming data and accepting new connections
     */
    public function run()
    {

        // create the socket and listen for incoming connections
        $serverSocket = socket_create_listen($this->port, SOMAXCONN);
        if($serverSocket === false) {
            Injector::getInstance()->get('logger')
                ->severe(socket_strerror(socket_last_error($serverSocket)));
        }

        // add the server socket to the array of sockets to check for changes
        $sockets = [$serverSocket];

        while(true) {

            // Copy sockets to readable so socket_select can modify it
            $readable = $sockets;
            $writable = null;
            $except = null;

            // check if any of the sockets have changed status
            if(socket_select($readable, $writable, $except, 0) === 0) {
                continue;
            }

            // check if we need to accept a new socket
            if(in_array($serverSocket, $readable)) {
                $sock = socket_accept($serverSocket);
                $sockets[] = $sock;
                $this->connected($sock);

                // remove the server socket from the readable array
                unset($readable[array_search($serverSocket, $readable)]);
            }

            // loop through all of the sockets and read their data
            foreach($readable as $socket) {

                // Read the incoming data and ignore exceptions thrown by socket_read
                $data = @socket_read($socket, Server::READ_LENGTH, PHP_BINARY_READ);

                // The client disconnected so remove them
                if($data === false) {
                    $this->disconnected($socket);
                    unset($sockets[array_search($socket, $sockets)]);
                    continue;
                }
                $this->received($socket, trim($data));
            }
        }

        socket_close($serverSocket);
    }

    /**
     * Called when a new socket is connected
     *
     * @param resource $socket The newly accepted socket
     */
    public abstract function connected($socket);

    /**
     * Called when data is read from a socket
     *
     * @param resource $socket The socket that was read from
     * @param mixed $data The data that was read from the socket
     */
    public abstract function received($socket, $data);


    /**
     * Called when a socket is disconnected
     *
     * @param resource $socket The socket that disconnected
     */
    public abstract function disconnected($socket);

}
