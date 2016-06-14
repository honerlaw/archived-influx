<?php

namespace Test\Server;

use \PHPUnit\Framework\TestCase;

use \Server\DI\Injector;

class ApplicationTest extends TestCase
{

    /**
     * Implicitly tests autoloader and injector service loading
     */
    public function testInit()
    {
        $config = Injector::getInstance()->get('config');
        $router = Injector::getInstance()->get('router');
        $this->assertNotNull($config);
        $this->assertNotNull($router);
    }

}
