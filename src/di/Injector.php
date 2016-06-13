<?php

namespace Server\DI;

/**
 * A very simple dependency injector to be used throughout the application
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class Injector
{

    /**
     * @var Injector The Injector singleton instance
     */
    private static $instance;

    /**
     * @var array The services in the injector
     */
    private $services;

    /**
     * Initialize the injector
     */
    private function construct()
    {
        $this->services = [];
    }

    /**
     * Register / set a service with the injector
     *
     * @return Injector
     */
    public function set(string $name, $service): self
    {
        $this->services[$name] = $service;
        return $this;
    }

    /**
     * Check if a service is registered or not
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->services);
    }

    /**
     * Retrieve a service by name
     *
     * @return mixed|null The service
     */
    public function get(string $name)
    {
        if($this->has($name)) {
            return $this->services[$name];
        }
        return null;
    }

    /**
     * Clears all services from the injector
     *
     * @return Injector
     */
    public function clear(): self
    {
        $this->services = [];
        return $this;
    }

    /**
     * Get the array of services
     *
     * @return array
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * Initialize and retrieve the injector singleton
     *
     * @return Injector
     */
    public static function getInstance(): Injector
    {
        if(static::$instance === null) {
            static::$instance = new Injector();
        }
        return static::$instance;
    }

}
