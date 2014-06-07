<?php
/**
 * Bootstrapping unit tests.
 *
 * @package HylianShield
 * @subpackage Test
 */

// As of PHP 5.5, it is required to have a timezone defined.
date_default_timezone_set('Europe/Amsterdam');

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/HylianShield/Tests/Validator/TestBase.php';
require_once __DIR__ . '/HylianShield/Tests/Validator/LogicalGateTestBase.php';
require_once __DIR__ . '/HylianShield/Tests/Validator/String/SubsetTestBase.php';
