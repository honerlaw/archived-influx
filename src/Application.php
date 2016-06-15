<?php

namespace Server;

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
     * @var stdClass The config information
     */
    private static $config;

    /**
     * @var HttpServer The http server
     */
    private $httpServer;

    /**
     * Start all server threads
     *
     * @return Application
     */
    public function start(): self
    {
        if($this->httpServer === null) {
            $this->httpServer = new HttpServer();
            $this->httpServer->start();
        }
        return $this;
    }

    /**
     * Stops all server threads
     *
     * @return Application
     */
    public function stop(): self
    {
        $this->httpServer->stop();
        $this->httpServer->join();
        return $this;
    }

    /**
     * Register the autoloader for the application
     */
    public static function autoload()
    {
        spl_autoload_register(function($class) {
            if(strtolower(substr($class, 0, 6)) === 'server') {
                include str_replace('\\', '/', __DIR__ . '/' . substr($class, 7, strlen($class)) . '.php');
            }
        });
    }

    /**
     * Retreive the config information
     *
     * @return stdClass
     */
    public static function getConfig(): \stdClass
    {
        if(static::$config === null) {
            static::$config = require __DIR__ . '/../resources/config.php';
        }
        return static::$config;
    }

}
