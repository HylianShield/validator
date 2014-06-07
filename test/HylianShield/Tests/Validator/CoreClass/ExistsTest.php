<?php
/**
 * Test for \HylianShield\Validator\CoreClass\Exists.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Tests\Validator\CoreClass;

use \HylianShield\Validator\CoreClass\Exists;

/**
 * ExistsTest.
 */
class ExistsTest extends \HylianShield\Tests\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\CoreClass\Exists';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('\InvalidArgumentException', true),
        array('PietPaulusmasWeerbericht', false)
    );

    /**
     * Provide a set of invalid arguments.
     *
     * @return array
     */
    public function invalidArgumentProvider()
    {
        // Each entry represents a function call.
        return array(
            // Each entry represents an argument for the function call.
            array(1),
            array(.1),
            array(array())
        );
    }

    /**
     * Test an invalid construct.
     *
     * @dataProvider invalidArgumentProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstruct($invalidArgument)
    {
        $validator = $this->validatorClass;
        $validator = new $validator($invalidArgument);
    }
}
