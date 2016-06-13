<?php

namespace Server;

use \Server\DI\Injector;

/**
 * The entry point of the application. Handles loading initial classes / data
 * as well as handling incoming requests
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
final class Server
{

    // route a request to an endpoint
    // so we need a router

    /**
     * Only allow init to initialize the class
     */
    private function __construct() { }

    /**
     * Static method to initialize the server
     *
     * @return Server
     */
    public static function init(): self
    {
        return (new Server())->autoload()->services();
    }

    /**
     * Register the autoloader for the server
     *
     * @return Server
     */
    private function autoload(): self
    {
        spl_autoload_register(function($class) {
            if(strtolower(substr($class, 0, 6)) === 'server') {
                include __DIR__ . '/' . substr($class, 6, strlen($class)) . '.php';
            }
        });
        return $this;
    }

    /**
     * Register all services for the server (including the configuration)
     *
     * @return Server
     */
    private function services(): self
    {
        // clear the injector, register the configuration data
        Injector::getInstance()
            ->clear()
            ->set('config', require __DIR__ . '/../resources/config.php');
        return $this;
    }

}
