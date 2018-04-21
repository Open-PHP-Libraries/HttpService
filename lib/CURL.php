<?php

namespace OpenPHPLibraries\Http;


use OpenPHPLibraries\Http\Encoders\Encoder;
use OpenPHPLibraries\Http\Types\ContentType;

/**
 * Class CURL
 *
 * @version 1.0.0
 * @package OpenPHPLibraries\Http
 */
class CURL
{
    /**
     * @var string $baseURL The base URL used for all requests
     * @var string $endpoint The endpoint of the URL
     * @var array $headers The headers for the request
     * @var array $responseHeaders The headers from the last sent request
     * @var array $verifySSL Whether or not to verify the SSL certificate
     * @var string $forcedResponseType If the HTTP Resource does not properly send the Content-Type you can set it here
     * @var int $requestTimeout Amount of seconds we should wait for the request to complete
     * @var int $connectTimeout Amount of seconds we should wait for the connection to be established
     */
    public $baseURL = '', $endpoint = '', $headers = [], $responseHeaders = [], $verifySSL = true, $forcedResponseType = '', $requestTimeout = 0, $connectTimeout = 0;

    /**
     * @var resource $curl ;
     */
    private $curl;

    /**
     * Returns whether or not the CURL function has been installed on the current PHP version
     *
     * @return bool
     * @since 1.0.0
     */
    public function enabled(): bool
    {
        if (in_array('curl', get_loaded_extensions()))
            return true;
        else
            return false;
    }

    /**
     * Initiate the CURL object if it doesn't exist and set settings setup
     *
     * @return CURL
     * @since 1.0.0
     */
    public function initiate(): CURL
    {
        if ($this->curl === null) {
            $this->curl = curl_init();
            curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->curl, CURLOPT_HEADERFUNCTION, __NAMESPACE__ . "\CURL::handleHeaders");
        }

        /* Set SSL verify */
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, $this->verifySSL ? 0 : 2);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, $this->verifySSL ? 0 : 2);

        /* Set headers */
        $headers = [];

        foreach ($this->headers as $key => $value) {
            $headers[] = "{$key}: {$value}";
        }
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

        /* Set timeouts */
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->requestTimeout);

        return $this;

    }

    /**
     * This function handles all incoming headers from the request
     *
     * @param $curl
     * @param $header
     * @return int
     * @since 1.0.0
     */
    public function handleHeaders($curl, $header)
    {
        $cutHeader = trim(preg_replace('/\s\s+/', ' ', $header));
        $splitHeader = explode(':', $cutHeader, 2);

        if (sizeof($splitHeader) === 1 && strlen($splitHeader[0]) != 0)
            $this->responseHeaders[] = $splitHeader[0];
        else if (sizeof($splitHeader) > 1)
            $this->responseHeaders[$splitHeader[0]] = ltrim($splitHeader[1]);

        return strlen($header);
    }

    /**
     * Get info from the CURL request
     *
     * @param int $info
     * @return mixed
     * @since 1.0.0
     */
    public function getInfo(int $info)
    {
        return curl_getinfo($this->curl, $info);
    }

    /**
     * Set an option for the CURL request
     *
     * @param int $option
     * @param $value
     * @return CURL
     * @since 1.0.0
     */
    public function setOption(int $option, $value): CURL
    {
        curl_setopt($this->curl, $option, $value);
        return $this;
    }

    /**
     * Sets the URL for the request
     *
     * @param string $url
     * @param array $parameters
     * @return CURL
     * @since 1.0.0
     */
    public function setUrl(string $url, array $parameters): CURL
    {
        curl_setopt($this->curl, CURLOPT_URL, $this->buildUrl($url, $parameters));
        return $this;
    }

    /**
     * Set the request type for the request has to be one of the following:
     * GET, POST, PATCH, PUT or DELETE
     *
     * @param string $requestMethod
     * @return CURL
     * @since 1.0.0
     */
    public function setRequestMethod(string $requestMethod): CURL
    {
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $requestMethod);
        return $this;
    }

    /**
     * Set the POST data for the request, will only work if you send one of the following requests:
     * POST, PATCH or PUT
     *
     * @param string $contentType
     * @param array $data
     * @return CURL
     * @since  1.0.0
     */
    public function setPostData(string $contentType, array $data): CURL
    {
        $encoder = new Encoder($data);

        switch ($contentType) {
            case ContentType::JSON:
                $encoded = $encoder->asJSON();
                $this->headers['Content-Type'] = ContentType::JSON;
                $this->setOption(CURLOPT_POSTFIELDS, $encoded);
                break;
            case ContentType::FORM_ENCODED:
                $encoded = $encoder->asFormEncoded();
                $this->headers['Content-Type'] = ContentType::FORM_ENCODED;
                $this->setOption(CURLOPT_POSTFIELDS, $encoded);
                break;
            case ContentType::XML:
                $encoded = $encoder->asXML();
                $this->headers['Content-Type'] = ContentType::XML;
                $this->setOption(CURLOPT_POSTFIELDS, $encoded);
                break;
            case ContentType::XML_TEXT:
                $encoded = $encoder->asXML();
                $this->headers['Content-Type'] = ContentType::XML_TEXT;
                $this->setOption(CURLOPT_POSTFIELDS, $encoded);
                break;
        }

        return $this;
    }

    /**
     * Destroy the CURL object
     *
     * @since 1.0.0
     */
    public function destroy()
    {
        curl_close($this->curl);
    }

    /**
     * Execute the CURL request
     *
     * @return mixed
     * @since 1.0.0
     */
    public function execute()
    {
        /* Set headers again in case there are new headers */
        $headers = [];

        foreach ($this->headers as $key => $value) {
            $headers[] = "{$key}: {$value}";
        }

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $headers);

        $this->responseHeaders = [];
        return curl_exec($this->curl);
    }

    /**
     * Reset the CURL object
     *
     * @return CURL
     * @since 1.0.0
     */
    public function reset(): CURL
    {
        if ($this->curl !== null) {
            curl_reset($this->curl);
            unset($this->headers['Content-Type']);
        }

        return $this;
    }

    public function getContentType(): string
    {
        return strlen($this->forcedResponseType) == 0 ? strstr($this->getInfo(CURLINFO_CONTENT_TYPE), ';', true) : $this->forcedResponseType;
    }

    /**
     * Builds the URL including all GET parameters.
     *
     * @param string $url
     * @param array $parameters
     * @return string
     * @since 1.0.0
     */
    private function buildUrl(string $url, array $parameters): string
    {
        $query = http_build_query($parameters);
        return sizeof($parameters) === 0 ? "{$this->baseURL}{$this->endpoint}{$url}" : "{$this->baseURL}{$this->endpoint}{$url}?{$query}";
    }
}