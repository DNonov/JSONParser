<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonInvalidOrMalformedException extends Exception {
    protected $message = "Invalid or malformed JSON!";
    public function __construct() {
        parent::__construct();
    }
}
