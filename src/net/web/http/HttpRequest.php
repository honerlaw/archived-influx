<?php

namespace Server\Net\Web\Http;

use \Server\Net\Request;
use \Server\Service\Logger;

/**
 * Stores / reads all of the data associated with a request
 *
 * @author Derek Honerlaw <honerlawd@gmail.com>
 */
class HttpRequest implements Request
{

    /**
     * @var string The request method
     */
    private $method;

    /**
     * @var string The request uri
     */
    private $uri;

    /**
     * @var string The http request version
     */
    private $version;

    /**
     * @var array The request headers
     */
    private $headers;

    /**
     * @var array The params associated with the request
     */
    private $params;

    /**
     * Initialize the request
     *
     * @param string $method The request method
     * @param string $uri The request uri
     * @param string $version The request version
     * @param array $headers The request headers
     */
    private function __construct(string $method, string $uri, string $version, array $headers)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->version = $version;
        $this->headers = $headers;
    }

    /**
     * Parse the request information into a request object
     *
     * @param string $data The request data
     *
     * @return HttpRequest|null Null if failed to parse data
     */
    public static function create(string $data)
    {
        $pieces = explode("\n", $data);
        if(count($pieces) === 0) {
            return null;
        }
        $info = explode(' ', $pieces[0]);
        if(count($info) !== 3) {
            return null;
        }
        unset($pieces[0]);
        $headers = [];
        foreach($pieces as $piece) {
            $temp = explode(': ', $piece, 2);
            if(count($temp) === 2) {
                $headers[$temp[0]] = $temp[1];
            }
        }
        // TODO: need to set any get parameters from the uri
        return new HttpRequest($info[0], $info[1], $info[2], $headers);
    }

    /**
     * @return string The request method
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string The request uri
     */
    public function getURI(): string
    {
        return $this->uri;
    }

    /**
     * @return string The http version
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * Retreive all of the request headers
     *
     * @return array The array of headers
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get the header information for the given header name
     *
     * @param string $name The header name
     *
     * @return string|null The header information
     */
    public function getHeader(string $name)
    {
        if(array_key_exists($name, $this->headers)) {
            return trim($this->headers[$name]);
        }
        return null;
    }

    /**
     * Set the parameters generated from preg_match (uri params)
     *
     * @param array $params The params generated from preg_match
     *
     * @return HttpRequest
     */
    public function setParams(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Get the uri params
     *
     * @return array|null
     */
    public function getParams()
    {
        return $this->params;
    }

}
