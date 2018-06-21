<?php

use OpenPHPLibraries\Http\Client;
use OpenPHPLibraries\Http\Types\AuthorizationType;
use OpenPHPLibraries\Http\Types\ResponseType;
use PHPUnit\Framework\TestCase;


class ClientTests extends TestCase
{
    public function testCanSetBaseURL()
    {
        $client = new Client();
        $client->setBaseURL('https://example.com');

        $this->assertEquals(
            'https://example.com',
            $client->curl->baseURL
        );
    }

    public function testCanSetEndpoint()
    {
        $client = new Client();
        $client->setEndpoint('/example');

        $this->assertEquals(
            '/example',
            $client->curl->endpoint
        );
    }

    public function testCanDecideToVerifySSL()
    {
        $client = new Client();
        $client->setVerifySSL(false);

        $this->assertEquals(
            false,
            $client->curl->verifySSL
        );
    }

    public function testCanForceResponseType()
    {
        $client = new Client();
        $client->setResponseType(ResponseType::JSON);

        $this->assertEquals(
            ResponseType::JSON,
            $client->curl->forcedResponseType
        );
    }

    public function testCanSetAuthorizationHeaders() {
        $client = new Client();

        $client->setAuthorization(AuthorizationType::NONE, 'Test');
        $this->assertEquals(
            ['Authorization' => 'Test'],
            $client->curl->headers
        );

        $client->setAuthorization(AuthorizationType::BASIC, 'Test');
        $this->assertEquals(
            ['Authorization' => 'Basic Test'],
            $client->curl->headers
        );

        $client->setAuthorization(AuthorizationType::BEARER, 'Test');
        $this->assertEquals(
            ['Authorization' => 'Bearer Test'],
            $client->curl->headers
        );

        $client->setAuthorization(AuthorizationType::DIGEST, 'Test');
        $this->assertEquals(
            ['Authorization' => 'Digest Test'],
            $client->curl->headers
        );

        $client->setAuthorization(AuthorizationType::HMAC, 'Test');
        $this->assertEquals(
            ['Authorization' => 'HMAC Test'],
            $client->curl->headers
        );
    }
}