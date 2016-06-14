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
        return (new Server())->autoload()->services()->routes();
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
        $injector = Injector::getInstance();

        // clear the injector, register the configuration data
        $injector->clear()
            ->set('config', require __DIR__ . '/../resources/config.php');

        // register services that are defined in the config file
        foreach($injector->get('config')->services as $name => $class) {
            $injector->set($name, new $class());
        }
        return $this;
    }

    /**
     * Register all routes for the server from the config file
     *
     * @return Server
     */
    private function routes(): self
    {
        $injector = Injector::getInstance();
        if($injector->has('config') && $injector->has('router')) {
            foreach($injector->get('config')->routes as $route) {
                $injector->get('router')->route($route->method, $route->uri, $route->handler);
            }
        }
        return $this;
    }

}
