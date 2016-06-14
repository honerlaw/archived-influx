<?php

namespace Test\Unit\Server\Router;

use \PHPUnit\Framework\TestCase;

use \Server\Router\RouteContext;

class RouteContextTest extends TestCase
{

    public function setUp()
    {
        $this->ctx = new RouteContext();
    }

    public function testSetGet()
    {
        $this->assertNull($this->ctx->get('test'));
        $this->ctx->set('test', 'testing');
        $this->assertEquals($this->ctx->get('test'), 'testing');
    }

    public function testGetRequest()
    {
        $this->assertInstanceOf('\Server\Http\Request', $this->ctx->getRequest());
    }

    public function testGetResponse()
    {
        $this->assertInstanceOf('\Server\Http\Response', $this->ctx->getResponse());
    }

}
