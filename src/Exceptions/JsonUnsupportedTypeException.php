<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonUnsupportedTypeException extends Exception {
    protected $message = "A value of a type that cannot be encoded was given!";
    public function __construct() {
        parent::__construct();
    }
}
