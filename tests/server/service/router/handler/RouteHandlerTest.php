<?php

namespace Test\Server\Router\Handler;

use \PHPUnit\Framework\TestCase;

class RouteHandlerTest extends TestCase
{

    public function testHandle()
    {
        $stub = $this->getMockBuilder('\Server\Service\Router\Handler\RouteHandler')
            ->setMethods(['handle'])
            ->getMockForAbstractClass();
        $stub->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(true));
        $ctx = $this->createMock('\Server\Service\Router\RouteContext');
        $this->assertTrue($stub->handle($ctx));
    }

}
