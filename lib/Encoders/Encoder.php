<?php

namespace OpenPHPLibraries\Http\Encoders;

use SimpleXMLElement;

class Encoder
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function asJSON(): string
    {
        return json_encode($this->data);
    }

    public function asFormEncoded(): string
    {
        return http_build_query($this->data);
    }

    public function asXML(): string
    {
        $xml = new SimpleXMLElement('<root/>');
        array_walk_recursive($this->data, [$xml, 'addChild']);

        return $xml->asXML();
    }
}
