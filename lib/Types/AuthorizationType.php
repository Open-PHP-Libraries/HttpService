<?php

namespace OpenPHPLibraries\Http\Types;


abstract class AuthorizationType
{
    const BASIC = 'Basic';
    const BEARER = 'Bearer';
    const DIGEST = 'Digest';
    const HMAC = 'HMAC';
    const NONE = '';

}