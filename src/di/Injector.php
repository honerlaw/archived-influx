<?php

namespace Server;

class Injector
{

  private $services;

  public function __construct()
  {
    $this->services = [];
  }

  public function setService(string $name, $service)
  {
    $this->services[$name] = $service;
  }

  public function getService(string $name)
  {
    if(array_key_exists($name, $this->services)) {
      return $this->services[$name];
    }
    return null;
  }

  public function clear()
  {
    $this->services = [];
  }

}
