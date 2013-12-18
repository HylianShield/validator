<?php
/**
 * Test for \HylianShield\Validator\Url.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \HylianShield\Validator\Url;

/**
 * UrlTest.
 */
class UrlTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Url';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('protocol://user:pass@host.tld:1337/path?param=val#hash', true),
        array('AB12-00-00', true),
        array(8.333, true),
        array('', true)
    );
}
