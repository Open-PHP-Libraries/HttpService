<?php

namespace OpenPHPLibraries\Http\Decoder;

use stdClass;

class XML extends Decoder
{
    /**
     * @var string
     */
    private $result;

    /**
     * XML constructor.
     *
     * @param string $result
     */
    public function __construct(string $result)
    {
        $this->result = $result;
    }

    /**
     * Returns the XML as an stdClass.
     *
     * @return stdClass
     */
    public function asObject(): stdClass
    {
        $xml = simplexml_load_string($this->result);
        $array = json_decode(json_encode((array) $xml));
        $array = [$xml->getName() => $array];

        return $array;
    }

    /**
     * Returns the XML as an array.
     *
     * @return array
     */
    public function asArray(): array
    {
        $xml = simplexml_load_string($this->result);
        $array = json_decode(json_encode((array) $xml), true);
        $array = [$xml->getName() => $array];

        return $array;
    }

    /**
     * Returns the XML as a string.
     *
     * @return string
     */
    public function asString(): string
    {
        return $this->result;
    }
}
