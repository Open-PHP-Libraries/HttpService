<?php

namespace OpenPHPLibraries\Http\Decoder;


use stdClass;

abstract class Decoder
{
    abstract public function asObject(): stdClass;

    abstract public function asArray(): array;

    abstract public function asString(): string;
}