<?php

namespace Server\Service;

use \Server\Application;

/**
 * A very simple logger to log different types of messages to a file
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class Logger
{

    const INFO = 'INFO';
    const WARNING = 'WARNING';
    const SEVERE = 'SEVERE';

    /**
     * @var Logger The logger singleton instance
     */
    private static $instance;

    /**
     * @var string The log file path
     */
    private $logFilePath;

    /**
     * @var resource The file resource
     */
    private $file;

    /**
     * Class constructor, opens the file
     *
     * @param \stdClass $config The config data
     */
    private function __construct()
    {
        $this->logFilePath = Application::getConfig()->logFilePath;
    }

    /**
     * Class destructor, closes the file
     */
    public function __destruct()
    {
        if($this->file !== false) {
            fclose($this->file);
        }
    }

    /**
     * Info level message
     *
     * @param string $message The message to log
     *
     * @return Logger
     */
    public function info($message): self
    {
        return $this->log(Logger::INFO, $message);
    }

    /**
     * Warning level message
     *
     * @param string $message The message to log
     *
     * @return Logger
     */
    public function warning($message): self
    {
        return $this->log(Logger::WARNING, $message);
    }

    /**
     * Severe level message
     *
     * @param string $message The message to log
     *
     * @return Logger
     */
    public function severe($message): self
    {
        return $this->log(Logger::SEVERE, $message);
    }

    /**
     * Formats a message before logged it
     *
     * @param string $level The level of the log
     * @param mixed $message The message to write
     *
     * @return string The formatted log
     */
    private function format(string $level, $message): string
    {
        return "[$level]: $message" . PHP_EOL;
    }

    /**
     * Log a message
     *
     * @param string $level The level of the log
     * @param mixed $message The message to write
     *
     * @return Logger
     */
    public function log(string $level, $message): self
    {
        $this->write($this->format($level, $message));
        return $this;
    }

    /**
     * Write a given message to the log file
     *
     * @param string $message The message to write
     *
     * @throws RuntimeException
     */
    private function write(string $message)
    {
        if(file_exists($this->logFilePath) === false) {
            $this->file = fopen($this->logFilePath, 'a');
        }
        if($this->file === false) {
            throw new \RuntimeException('The log file could not be written to.');
        } else {
            if(fwrite($this->file, $message) === false) {
                throw new \RuntimeException('The log file could not be written to.');
            } else {
                fflush($this->file);
            }
        }
    }

    /**
     * Get the logger singleton instance
     *
     * @return Logger
     */
    public static function getInstance(): Logger
    {
        if(static::$instance === null) {
            static::$instance = new Logger();
        }
        return static::$instance;
    }

}
