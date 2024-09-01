<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonInfinityOrNanDetectedException extends Exception {
    protected $message = "One or more NAN or INF values in the value to be encoded!";
    public function __construct() {
        parent::__construct();
    }
}
