<?php
/**
 * A test base for all validator tests.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Validator;

use \ReflectionClass;

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
     * Whether we should automatically test the validations.
     *
     * @var boolean $testValidations
     */
    protected $testValidations = true;

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        $reflectionClass = new ReflectionClass($this->validatorClass);
        $reflectionMethod = $reflectionClass->getConstructor();

        // If the validator doesn't require any parameters on construct, create
        // a full-fledged instance right away.
        if ($reflectionMethod === null
            || $reflectionMethod->getNumberOfRequiredParameters() === 0
        ) {
            $this->validator = new $this->validatorClass;
        } else {
            // Creating an instance without a constructor cannot be done on 5.3.
            if (phpversion() >= 5.4) {
                // If not, create an instance while skipping the constructor.
                $this->validator = $reflectionClass->newInstanceWithoutConstructor();
            }

            // As we assume the constructor will create the validator, we can't
            // automatically throw a bunch of validations at it.
            $this->testValidations = false;
        }

        // Test that the type matches the namespace of the validator.
        if ($this->validator instanceof \HylianShield\Validator) {
            $expected = explode('\\', $reflectionClass->getName());
            $expected = implode(
                '_',
                array_map(
                    'strtolower',
                    // Strip off \HylianShield\Validator
                    array_slice($expected, 2)
                )
            );

            // Make an exception for the validators that share a type with a
            // reserved keyword in PHP.
            if (strpos($expected, 'core') === 0) {
                $expected = substr($expected, 4);
            }

            $this->assertEquals($expected, $this->validator->type());
        }
    }

    /**
     * Test the type method.
     */
    public function testType()
    {
        if (!$this->testValidations && phpversion() < 5.4) {
            // At least we know this much.
            $this->assertEmpty($this->validator);
        } else {
            $this->assertInternalType('string', $this->validator->type());
        }
    }

    /**
     * Test the __tostring method.
     */
    public function testToString()
    {
        if (!$this->testValidations && phpversion() < 5.4) {
            // At least we know this much.
            $this->assertEmpty($this->validator);
        } else {
            $string = $this->validator->__tostring();
            $this->assertInternalType('string', $string);
            $type = $this->validator->type();
            $this->assertRegexp('/^' . preg_quote($type) . '(\:(.+)|\((.+)\))?/', $string);
        }
    }

    /**
     * Test validations for our class.
     */
    public function testValidations()
    {
        if (!$this->testValidations) {
            // We need to process this test, regardless of if we actually want
            // to make use of it, because the PHPUnit will complain a test was
            // incomplete if we don't process the method as a whole.
            $this->validations = array();

            if (phpversion() >= 5.4) {
                // Simply test if the validator and it's class name are corresponding.
                // At least then PHPUnit thinks it's been a good boy and won't say
                // it skipped tests.
                $this->assertInstanceOf($this->validatorClass, $this->validator);
            } else {
                // At least we know this much.
                $this->assertEmpty($this->validator);
            }
        }

        // Keep track of the validation count so you know which one failed.
        $validationNr = 1;
        foreach ($this->validations as $validation) {
            $result = array_pop($validation);

            $this->assertEquals(
                $result,
                call_user_func_array(
                    array($this->validator, 'validate'),
                    $validation
                ),
                "Test failed for validation number {$validationNr}. Value supplied: ("
                    . gettype(current($validation)) . ') '
                    . var_export(current($validation), true) . "; Expected: {$this->validator}"
            );

            $message = $this->validator->getMessage();

            if ($result === false) {
                $this->assertFalse(empty($message));
            } else {
                $this->assertEmpty($message);
            }

            $validationNr++;
        }
    }
}
