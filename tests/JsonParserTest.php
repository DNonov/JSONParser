<?php

use Dnonov\JsonParser\Exceptions\JsonMaxDepthException;
use Dnonov\JsonParser\Exceptions\JsonControlCharacterException;
use Dnonov\JsonParser\Exceptions\JsonInfinityOrNanDetectedException;
use Dnonov\JsonParser\Exceptions\JsonInvalidOrMalformedException;
use Dnonov\JsonParser\Exceptions\JsonMalformedUTF8Exception;
use Dnonov\JsonParser\Exceptions\JsonRecursiveReferenceException;
use Dnonov\JsonParser\Exceptions\JsonSyntaxErrorException;
use Dnonov\JsonParser\Exceptions\JsonUnsupportedTypeException;

use Orchestra\Testbench\Concerns\CreatesApplication;
use Illuminate\Foundation\Testing\TestCase;

use Dnonov\JsonParser\Facades\JSONParser;

class TestJSONParser extends TestCase {
    use CreatesApplication;

    public function testDecodeToObjectThrowsIfStringNotSupplied() {
        $this->expectException(InvalidArgumentException::class);
        JSONParser::decodeToObject([]);
    }

    public function testDecodeToArrayThrowsIfStringNotSupplied() {
        $this->expectException(InvalidArgumentException::class);
        JSONParser::decodeToArray([]);
    }

    public function testDecodeToObjectThrowsIfJsonHasDeepLevel() {
        $MAX_LEVELS_JSON_DEPTH = 2;
        $this->expectException(JsonMaxDepthException::class);
        $json = '{"one":{"two":{"three":3}}}';

        JSONParser::decodeToObject($json, $MAX_LEVELS_JSON_DEPTH);
    }

    public function testDecodeToArrayThrowsIfJsonHasDeepLevel() {
        $MAX_LEVELS_JSON_DEPTH = 2;
        $this->expectException(JsonMaxDepthException::class);
        $json = '{"one":{"two":{"three":3}}}';

        JSONParser::decodeToArray($json, $MAX_LEVELS_JSON_DEPTH);
    }

    public function testDecodeToObjectThrowsIfHasSyntaxError() {
        $this->expectException(JsonSyntaxErrorException::class);
        $json = '{"one":{"two":"three":3}}}';

        JSONParser::decodeToObject($json);
    }

    public function testDecodeToArrayThrowsIfHasSyntaxError() {
        $this->expectException(JsonSyntaxErrorException::class);
        $json = '{"one":{"two":"three":3}}}';

        JSONParser::decodeToArray($json);
    }

    public function testDecodeToObjectThrowsIfInvalidOrMalformedJSON() {
        $this->expectException(JsonInvalidOrMalformedException::class);
        $json = '{"one": 1 ] }';

        JSONParser::decodeToObject($json);
    }

    public function testDecodeToArrayThrowsIfInvalidOrMalformedJSON() {
        $this->expectException(JsonInvalidOrMalformedException::class);
        $json = '{"one": 1 ] }';

        JSONParser::decodeToArray($json);
    }

    public function testDecodeToObjectThrowsIfControlCharacter() {
        $this->expectException(JsonControlCharacterException::class);
        $json = <<<JSON
        {"badControlChar": "\r\n\r\n",}
        JSON;

        JSONParser::decodeToObject($json);
    }

    public function testDecodeToArrayThrowsIfControlCharacter() {
        $this->expectException(JsonControlCharacterException::class);
        $json = <<<JSON
        {"badControlChar": "\r\n\r\n",}
        JSON;

        JSONParser::decodeToArray($json);
    }

    public function testDecodeToObjectThrowsIfUTF8BadEncoding() {
        $this->expectException(JsonMalformedUTF8Exception::class);
        $nonUTF8Part = mb_convert_encoding("България", "KOI8-R");
        $json = '{"one": "'. $nonUTF8Part .'"}';

        JSONParser::decodeToObject($json);
    }

    public function testDecodeToArrayThrowsIfUTF8BadEncoding() {
        $this->expectException(JsonMalformedUTF8Exception::class);
        $nonUTF8Part = mb_convert_encoding("България", "KOI8-R");
        $json = '{"one": "'. $nonUTF8Part .'"}';

        JSONParser::decodeToArray($json);
    }

    public function testEndcodeThrowsIfHasNanInObject() {
        $this->expectException(JsonInfinityOrNanDetectedException::class);
        $obj = new stdClass();
        $obj->property = NAN;

        JSONParser::encode($obj);
    }

    public function testEndcodeThrowsIfHasNanInArray() {
        $this->expectException(JsonInfinityOrNanDetectedException::class);
        $arr = ["nan" => NAN];

        JSONParser::encode($arr);
    }

    public function testEndcodeThrowsIfHasInfinityInObject() {
        $this->expectException(JsonInfinityOrNanDetectedException::class);
        $obj = new stdClass();
        $obj->property = INF;

        JSONParser::encode($obj);
    }

    public function testEndcodeThrowsIfHasInfinityInArray() {
        $this->expectException(JsonInfinityOrNanDetectedException::class);
        $arr = ["nan" => INF];

        JSONParser::encode($arr);
    }

    public function testEndcodeThrowsIfHasNegativeInfinityInObject() {
        $this->expectException(JsonInfinityOrNanDetectedException::class);
        $obj = new stdClass();
        $obj->property = -INF;

        JSONParser::encode($obj);
    }

    public function testEndcodeThrowsIfHasNegativeInfinityInArray() {
        $this->expectException(JsonInfinityOrNanDetectedException::class);
        $arr = ["nan" => -INF];

        JSONParser::encode($arr);
    }

    public function testEndcodeThrowsIfHasRecursiveReferenceObject() {
        $this->expectException(JsonRecursiveReferenceException::class);
        $obj = new stdClass();
        $obj->property = &$obj;

        JSONParser::encode($obj);
    }

    public function testEndcodeThrowsIfHasRecursiveReferenceArray() {
        $this->expectException(JsonRecursiveReferenceException::class);
        $arr = array();
        $arr["ref"] = &$arr;

        JSONParser::encode($arr);
    }

    public function testEndcodeThrowsIfHasUnsupportedTypeArray() {
        $this->expectException(JsonUnsupportedTypeException::class);
        $arr = array();
        $arr["ref"] = curl_init();

        JSONParser::encode($arr);
    }

    public function testEndcodeThrowsIfHasUnsupportedTypeObject() {
        $this->expectException(JsonUnsupportedTypeException::class);
        $obj = new stdClass();
        $obj->property = curl_init();

        JSONParser::encode($obj);
    }
}
