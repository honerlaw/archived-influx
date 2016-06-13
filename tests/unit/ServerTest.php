<?php

namespace Test\Unit\Server;

use \PHPUnit\Framework\TestCase;

use \Server\DI\Injector;

class ServerTest extends TestCase
{

    /**
     * Implicitly test the autoloader as well as
     * making sure at least the config was loaded in the injector
     */
    public function testInit()
    {
        $service = Injector::getInstance()->get('config');
        $this->assertNotNull($service);
    }

}
