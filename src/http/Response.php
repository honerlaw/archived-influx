<?php

namespace Server\Http;

/**
 * Handles building and sending the response to the client
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class Response
{

    private $version;

    private $statusCode;

    private $statusMessage;

    private $headers;

    private $content;

    public function __construct()
    {
        $this->version = 'HTTP/1.1';
        $this->statusCode = 200;
        $this->statusMessage = 'OK';
        $this->headers = [];
        $this->content = '';
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setStatusMessage(string $statusMessage): self
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    public function setHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function build(): string
    {
        $response = "$this->version $this->statusCode $this->statusMessage\n";
        $response .= "Date: " . gmdate('D, d M Y H:i:s T') . "\n";
        $response .= "Connection: close\n";
        foreach($this->headers as $key => $value) {
            $response .= "$key: $value\n";
        }
        $response .= "Content-Length: " . (strlen($this->content)) . "\n\n\n";
        return $response . $this->content;
    }

}
