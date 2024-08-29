<?php

namespace Dnonov\JsonParser\Facades;

use Illuminate\Support\Facades\Facade;

class JSONParser extends Facade {
    protected static function getFacadeAccessor(): string {
        return 'jsonparser';
    }
}
