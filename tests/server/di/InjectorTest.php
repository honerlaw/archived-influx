<?php

namespace Test\Server\DI;

use \PHPUnit\Framework\TestCase;

use \Server\DI\Injector;

class InjectorTest extends TestCase
{

    public function setUp()
    {
        Injector::getInstance()->clear();
    }

    public function testInstance()
    {
        $injector = Injector::getInstance();
        $this->assertNotNull($injector);
        $this->assertSame($injector, Injector::getInstance());
    }

    public function testSetGetHas()
    {
        $injector = Injector::getInstance();

        // injector should be empty
        $this->assertFalse($injector->has('test'));
        $this->assertFalse($injector->has('class'));
        $this->assertFalse($injector->has('cool'));
        $this->assertFalse($injector->has('foo'));

        // set some test data
        $injector->set('test', 'testing');
        $injector->set('class', new \stdClass());
        $injector->set('cool', 5);

        // make sure the data was actually set
        $this->assertTrue($injector->has('test'));
        $this->assertTrue($injector->has('class'));
        $this->assertTrue($injector->has('cool'));
        $this->assertFalse($injector->has('foo'));

        // make sure the correct data is returned
        $this->assertEquals($injector->get('test'), 'testing');
        $this->assertInstanceOf('stdClass', $injector->get('class'));
        $this->assertEquals($injector->get('cool'), 5);
        $this->assertNull($injector->get('foo'));
    }

    public function testClear()
    {
        $injector = Injector::getInstance();
        $this->assertEquals(count($injector->getServices()), 0);
        $injector->set('foo', 'foo');
        $injector->set('bar', 'bar');
        $this->assertEquals(count($injector->getServices()), 2);
        $injector->clear();
        $this->assertEquals(count($injector->getServices()), 0);
    }

}
