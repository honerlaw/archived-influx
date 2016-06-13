<?php

namespace Server;

class Server
{

  private function __construct() { }

  public static function init(): self {
    $server = new Server();

    // autoload any classes in the application
    spl_autoload_register(function($class) {

    });

    return $server;
  }

}
