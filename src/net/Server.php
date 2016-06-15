<?php

namespace Server\Net;

use \Thread;
use \Server\Application;
use \Server\Service\Logger;
use \Server\Service\Router;

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
     * @var boolean Whether the server is running or not
     */
    private $running;

    /**
     * @var Router The router associated with this server
     */
    private $router;

    /**
     * Initialize the socket
     *
     * @param int $port The port to bind to
     */
    public function __construct(int $port, array $routes)
    {
        $this->port = $port;
        $this->running = true;
        $this->router = new Router($routes);
    }

    /**
     * Main loop for reading incoming data and accepting new connections
     */
    public function run()
    {
        // Register the autoloader with the new thread context
        Application::autoload();

        // create the socket and listen for incoming connections
        $serverSocket = socket_create_listen($this->port, SOMAXCONN);
        if($serverSocket === false) {
            Logger::getInstance()->severe(socket_strerror(socket_last_error($serverSocket)));
        }

        // add the server socket to the array of sockets to check for changes
        $sockets = [$serverSocket];

        while($this->running) {

            // Check if any of the sockets have closed etc, and remove them
            foreach($sockets as $key => $socket) {
                if(!is_resource($socket) || get_resource_type($socket) !== 'Socket') {
                    $this->disconnected($socket);
                    unset($sockets[$key]);
                }
            }

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
                if($sock !== false) {
                    $sockets[] = $sock;
                    $this->connected($sock);
                }

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
     * Stops the server
     *
     * @return Server
     */
    public function stop(): self
    {
        $this->running = false;
        return $this;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
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
