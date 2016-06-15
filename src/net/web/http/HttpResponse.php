<?php

namespace Server\Net\Web\Http;

use \Server\Net\Response;

/**
 * Handles setting and building the response for http requests
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class HttpResponse implements Response
{

    /**
     * @var string The http version
     */
    private $version;

    /**
     * @var int The status code
     */
    private $statusCode;

    /**
     * @var string The status message
     */
    private $statusMessage;

    /**
     * @var array The response headers
     */
    private $headers;

    /**
     * @var string The content body
     */
    private $content;

    /**
     * Initialize the response with the default values
     */
    public function __construct()
    {
        $this->version = 'HTTP/1.1';
        $this->statusCode = 200;
        $this->statusMessage = 'OK';
        $this->headers = [];
        $this->content = '';
    }

    /**
     * Set the http version
     *
     * @param string $version The http version
     *
     * @return HttpResponse
     */
    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    /**
     * Set the status code
     *
     * @param int $statusCode The status code
     *
     * @return HttpResponse
     */
    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Set the status message
     *
     * @param string $statusMessage The status message
     *
     * @return HttpResponse
     */
    public function setStatusMessage(string $statusMessage): self
    {
        $this->statusMessage = $statusMessage;
        return $this;
    }

    /**
     * Set a header value
     *
     * @param string $key The header name
     * @param string $value The header value
     *
     * @return HttpResponse
     */
    public function setHeader(string $key, string $value): self
    {
        $this->headers[$key] = $value;
        return $this;
    }

    /**
     * Set the content body
     *
     * @param string $content The content body
     *
     * @return HttpResponse
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Build the response object into a string
     *
     * @return string
     */
    public function build(): string
    {
        $response = "$this->version $this->statusCode $this->statusMessage\n";
        $response .= "Date: " . gmdate('D, d M Y H:i:s T') . "\n";
        $response .= "Connection: close\n";
        foreach($this->headers as $key => $value) {
            $response .= "$key: $value\n";
        }
        if(!array_key_exists('Content-Type', $this->headers)) {
            $response .= "Content-Type: text/html";
        }
        $response .= "Content-Length: " . (strlen($this->content)) . "\n\n\n";
        return $response . $this->content;
    }

}
