<?php

namespace Test\Server;

use \PHPUnit\Framework\TestCase;
use \Server\Application;

class ApplicationTest extends TestCase
{

    /**
     * Implicitly tests autoloader and injector service loading
     */
    public function testConfig()
    {
        // make sure we loaded the config
        $this->assertInstanceOf('\stdClass', Application::getConfig());
    }

}
