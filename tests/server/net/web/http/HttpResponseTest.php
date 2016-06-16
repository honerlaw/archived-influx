<?php

namespace Test\Server\Net\Web\Http;

use \PHPUnit\Framework\TestCase;

use \Server\Net\Web\Http\HttpResponse;

class HttpResponseTest extends TestCase
{

    public function setUp()
    {
        $this->response = new HttpResponse();
    }

    public function testVersion()
    {
        $this->assertEquals($this->response->getVersion(), 'HTTP/1.1');
        $this->response->setVersion('HTTP/2.0');
        $this->assertEquals($this->response->getVersion(), 'HTTP/2.0');
    }

    public function testStatusCode()
    {
        $this->assertEquals($this->response->getStatusCode(), 200);
        $this->response->setStatusCode(500);
        $this->assertEquals($this->response->getStatusCode(), 500);
    }

    public function testStatusMessage()
    {
        $this->assertEquals($this->response->getStatusMessage(), 'OK');
        $this->response->setStatusMessage('foo bar');
        $this->assertEquals($this->response->getStatusMessage(), 'foo bar');
    }

    public function testHeaders()
    {
        $this->assertEquals(count($this->response->getHeaders()), 0);
        $this->response->setHeader('foo', 'bar');
        $this->assertEquals($this->response->getHeaders()['foo'], 'bar');
        $this->response->setHeader('foo', 'baz');
        $this->assertEquals($this->response->getHeaders()['foo'], 'baz');
        $this->response->setHeader('bar', 'foo');
        $this->assertEquals($this->response->getHeaders()['bar'], 'foo');
        $this->assertEquals(count($this->response->getHeaders()), 2);
    }

    public function testContent()
    {
        $this->assertEquals($this->response->getContent(), '');
        $this->response->setContent('foo bar');
        $this->assertEquals($this->response->getContent(), 'foo bar');
    }

    public function testBuild()
    {
        $this->assertTrue(is_string($this->response->build()));
        $this->assertEquals(strlen($this->response->build()), 90);
    }

}
