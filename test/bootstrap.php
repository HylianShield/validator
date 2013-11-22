<?php
/**
 * Bootstrapping unit tests.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

// As of PHP 5.5, it is required to have a timezone defined.
date_default_timezone_set('Europe/Amsterdam');

// Autoload our source files.
require_once __DIR__ . '/Autoloader.php';
new Autoloader(__DIR__ . '/../src');
