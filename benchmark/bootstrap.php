<?php
/**
 * Bootstrapping benchmarks.
 *
 * @package HylianShield
 * @subpackage Benchmarks
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

// As of PHP 5.5, it is required to have a timezone defined.
date_default_timezone_set('Europe/Amsterdam');

// Use the same autoloader as in the test suite.
require_once __DIR__ . '/../test/Autoloader.php';

// Autoload the benchmarking tools.
$autoloader = new Autoloader(__DIR__ . '/../vendor/athletic/athletic/src');
$autoloader->preload();

// Autoload our source files.
$autoloader = new Autoloader(__DIR__ . '/../src');
$autoloader->preload();

// Autoload the benchmarks.
$autoloader = new Autoloader(__DIR__ . '/Benchmarks');
$autoloader->preload();

unset($autoloader);
