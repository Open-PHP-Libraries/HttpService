<?php

use OpenPHPLibraries\Http\Client;
use PHPUnit\Framework\TestCase;

class ClientTests extends TestCase
{
    public function testCanConstruct() {
        $client = new Client(
            'https://example.com',
            '/example',
            ['example' => true],
            false
        );

        $this->assertEquals(
            'https://example.com',
            $client->curl->baseURL
        );

        $this->assertEquals(
            '/example',
            $client->curl->endpoint
        );

        $this->assertEquals(
            ['example' => true],
            $client->curl->headers
        );

        $this->assertEquals(
            false,
            $client->curl->verifySSL
        );
    }

    public function testCanConstructWithoutVerifySSL() {
        $client = new Client(
            'https://example.com',
            '/example',
            ['example' => true]
        );

        $this->assertEquals(
            true,
            $client->curl->verifySSL
        );
    }

    public function testCanConstructWithoutHeaders() {
        $client = new Client(
            'https://example.com',
            '/example'
        );

        $this->assertEquals(
            [],
            $client->curl->headers
        );
    }

    public function testCanConstructWithoutEndpoint() {
        $client = new Client(
            'https://example.com'
        );

        $this->assertEquals(
            '',
            $client->curl->endpoint
        );
    }

    public function testCanConstructWithoutAnything() {
        $client = new Client();

        $this->assertEquals(
            '',
            $client->curl->baseURL
        );

        $this->assertEquals(
            '',
            $client->curl->endpoint
        );

        $this->assertEquals(
            [],
            $client->curl->headers
        );

        $this->assertEquals(
            true,
            $client->curl->verifySSL
        );
    }
}