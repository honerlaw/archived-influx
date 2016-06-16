<?php

namespace Test\Server\Net\Web\Http\Handler;

use \PHPUnit\Framework\TestCase;

use \Server\Net\Web\Http\HttpRequest;
use \Server\Net\Web\Http\HttpResponse;
use \Server\Service\Router\RouteContext;

use \Server\Net\Web\Http\Handler\IndexHandler;

class IndexHandlerTest extends TestCase
{

    public function setUp()
    {
        $request = HttpRequest::create("GET / HTTP/1.1");
        $response = new HttpResponse();
        $this->ctx = new RouteContext($request, $response);
        $this->handler = new IndexHandler();
    }

    public function testHandle()
    {
        $resp = $this->handler->handle($this->ctx);
        $this->assertInstanceOf("\Server\Net\Response", $resp);
        // TODO: actually check the contents of the response
    }

}
