<?php

namespace Dnonov\JsonParser\Exceptions;

use Exception;

class JsonMaxDepthException extends Exception {
    protected $message = "The maximum stack depth has been exceeded!";
    public function __construct() {
        parent::__construct();
    }
}
