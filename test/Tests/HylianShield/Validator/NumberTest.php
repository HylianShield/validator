<?php
/**
 * Test for \HylianShield\Validator\Number.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \InvalidArgumentException;
use \HylianShield\Validator;

/**
 * NumberTest.
 */
class NumberTest extends \Tests\HylianShield\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Number';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('Aap Noot Mies', false),
        array('0123456789', false),
        array('', false),
        array(0123456789, true),
        array(null, false),
        array(0, true),
        array(.0, true),
        array(true, false),
        array(false, false)
    );

    /**
     * Provide invalid arguments.
     *
     * @return array
     */
    final public function invalidArgumentProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument.
            array('aap', 'noot'),
            array(new \StdClass, new \DateTime),
            array(null, true),
            array(true, true),
            array(new Validator\Integer, false)
        );
    }

    /**
     * Test invalid arguments
     *
     * @expectedException \InvalidArgumentException
     * @dataProvider invalidArgumentProvider
     */
    final public function testInvalidArguments($a = null, $b = null)
    {
        $class = $this->validatorClass;
        new $class($a, $b);
    }
}
