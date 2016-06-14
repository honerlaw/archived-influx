<?php

namespace Test\Unit\Server\Http;

use \PHPUnit\Framework\TestCase;
use \Server\Http\Request;

class RequestTest extends TestCase
{

    public function setUp()
    {
        $this->request = new Request();
    }

    public function testGetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertEquals($this->request->getMethod(), 'GET');
    }

    public function testGetURI()
    {
        $_SERVER['REQUEST_URI'] = '/foo/bar';
        $this->assertEquals($this->request->getURI(), '/foo/bar');
    }

}
