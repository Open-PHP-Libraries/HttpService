<?php

namespace OpenPHPLibraries\Http\Types;


abstract class ResponseType
{
    const JSON = 'application/json';
    const XML = 'application/xml';
    const XML_TEXT = 'text/xml';
    const TEXT = 'text/plain';
    const HTML = 'text/html';
}