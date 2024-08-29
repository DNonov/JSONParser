<?php

namespace Dnonov\JsonParser\Facades;

use Illuminate\Support\Facades\Facade;
use Dnonov\JsonParser\JSONParser as JSONParserImplementation;

class JSONParser extends Facade {
    protected static function getFacadeAccessor(): string {
        return JSONParserImplementation::class;
    }
}
