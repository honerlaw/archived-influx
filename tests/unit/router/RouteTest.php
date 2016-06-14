<?php

namespace Test\Unit\Server\Router;

use \PHPUnit\Framework\TestCase;
use \Server\Router\Route;

class RouteTest extends TestCase
{

    public function testGetters()
    {
        $stub = $this->getMockBuilder('\Server\Router\Handler\RouteHandler')->getMockForAbstractClass();
        $route = new Route('GET', '/foo/bar', $stub);

        $this->assertSame($route->getHandler(), $stub);
        $this->assertEquals($route->getMethod(), 'GET');
        $this->assertEquals($route->getURI(), '/foo/bar');
    }

}
