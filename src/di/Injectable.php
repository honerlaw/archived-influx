<?php

namespace Server\DI;

use \Server\DI\Injector;

abstract class Injectable
{

  private $injector;

  public function setInjector(Injector $injector)
  {
    $this->injector = $injector;
  }

  public function getInjector(): Injector
  {
    return $this->injector;
  }

  public function __get(string $name)
  {
    return $this->injector->getService($name);
  }

  public function __call()
  {

  }

}
