<?php

namespace Dnonov\JsonParser;

use Dnonov\JsonParser\Exceptions\JsonControlCharacterException;
use JsonException;
use InvalidArgumentException;
use Dnonov\JsonParser\Exceptions\JsonInfinityOrNanDetectedException;
use Dnonov\JsonParser\Exceptions\JsonInvalidOrMalformedException;
use Dnonov\JsonParser\Exceptions\JsonMalformedUTF8Exception;
use Dnonov\JsonParser\Exceptions\JsonMaxDepthException;
use Dnonov\JsonParser\Exceptions\JsonRecursiveReferenceException;
use Dnonov\JsonParser\Exceptions\JsonStateMismatchException;
use Dnonov\JsonParser\Exceptions\JsonSyntaxErrorException;
use Dnonov\JsonParser\Exceptions\JsonUnsupportedTypeException;

class JSONParser {

    /**
     * decode is a wrapper around json_decode.
     *
     * @param string $string
     * @param bool|null $isArray
     * @param int $depth
     * @param int $flags
     * @return array
     * @throws Throwable
     * @link https://php.net/manual/en/function.json-decode.php
     */
    function decodeToArray($string, int $depth=512, int $flags=0) {
        if (!is_string($string)) {
            throw new InvalidArgumentException('$string parameter expected type string ' . gettype($string) . ' given.');
        }

        $result = json_decode($string, true, $depth, $flags);
        self::catchErrors();
        return $result;
    }

    /**
     * DecodeToObject is a wrapper around json_decode.
     *
     * @param string $string
     * @param bool|null $isArray
     * @param int $depth
     * @param int $flags
     * @return object
     * @throws Throwable
     * @link https://php.net/manual/en/function.json-decode.php
     */
    function decodeToObject($string, int $depth=512, int $flags=0) {
        if (!is_string($string)) {
            throw new InvalidArgumentException('$string parameter expected type string ' . gettype($string) . ' given.');
        }

        $result = json_decode($string, false, $depth, $flags);

        self::catchErrors();
        return $result;
    }

    /**
     * Encode is a wrapper of json_encode.
     *
     * @param string $string
     * @param bool|null $isArray
     * @param int $depth
     * @param int $flags
     * @return mixed
     *
     * @link https://php.net/manual/en/function.json-encode.php

     */
    function encode($value, int $flags=0, int $depth=512) {
        $result = json_encode($value, $flags, $depth);
        self::catchErrors();
        return $result;
    }

    /**
     * Changes an array to an object with json inbetween.
     *
     * @param array $array
     * @return object
     */
    function arrayToObject($array) {
        return json_decode(json_encode($array));
    }

    /**
     * Changes an object to an array with json inbetween.
     *
     * @param object $object
     * @return array
     */
    function objectToArray($object) {
        return json_decode(json_encode($object), true);
    }

    /**
     * Decodes json from file to an Array.
     *
     * @param string $filePath it should be relative to base_path()
     * @param bool|null $isArray
     * @param int $depth
     * @param int $flags
     * @return mixed
     */
    function decodeFromFileToArray($filePath, ?bool $isArray=true, int $depth=512, int $flags=0) {
        return self::decodeToArray(file_get_contents(base_path() . $filePath), $isArray, $depth, $flags);
    }

    /**
     * Decodes json from file to an Object.
     *
     * @param string $filePath it should be relative to base_path()
     * @param bool|null $isArray
     * @param int $depth
     * @param int $flags
     * @return mixed
     */
    function decodeFromFileToObject($filePath, ?bool $isArray=false, int $depth=512, int $flags=0) {
        return self::decodeToArray(file_get_contents(base_path() . $filePath), $isArray, $depth, $flags);
    }

    /**
     * Catches json last error and throws an exception.
     *
     * @link https://www.php.net/manual/en/json.constants.php#constant.json-error-state-mismatch
     */
    private static function catchErrors() {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                dump('CLEAN');
                // JSON is valid and no error has occurred.
                return;
            case JSON_ERROR_DEPTH:
                dump('JSON_ERROR_DEPTH');
                throw new JsonMaxDepthException();
            case JSON_ERROR_STATE_MISMATCH:
                dump('JSON_ERROR_STATE_MISMATCH');
                throw new JsonInvalidOrMalformedException();
            case JSON_ERROR_CTRL_CHAR:
                dump('JSON_ERROR_CTRL_CHAR');
                throw new JsonControlCharacterException();
            case JSON_ERROR_SYNTAX:
                dump('JSON_ERROR_SYNTAX');
                throw new JsonSyntaxErrorException();
            case JSON_ERROR_UTF8:
                dump('JSON_ERROR_UTF8');
                throw new JsonMalformedUTF8Exception();
            case JSON_ERROR_RECURSION:
                dump('JSON_ERROR_RECURSION');
                throw new JsonRecursiveReferenceException();
            case JSON_ERROR_INF_OR_NAN:
                dump('JSON_ERROR_INF_OR_NAN');
                throw new JsonInfinityOrNanDetectedException();
            case JSON_ERROR_UNSUPPORTED_TYPE:
                dump('JSON_ERROR_UNSUPPORTED_TYPE');
                throw new JsonUnsupportedTypeException();
            default:
                dump('DEFAULT');
                throw new JsonException();
        }
    }
}
