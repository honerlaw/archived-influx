<?php

namespace Test\Server\Net;

use \PHPUnit\Framework\TestCase;

class ServerTest extends TestCase
{

    public function setUp()
    {
        /*
        // because Server extends Thread - this fails, need to figure out why
        $this->server = $this->getMockBuilder('\Server\Net\Server')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();
        $this->server->start();*/
    }

    public function testRouter()
    {
        // test that the router loaded the routes correctly
    }

    public function testConnectDisconnectReceived()
    {
        // test that the server can handle a connection
        // that the connected data gets sent to received
        // that connected and disconnected is called
    }

    public function tearDown()
    {
        /*$this->server->stop();
        $this->server->join();*/
    }

}
