<?php

namespace Test\Server\Router\Handler;

use \PHPUnit\Framework\TestCase;

class RouteHandlerTest extends TestCase
{

    public function testHandle()
    {
        $stub = $this->getMockBuilder('\Server\Router\Handler\RouteHandler')
            ->setMethods(['handle'])
            ->getMockForAbstractClass();
        $stub->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(true));
        $ctx = $this->createMock('\Server\Router\RouteContext');
        $this->assertTrue($stub->handle($ctx));
    }

}
