<?php

namespace Test\Server\Service\Router;

use \PHPUnit\Framework\TestCase;

use \Server\Service\Router\RouteContext;

class RouteContextTest extends TestCase
{

    public function setUp()
    {
        $requestMock = $this->createMock('\Server\Net\Request');
        $responseMock = $this->createMock('\Server\Net\Response');
        $this->ctx = new RouteContext($requestMock, $responseMock);
    }

    public function testSetGet()
    {
        $this->assertNull($this->ctx->get('test'));
        $this->ctx->set('test', 'testing');
        $this->assertEquals($this->ctx->get('test'), 'testing');
    }

    public function testGetRequest()
    {
        $this->assertInstanceOf('\Server\Net\Request', $this->ctx->getRequest());
    }

    public function testGetResponse()
    {
        $this->assertInstanceOf('\Server\Net\Response', $this->ctx->getResponse());
    }

}
