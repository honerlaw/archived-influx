<?php

namespace Test\Server\DI;

use \PHPUnit\Framework\TestCase;

use \Server\DI\Injector;

class InjectableTest extends TestCase
{

    public function setUp()
    {
        Injector::getInstance()->clear();
    }

    public function testGetService()
    {
        $stub = $this->getMockBuilder('\Server\DI\Injectable')->getMockForAbstractClass();
        $this->assertNull($stub->getService('test'));
        Injector::getInstance()->set('test', 'testing');
        $this->assertEquals($stub->getService('test'), 'testing');
    }

}
