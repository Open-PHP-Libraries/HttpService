<?php
/**
 * Created by IntelliJ IDEA.
 * User: marti
 * Date: 15-4-2018
 * Time: 21:34
 */

namespace OpenPHPLibraries\Http\Decoder;


use Error;
use stdClass;

class Text extends Decoder
{

    /**
     * @var string $result
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
     * Throws an error
     *
     * @throws Error
     */
    public function asObject(): stdClass
    {
        throw new Error('asObject() not applicable to type text');
    }

    /**
     * Throws an error
     *
     * @throws Error
     */
    public function asArray(): array
    {
        throw new Error('asArray() not applicable to type text');
    }

    /**
     * Returns text
     *
     * @return string
     */
    public function asString(): string
    {
        return $this->result;
    }
}