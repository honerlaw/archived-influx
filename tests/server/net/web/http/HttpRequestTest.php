<?php

namespace Test\Server\Net\Web\Http;

use \PHPUnit\Framework\TestCase;

use \Server\Net\Web\Http\HttpRequest;

class HttpRequestTest extends TestCase
{

    public function setUp()
    {
        $this->mockData = "GET / HTTP/1.1\n";
        $this->mockData .= "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\n";
        $this->mockData .= "Accept-Encoding: gzip, deflate, sdch\n";
        $this->mockData .= "Accept-Language: en-US,en;q=0.8\n";
        $this->mockData .= "Cache-Control: no-cache\n";
        $this->mockData .= "Connection: keep-alive\n";
        $this->mockData .= "Host: 127.0.0.1:8080\n";
        $this->mockData .= "Pragma: no-cache\n";
        $this->mockData .= "Upgrade-Insecure-Requests: 1\n";
        $this->mockData .= "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36\n";
    }

    public function testCreate()
    {
        $this->assertInstanceOf("\Server\Net\Web\Http\HttpRequest", HttpRequest::create($this->mockData));
        $this->assertNull(HttpRequest::create("testing"));
        $this->assertNull(HttpRequest::create(""));
    }

    public function testGetMethod()
    {
        $this->assertEquals('GET', HttpRequest::create($this->mockData)->getMethod());
    }

    public function testGetURI()
    {
        $this->assertEquals('/', HttpRequest::create($this->mockData)->getURI());
    }

    public function testGetVersion()
    {
        $this->assertEquals('HTTP/1.1', HttpRequest::create($this->mockData)->getVersion());
    }

    public function testHeaders()
    {
        $request = HttpRequest::create($this->mockData);
        $this->assertEquals(count($request->getHeaders()), 9);
    }

    public function testParams()
    {
        $request = HttpRequest::create($this->mockData);
        $this->assertNull($request->getParams());

        $request->setParams(['test']);
        $this->assertTrue(is_array($request->getParams()));
        $this->assertEquals($request->getParams()[0], 'test');
    }

}
