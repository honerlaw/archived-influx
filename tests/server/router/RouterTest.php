<?php

namespace Test\Server\Router;

use \PHPUnit\Framework\TestCase;
use \Server\Router\Router;

class RouterTest extends TestCase
{

    public function setUp()
    {
        $this->router = new Router();
    }

    public function testRoute()
    {
        $stub = $this->getMockBuilder('\Server\Router\Handler\RouteHandler')
            ->getMockForAbstractClass();
        $this->router->route('GET', '/foo/bar', $stub);
        $this->assertEquals(count($this->router->getRoutes()), 1);

        $route = $this->router->getRoutes()[0];
        $this->assertEquals($route->getMethod(), 'GET');
        $this->assertEquals($route->getURI(), '/foo/bar');
        $this->assertSame($route->getHandler(), $stub);
    }

    public function testAll()
    {
        $stub = $this->getMockBuilder('\Server\Router\Handler\RouteHandler')
            ->getMockForAbstractClass();
        $this->router->all('/foo/bar', $stub);
        $this->assertEquals(count($this->router->getRoutes()), 1);

        $route = $this->router->getRoutes()[0];
        $this->assertEquals($route->getMethod(), '*');
        $this->assertEquals($route->getURI(), '/foo/bar');
        $this->assertSame($route->getHandler(), $stub);
    }

    public function testGetRoutes()
    {
        $this->assertTrue(is_array($this->router->getRoutes()));
    }

}
