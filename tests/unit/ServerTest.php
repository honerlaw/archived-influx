<?php

namespace Test\Server;

use \PHPUnit\Framework\TestCase;

use \Server\Server;

class ServerTest extends TestCase
{

  public function setUp()
  {
    include SOURCE_PATH . '/Server.php';
  }

  public function testInit()
  {
    $server = Server::init();
    $this->assertInstanceOf(Server::class, $server);
  }

}
