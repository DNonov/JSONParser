<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonControlCharacterException extends Exception {
    protected $message = "Control character error, possibly incorrectly encoded!";
    public function __construct() {
        parent::__construct();
    }
}
