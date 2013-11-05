<?php
/**
 * Testing the webpage validator.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

// These requires should obviously be fixed by an autoloader.
require_once 'src/HylianShield/ValidatorAbstract.php';
require_once 'src/HylianShield/Validator/LogicalXor.php';
require_once 'src/HylianShield/Validator/Url.php';
require_once 'src/HylianShield/Validator/Url/Network.php';
require_once 'src/HylianShield/Validator/Url/Network/Http.php';
require_once 'src/HylianShield/Validator/Url/Network/Https.php';
require_once 'src/HylianShield/Validator/Url/Webpage.php';

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
