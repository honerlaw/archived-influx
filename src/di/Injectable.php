<?php

namespace Server\DI;

use \Server\DI\Injector;

/**
 * Represents a class that can be injected
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
abstract class Injectable
{

    /**
     * Retrieve a service by the name of the service
     *
     * @param string $name The name of the service
     *
     * @return mixed|null
     */
    public function getService(string $name)
    {
        $service = Injector::getInstance()->get($name);
        if($service !== null) {
            return $service;
        }
        return null;
    }

}
