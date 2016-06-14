<?php

namespace Server\Service;

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
     * @var string The log file path
     */
    private $logFilePath;

    /**
     * Class constructor, opens the file
     *
     * @param \stdClass $config The config data
     */
    public function __construct(\stdClass $config)
    {
        $this->logFilePath = $config->logFilePath;
        $this->file = fopen($this->logFilePath, 'a');
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

}
