<?php
/**
 * Testing the webpage validator.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

// Autoload our source files.
require_once __DIR__ . '/Autoloader.php';
new Autoloader(__DIR__ . '/../src');

// Create a new webpage validator.
$webpage = new \HylianShield\Validator\Url\Webpage;

// HTTP.
var_dump($webpage('http://www.google.com/')); // true
var_dump($webpage('http://www.google.com:80/')); // true
var_dump($webpage('http://www.google.com:443/')); // false

// HTTPS.
var_dump($webpage('https://www.google.com/')); // true
var_dump($webpage('https://www.google.com:80/')); // false
var_dump($webpage('https://www.google.com:443/')); // true

$class = new \HylianShield\Validator\CoreClass\Exists;

var_dump($class('\HylianShield\Validator\CoreClass\Exists'));

$array = new \HylianShield\Validator\CoreArray;
$array = new \HylianShield\Validator\CoreArray;

var_dump($array(array()));

$boolean = new \HylianShield\Validator\Boolean;
$object = new \HylianShield\Validator\Object;

var_dump($boolean($array(array())));
var_dump($object($array(array())));

$dataContainer = new \HylianShield\ArrayObject(
    array(
        'OMG' => 'aapjes'
    )
);

$dataContainer->setSerializer(\HylianShield\Configuration\Factory::SERIALIZER_JSON);

var_dump($dataContainer['OMG']);
echo $dataContainer;

$newContainer = new \HylianShield\ArrayObject;
$newContainer->setSerializer(\HylianShield\Configuration\Factory::SERIALIZER_JSON);
$newContainer->unserialize((string) $dataContainer);
$newContainer->setSerializer(\HylianShield\Configuration\Factory::SERIALIZER_PHP);
echo $newContainer;
