<?php

namespace OpenPHPLibraries\Http;

use OpenPHPLibraries\Http\Decoder\Decoder;
use OpenPHPLibraries\Http\Decoder\JSON;
use OpenPHPLibraries\Http\Decoder\Text;
use OpenPHPLibraries\Http\Decoder\XML;
use OpenPHPLibraries\Http\Types\ResponseType;

/**
 * Class Response.
 *
 * @author Open PHP Libraries
 */
class Response
{
    /**
     * @var string The type of response, must be an ResponseType
     * @var string $result The raw result returned from the API
     * @var int    $code The HTTP response code from the API
     * @var array  $headers HTTP headers the request returned
     */
    public $type;
    public $result;
    public $code;
    public $headers;

    /**
     * Response constructor.
     *
     * @param string $type
     * @param string $result
     * @param int    $code
     * @param array  $headers
     */
    public function __construct(string $type, string $result, int $code, array $headers = [])
    {
        $this->type = $type;
        $this->result = $result;
        $this->code = $code;
        $this->headers = $headers;
    }

    /**
     * Decode the response from the API.
     *
     * @return Decoder
     *
     * @since 1.0.0
     */
    public function decode(): Decoder
    {
        if ($this->type == ResponseType::JSON) {
            return new JSON($this->result);
        }

        if ($this->type == ResponseType::XML || $this->type == ResponseType::XML_TEXT) {
            return new XML($this->result);
        }

        if ($this->type == ResponseType::TEXT || $this->type == ResponseType::HTML) {
            return new Text($this->result);
        }

        return null;
    }

    /**
     * Get the response from the header.
     *
     * @param $name
     *
     * @return string
     *
     * @since 1.0.0
     */
    public function getHeader($name): string
    {
        return $this->headers[$name];
    }
}
