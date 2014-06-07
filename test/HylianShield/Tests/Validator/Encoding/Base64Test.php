<?php
/**
 * Test for \HylianShield\Validator\Encoding\Base64.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Encoding;

use \HylianShield\Validator\Encoding\Base64;

/**
 * Base64 string test.
 */
class Base64Test extends \HylianShield\Tests\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Encoding\Base64';

    /**
     * A set of validations to pass.
     *
     * @var array $validations
     */
    protected $validations = array(
        array('Aap Noot Mies', false),
        // Test invalid amount of characters per 24-bit group.
        array('0123456789', false),
        array('01234567', true),
        array('0123456789==', true),
        // Test empty dataset.
        array('', true),
        // Test invalid character.
        array('      ==', false),
        // Test invalid padding length.
        array('0123456789======', false),
        array(0123456789, false),
        array(null, false),
        array(0, false)
    );

    /**
     * Set up a common validator.
     */
    protected function setUp()
    {
        parent::setUp();

        // Take all validations and add an encoded version of the supplied validation.
        // All encoded versions should validate to true.
        $this->validations = array_merge(
            $this->validations,
            array_map(
                function (array $validation) {
                    list($data) = $validation;
                    return array(base64_encode($data), true);
                },
                $this->validations
            )
        );
    }

    /**
     * Return a set of invalid options for the constructor.
     *
     * @return array
     */
    public function invalidOptionsProvider()
    {
        return array(
            array(array()),
            array(''),
            array(new \StdClass),
            array(.1)
        );
    }

    /**
     * We'll test what happens if the constructor get's passed anything but an integer.
     *
     * @param mixed $options
     * @dataProvider invalidOptionsProvider
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidConstructorOptions($options)
    {
        new Base64($options);
    }

    /**
     * Return a length.
     *
     * @return array
     */
    public function lengthProvider()
    {
        return array_map(
            function ($length) {
                return array($length);
            },
            range(0, 60)
        );
    }

    /**
     * Test a given string length to be encoded and still validate.
     *
     * @param integer $length
     * @dataProvider lengthProvider
     */
    public function testStringLengthAndLineFeeds($length)
    {
        $validator = new Base64(Base64::VALIDATE_PADDING);
        $test = base64_encode(str_repeat('*', $length));
        $this->assertTrue($validator->validate($test));

        $test = implode("\r\n", str_split($test, 2));

        if (strlen($test) > 0) {
            $this->assertFalse($validator->validate($test));
        } else {
            // No line feeds imploded. It will not break on invalid characters.
            $this->assertTrue($validator->validate($test));
        }

        $validator = new Base64(Base64::VALIDATE_PADDING | Base64::ALLOW_CRLF);
        $this->assertTrue($validator->validate($test));
    }
}
