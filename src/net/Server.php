<?php

namespace Server\Net;

use \Server\DI\Injector;

/**
 * A very simple server implementation that can be extended to different
 * types of servers
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
abstract class Server extends \Thread
{

    /**
     * @var int The number of bytes to read from the socket
     */
    const READ_LENGTH = 1024;

    /**
     * @var string The host to bind to
     */
    private $host;

    /**
     * @var int The port to bind to
     */
    private $port;

    /**
     * @var resource The server's socket
     */
    private $serverSocket;

    /**
     * @var array All sockets registered with the server
     */
    private $sockets;

    /**
     * Initialize the socket
     *
     * @param string $host The host to bind to
     * @param int $port The port to bind to
     */
    public function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
        $this->serverSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        $this->sockets = [$this->serverSocket];
    }

    /**
     * Close the socket
     */
    public function __destruct()
    {
        socket_close($this->serverSocket);
    }

    /**
     * Bind and start listening
     *
     * @return Server
     */
    public function listen(): self
    {
        if(socket_bind($this->serverSocket, $this->host, $this->port) === false) {
            Injector::getInstance()->get('logger')
                ->severe(socket_strerror(socket_last_error($this->serverSocket)));
        }
        if(socket_listen($this->serverSocket, SOMAXCONN) === false) {
            Injector::getInstance()->get('logger')
                ->severe(socket_strerror(socket_last_error($this->serverSocket)));
        }
        return $this;
    }

    /**
     * Main loop for reading incoming data and accepting new connections
     */
    public function run()
    {
        while(true) {

            // Copy the sockets to another array so socket_select can modify it
            $readable = $this->sockets;

            // check if any of the sockets have changed status
            if(socket_select($readable, $w = null, $e = null, 0) === 0) {
                continue;
            }

            // check if we need to accept a new socket
            if(in_array($this->serverSocket, $readable)) {
                $sock = socket_accept($this->serverSocket);
                $this->sockets[] = $sock;
                $this->connected($sock);

                // remove the server socket from the readable array
                unset($readable[array_search($this->serverSocket, $readable)]);
            }

            // loop through all of the sockets and read their data
            foreach($readable as $socket) {

                // Read the incoming data
                $data = @socket_read($socket, Server::READ_LENGTH, PHP_NORMAL_READ);

                // The client disconnected so remove them
                if($data === false) {
                    unset($this->sockets[array_search($socket, $this->sockets)]);
                    continue;
                }
                $this->received($socket, trim($data));
            }
        }
    }

    /**
     * Called when a new socket is connected
     *
     * @var resource $socket The newly accepted socket
     */
    public abstract function connected($socket);

    /**
     * Called when data is read from a socket
     *
     * @var resource $socket The socket that was read from
     * @var mixed $data The data that was read from the socket
     */
    public abstract function received($socket, $data);

}
