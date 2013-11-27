<?php
/**
 * A test base for all serializer tests.
 *
 * @package HylianShield
 * @subpackage Test
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace Tests\HylianShield\Serializer;

/**
 * TestBase.
 */
abstract class TestBase extends \PHPUnit_Framework_TestCase
{
    /**
     * The name of the serializer class to test.
     * This needs to be the class with the full namespace.
     *
     * @var string $serializerClass
     */
    protected $serializerClass;

    /**
     * The serializer to use for common tests.
     *
     * @var \HylianShield\Serializer $serializer
     */
    protected $serializer;

    /**
     * A set of validations.
     * Each entry is a function call, which should be an arguments to pass to
     * the serializer.
     *
     * E.g.: array( array(12), array(-12, false) )
     *
     * @var array $validations
     */
    protected $validations = array(
        'application',
        array('12' => 12, 200),
        .6e13
    );

    /**
     * Set up a common serializer.
     */
    protected function setUp()
    {
        $this->serializer = new $this->serializerClass;
    }

    /**
     * Test validations for our class.
     */
    public function testValidations()
    {
        foreach ($this->validations as $validation) {
            $this->assertEquals(
                $validation,
                $this->serializer->unserialize(
                    $this->serializer->serialize($validation)
                )
            );

            $serializer = $this->serializer;

            $this->assertEquals(
                $validation,
                $this->serializer->unserialize(
                    $serializer($validation)
                )
            );
        }
    }
}
