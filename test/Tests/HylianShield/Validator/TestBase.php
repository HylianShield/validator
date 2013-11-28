<?php
/**
 * A test base for all validator tests.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

/**
 * TestBase.
 */
abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * The name of the validator class to test.
     * This needs to be the class with the full namespace.
     *
     * @var string $validatorClass
     */
    protected $validatorClass;

    /**
     * The validator to use for common tests.
     *
     * @var \HylianShield\Validator $validator
     */
    protected $validator;

    /**
     * A set of validations with the outcome as last entry.
     * Each entry is a function call, which should be an array with arguments
     * to pass to the validator with the last one being either true or false.
     *
     * E.g.: array( array(12, true), array(-12, false) )
     *
     * @var array $validations
     */
    protected $validations = array();

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        $this->validator = new $this->validatorClass;
    }

    /**
     * Test the type method.
     */
    public function testType()
    {
        $this->assertInternalType('string', $this->validator->type());
    }

    /**
     * Test the __tostring method.
     */
    public function testToString()
    {
        $this->assertInternalType('string', $this->validator->__tostring());
    }

    /**
     * Test validations for our class.
     */
    public function testValidations()
    {
        foreach ($this->validations as $validation) {
            $result = array_pop($validation);
            $this->assertEquals(
                $result,
                call_user_func_array(
                    array($this->validator, 'validate'),
                    $validation
                )
            );
        }
    }
}
