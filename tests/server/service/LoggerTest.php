<?php

namespace Test\Server\Service;

use \PHPUnit\Framework\TestCase;
use \Server\Service\Logger;
use \Server\Application;

class LoggerTest extends TestCase
{

    public function setUp()
    {
        $this->path = Application::getConfig()->logFilePath;
        if(file_exists($this->path)) {
            unlink($this->path);
        }
    }

    public function testInstance()
    {
        $this->assertSame(Logger::getInstance(), Logger::getInstance());
    }

    public function testInfo()
    {
        Logger::getInstance()->info('Foo bar.');
        $this->assertEquals(trim(file_get_contents($this->path)), '[INFO]: Foo bar.');
    }

    public function testWarning()
    {
        Logger::getInstance()->warning('Foo bar.');
        $this->assertEquals(trim(file_get_contents($this->path)), '[WARNING]: Foo bar.');
    }

    public function testSevere()
    {
        Logger::getInstance()->severe('Foo bar.');
        $this->assertEquals(trim(file_get_contents($this->path)), '[SEVERE]: Foo bar.');
    }

}
