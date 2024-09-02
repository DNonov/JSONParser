# JSONParser
[![Latest Version on Packagist](https://img.shields.io/packagist/v/dnonov/json-parser.svg?style=flat-square)](https://packagist.org/packages/dnonov/json-parser)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/DNonov/JSONParser/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/DNonov/JSONParser/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/dnonov/json-parser.svg?style=flat-square)](https://packagist.org/packages/dnonov/json-parser)

## About
Thin wrapper around `json_decode` and `json_encode` with exceptions and some handy methods.

## Requirements
PHP 7.4^

## Installation

You can install the package via composer:

```bash
composer require dnonov/json-parser
```

## Description
This mainly exists because of the silent `json_decode`; if something's wrong it
will return `null`. I prefer exception. I prefer nice method names as well.
It is very thin wrapper around three functions in PHP standard library, but I'm
tired of re-writing it every time.

### Here's how to use it
```php
use Dnonov\JsonParser\Facades\JSONParser;

$arrayData = JSONParser::decodeToArray("[{"one": 1, "two": 2}]");
$objectData = JSONParser::decodeToObject("[{"one": 1, "two": 2}]");

$array = ["one" => 1, "two" => 2];
$encodedArrayData = JSONParser::encode($array);

// Make sure file path is relative to `base_path()`.
$arrayFileData = JSONParser::decodeFromFileToArray("./data.json");
$objectFileData = JSONParser::decodeFromFileToObject("./data.json");

// There are some handy methods.
$object = JSONParser::arrayToObject(["one" => 1, "two" => 2]);
$array = JSONParser::objectToArray($object);
```

### Various exceptions might be thrown during decoding and encoding.
* JsonMaxDepthException
* JsonInvalidOrMalformedException
* JsonControlCharacterException
* JsonSyntaxErrorException
* JsonMalformedUTF8Exception
* JsonRecursiveReferenceException
* JsonInfinityOrNanDetectedException
* JsonUnsupportedTypeException
* JsonException
* InvalidArgumentExceptions

Here's documentation on the equivalent errors in [PHP Doc](https://www.php.net/manual/en/json.constants.php#constant.json-throw-on-error)

## Contributing
Bug reports and pull requests are always welcome.

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
