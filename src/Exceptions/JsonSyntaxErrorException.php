<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonSyntaxErrorException extends Exception {
    protected $message = "Syntax error, malformed JSON!";
    public function __construct() {
        parent::__construct();
    }
}
