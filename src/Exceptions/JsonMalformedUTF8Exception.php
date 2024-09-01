<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonMalformedUTF8Exception extends Exception {
    protected $message = "Malformed UTF-8 characters, possibly incorrectly encoded.";
    public function __construct() {
        parent::__construct();
    }
}
