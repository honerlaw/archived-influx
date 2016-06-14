<?php

namespace Server;

use \Server\DI\Injector;

use \Server\Net\Web\HttpServer;

/**
 * The entry point of the application. Handles loading initial classes / data
 * as well as handling incoming requests
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
final class Application
{

    /**
     * Only allow init to initialize the class
     */
    private function __construct() { }

    /**
     * Static method to initialize the application
     *
     * @return Application
     */
    public static function init(): self
    {
        return (new Application())->autoload()->services()->routes();
    }

    /**
     * Register the autoloader for the application
     *
     * @return Application
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
     * Register all services for the application (including the configuration)
     *
     * @return Application
     */
    private function services(): self
    {
        $injector = Injector::getInstance();

        $config = require __DIR__ . '/../resources/config.php';

        // clear the injector, register the configuration data
        $injector->clear()->set('config', $config);

        // register services that are defined in the config file
        foreach($config->services as $name => $class) {
            $injector->set($name, new $class($config));
        }
        return $this;
    }

    /**
     * Register all routes for the application from the config file
     *
     * @return Application
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

    /**
     * Start all servers
     *
     * @return Application
     */
    private function start(): self
    {
        (new HttpServer())->listen()->start();
        return $this;
    }

}
