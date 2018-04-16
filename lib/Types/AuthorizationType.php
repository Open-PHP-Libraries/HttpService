<?php

namespace OpenPHPLibraries\Http\Types;


abstract class AuthorizationType
{
    const Basic = 'Basic';
    const Bearer = 'Bearer';
    const Digest = 'Digest';
    const HMAC = 'HMAC';
    const None = '';

}