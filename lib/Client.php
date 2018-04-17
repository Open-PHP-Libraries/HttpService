<?php

namespace OpenPHPLibraries\Http;


use Error;
use OpenPHPLibraries\Http\Types\AuthorizationType;
use OpenPHPLibraries\Http\Types\ContentType;
use OpenPHPLibraries\Http\Types\RequestMethod;

/**
 * Client class, base class for everything
 *
 * @version 1.0.0
 * @package OpenPHPLibraries\Http
 * @author Open PHP Libraries
 */
class Client
{
    /**
     * @var CURL $curl
     */
    public $curl;

    /**
     * Creates a new instance of the client class
     *
     * @param string $baseURL
     * @param string $endpoint
     * @param array $headers
     * @param bool $verifySSL
     */
    public function __construct(string $baseURL = '', string $endpoint = '', array $headers = [], bool $verifySSL = true)
    {
        $this->curl = new CURL();

        if (!$this->curl->enabled())
            throw new Error('CURL is not installed!');


        $this->curl->baseURL = $baseURL;
        $this->curl->endpoint = $endpoint;
        $this->curl->headers = $headers;
        $this->curl->verifySSL = $verifySSL;
    }

    /**
     * Set the base URL of the service, this will be appended to all requests.
     *
     * @param string $url The base URL of the API you want to sent requests to
     * @return Client
     * @since 1.0.0
     */
    public function setBaseURL(string $url): Client
    {
        $this->curl->baseURL = $url;
        return $this;
    }

    /**
     * Sets the endpoint of the API
     *
     * @param string $endpoint The endpoint of the API
     * @return Client
     * @since 1.0.0
     */
    public function setEndpoint(string $endpoint): Client
    {
        $this->curl->endpoint = $endpoint;
        return $this;
    }

    /**
     * Whether or not to verify the SSL certificate of the client/server
     * DO NOT USE FOR PRODUCTION!
     *
     * @param bool $verify
     * @return Client
     * @since 1.0.0
     */
    public function setVerifySSL(bool $verify): Client
    {
        $this->curl->verifySSL = $verify;
        return $this;
    }

    /**
     * Set the authorization header type
     *
     * @param string $type
     * @param string $key
     * @return Client
     * @since 1.0.0
     */
    public function setAuthorization(string $type, string $key): Client
    {
        $this->curl->headers['Authorization'] = ($type == AuthorizationType::NONE ? '' : $type . ' ') . "{$key}";
        return $this;
    }

    /**
     * Set the response type if the server doesn't do this manually already
     *
     * @param string $type
     * @return Client
     * @since 1.0.0
     */
    public function setResponseType(string $type): Client
    {
        $this->curl->forcedResponseType = $type;
        return $this;
    }

    /**
     * Amount of seconds to wait for the request to complete
     *
     * @param int $timeout
     * @return Client
     * @since 1.0.0
     */
    public function setRequestTimeout(int $timeout): Client
    {
        $this->curl->requestTimeout = $timeout;
        return $this;
    }

    /**
     * Amount of seconds to wait for a connection to the server
     *
     * @param int $timeout
     * @return Client
     * @since 1.0.0
     */
    public function setConnectTimeout(int $timeout): Client
    {
        $this->curl->connectTimeout = $timeout;
        return $this;
    }

    /**
     * Add a new header to the request
     *
     * @param string $name
     * @param string $value
     * @return Client
     * @since 1.0.0
     */
    public function addHeader(string $name, string $value): Client
    {
        $this->curl->headers[$name] = $value;
        return $this;
    }

    /**
     * Get the value of a header
     *
     * @param string $name
     * @return string
     * @since 1.0.0
     */
    public function getHeader(string $name): string
    {
        return $this->curl->headers[$name];
    }

    /**
     * Delete a header rom the request
     *
     * @param string $name
     * @return Client
     * @since 1.0.0
     */
    public function deleteHeader(string $name): Client
    {
        unset($this->curl->headers[$name]);
        return $this;
    }


    /**
     * Send a GET request
     *
     * @param string $url
     * @param array $parameters
     * @return Response
     * @since 1.0.0
     */
    public function get(string $url, array $parameters = []): Response
    {
        $this->curl->reset()->initiate()->setUrl($url, $parameters)->setRequestMethod(RequestMethod::GET);

        $responseBody = $this->curl->execute();
        $responseType = $this->curl->getContentType();
        $responseCode = $this->curl->getInfo(CURLINFO_HTTP_CODE);

        return new Response(
            $responseType,
            $responseBody,
            $responseCode,
            $this->curl->responseHeaders
        );
    }

    /**
     * Send a POST request
     *
     * @param string $url
     * @param array $body
     * @param string $contentType
     * @param array $parameters
     * @return Response
     */
    public function post(string $url, array $body = [], string $contentType = ContentType::FORM_ENCODED, array $parameters = []): Response
    {
        $this->curl->reset()->initiate()->setUrl($url, $parameters)->setRequestMethod(RequestMethod::POST);
        $this->curl->setPostData($contentType, $body);

        $responseBody = $this->curl->execute();
        $responseType = $this->curl->getContentType();
        $responseCode = $this->curl->getInfo(CURLINFO_HTTP_CODE);

        return new Response(
            $responseType,
            $responseBody,
            $responseCode,
            $this->curl->responseHeaders
        );
    }

    /**
     * Send a PUT request
     *
     * @param string $url
     * @param array $body
     * @param string $contentType
     * @param array $parameters
     * @return Response
     */
    public function put(string $url, array $body = [], string $contentType = ContentType::FORM_ENCODED, array $parameters = []): Response
    {
        $this->curl->reset()->initiate()->setUrl($url, $parameters)->setRequestMethod(RequestMethod::PUT);
        $this->curl->setPostData($contentType, $body);

        $responseBody = $this->curl->execute();
        $responseType = $this->curl->getContentType();
        $responseCode = $this->curl->getInfo(CURLINFO_HTTP_CODE);

        return new Response(
            $responseType,
            $responseBody,
            $responseCode,
            $this->curl->responseHeaders
        );
    }

    /**
     * Send a PATCH request
     *
     * @param string $url
     * @param array $body
     * @param string $contentType
     * @param array $parameters
     * @return Response
     */
    public function patch(string $url, array $body = [], string $contentType = ContentType::FORM_ENCODED, array $parameters = []): Response
    {
        $this->curl->reset()->initiate()->setUrl($url, $parameters)->setRequestMethod(RequestMethod::PATCH);
        $this->curl->setPostData($contentType, $body);

        $responseBody = $this->curl->execute();
        $responseType = $this->curl->getContentType();
        $responseCode = $this->curl->getInfo(CURLINFO_HTTP_CODE);

        return new Response(
            $responseType,
            $responseBody,
            $responseCode,
            $this->curl->responseHeaders
        );
    }

    /**
     * Send a DELETE request
     *
     * @param string $url
     * @param array $parameters
     * @return Response
     */
    public function delete(string $url, array $parameters = []): Response
    {
        $this->curl->reset()->initiate()->setUrl($url, $parameters)->setRequestMethod(RequestMethod::DELETE);

        $responseBody = $this->curl->execute();
        $responseType = $this->curl->getContentType();
        $responseCode = $this->curl->getInfo(CURLINFO_HTTP_CODE);

        return new Response(
            $responseType,
            $responseBody,
            $responseCode,
            $this->curl->responseHeaders
        );
    }

    /**
     * Destroy the CURL object
     *
     * @since 1.0.0
     */
    public function destroy()
    {
        $this->curl->destroy();
    }
}
