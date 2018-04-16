<?php

namespace OpenPHPLibraries\Http\Decoder;

use stdClass;

class JSON extends Decoder
{
    /**
     * @var string
     */
    private $result;

    /**
     * Decoder constructor.
     *
     * @param string $result
     */
    public function __construct(string $result)
    {
        $this->result = $result;
    }

    /**
     * Returns the JSON as an stdClass.
     *
     * @return stdClass
     */
    public function asObject(): stdClass
    {
        return json_decode($this->result);
    }

    /**
     * Returns the JSON as an array.
     *
     * @return array
     */
    public function asArray(): array
    {
        return json_decode($this->result, true);
    }

    /**
     * Returns the JSON as a string.
     *
     * @return string
     */
    public function asString(): string
    {
        return $this->result;
    }
}
