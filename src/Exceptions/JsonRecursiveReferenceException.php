<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonRecursiveReferenceException extends Exception {
    protected $message = "One or more recursive references in the value to be encoded!";
    public function __construct() {
        parent::__construct();
    }
}
