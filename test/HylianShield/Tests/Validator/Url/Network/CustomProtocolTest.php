<?php
/**
 * Test the behaviour of the custom network protocol validator.
 *
 * @package HylianShield
 * @subpackage Test
 */

namespace HylianShield\Tests\Validator\Url\Network;

use \HylianShield\Validator\Url\Network\CustomProtocol;
use \HylianShield\Validator\Url\Network\ProtocolDefinition;
use \HylianShield\Validator\Url\Network\ProtocolDefinitionInterface;

/**
 * Test the behaviour of the custom network protocol validator.
 */
class CustomProtocolTest extends \HylianShield\Tests\Validator\TestBase
{
    /**
     * The name of our class to test.
     *
     * @var string $validatorClass
     */
    protected $validatorClass = '\HylianShield\Validator\Url\Network\CustomProtocol';

    /**
     * Data provider for tests using a custom protocol and it's definition.
     *
     * @return array
     */
    public function validatorDefinitionProvider()
    {
        return array(
            array(new ProtocolDefinition())
        );
    }

    /**
     * Apply true and false assertions to the custom protocol validator,
     * using the supplied protocol definition.
     *
     * @param ProtocolDefinitionInterface $definition
     * @param string|array $trueAssertions
     * @param string|array $falseAssertions
     * @return void
     */
    protected function assertDefinition(
        ProtocolDefinitionInterface $definition,
        $trueAssertions,
        $falseAssertions
    ) {
        $validator = new CustomProtocol($definition);

        if (!is_array($trueAssertions)) {
            $trueAssertions = array($trueAssertions);
        }

        if (!is_array($falseAssertions)) {
            $falseAssertions = array($falseAssertions);
        }

        foreach ($trueAssertions as $assertion) {
            $this->assertTrue(
                $validator->validate($assertion),
                $validator->getMessage()
            );
        }

        foreach ($falseAssertions as $assertion) {
            $this->assertFalse(
                $validator->validate($assertion),
                "Assertion: {$assertion}"
            );
        }
    }

    /**
     * Test the allowed schemes.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testAllowedSchemes(ProtocolDefinition $definition)
    {
        $definition->setAllowedSchemes(array('magic'));

        $this->assertDefinition(
            $definition,
            // Valid.
            'magic://link@din/fire',
            // Invalid.
            'arrow://link@din/fire'
        );
    }

    /**
     * Test the allowed ports.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testAllowedPorts(ProtocolDefinition $definition)
    {
        $definition->setAllowedPorts(array(1337, 3));

        $this->assertDefinition(
            $definition,
            // Valid.
            'hyr://castle.royal:3/guard?action=patrol',
            // Invalid.
            'hhg://marvin@earth:42/question?query=ultimate'
        );
    }

    /**
     * Test the required port.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testRequirePort(ProtocolDefinition $definition)
    {
        $definition->setRequirePort(true);

        $this->assertDefinition(
            $definition,
            // Valid.
            'magic://wand:3/spell?list',
            // Invalid.
            'magic://wand/spell?list'
        );
    }

    /**
     * Test against empty URL paths.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testAllowEmptyPath(ProtocolDefinition $definition)
    {
        $definition->setEmptyPathAllowed(false);

        $this->assertDefinition(
            $definition,
            // Valid.
            'map://phone@maps.google.com/12/3.6754/-12.3345/',
            // Invalid.
            'map://phone@maps.google.com/'
        );
    }

    /**
     * Test required user.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testRequireUser(ProtocolDefinition $definition)
    {
        $definition->setRequireUser(true);

        $this->assertDefinition(
            $definition,
            // Valid.
            'https://johmanx10@github.com/hylianshield/validator.git',
            // Invalid.
            array(
                'https://@github.com/hylianshield/validator.git',
                'https://github.com/hylianshield/validator.git'
            )
        );
    }

    /**
     * Test required password.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testRequirePassword(ProtocolDefinition $definition)
    {
        $definition->setRequirePassword(true);

        $this->assertDefinition(
            $definition,
            // Valid.
            'https://johndoe:secretpassword@cia.com',
            // Invalid.
            array(
                'https://johndoe:@cia.com',
                'https://johndoe@cia.com'
            )
        );
    }

    /**
     * Test allowed query parameters.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testAllowedParameters(ProtocolDefinition $definition)
    {
        $allowedParameters = array('sword', 'shield', 'boomerang', 'bomb');
        $definition->setAllowedQueryParameters($allowedParameters);

        $base = 'hyr://goron.shop/stock?';

        $validUrl = $base
            . http_build_query(
                array_fill_keys($allowedParameters, 'y')
            );

        $invalidUrl = $base
            . http_build_query(
                array_fill_keys(
                    array_merge(
                        $allowedParameters,
                        // Add illegal parameters.
                        array('tunic', 'nuts')
                    ),
                    'y'
                )
            );

        $this->assertDefinition(
            $definition,
            // Valid.
            array(
                $base,
                $validUrl
            ),
            // Invalid.
            $invalidUrl
        );
    }

    /**
     * Test invalid query parameters.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testInvalidParameters(ProtocolDefinition $definition)
    {
        $invalidParameters = array('sword', 'shield', 'boomerang', 'bomb');
        $definition->setInvalidQueryParameters($invalidParameters);

        $base = 'hyr://goron.shop/stock?';

        $invalidUrl = $base
            . http_build_query(
                array_fill_keys($invalidParameters, 'y')
            );

        $validUrl = $base
            . http_build_query(
                array_fill_keys(
                    array('tunic', 'nuts'),
                    'y'
                )
            );

        $this->assertDefinition(
            $definition,
            // Valid.
            array(
                $base,
                $validUrl
            ),
            // Invalid.
            $invalidUrl
        );
    }

    /**
     * Test required query parameters.
     *
     * @param ProtocolDefinition $definition
     * @return void
     * @dataProvider validatorDefinitionProvider
     */
    public function testRequiredParameters(ProtocolDefinition $definition)
    {
        $requiredParameters = array('sword', 'shield', 'boomerang', 'bomb');
        $definition->setRequiredQueryParameters($requiredParameters);

        $base = 'hyr://goron.shop/stock?';

        $validUrl = $base
            . http_build_query(
                array_fill_keys($requiredParameters, 'y')
            );

        $invalidUrl = $base
            . http_build_query(
                array_fill_keys(
                    // Remove the first entry.
                    array_slice($requiredParameters, 1),
                    'y'
                )
            );

        $this->assertDefinition(
            $definition,
            // Valid.
            $validUrl,
            // Invalid.
            array(
                $base,
                $invalidUrl
            )
        );
    }

    /**
     * Test that the definition getter throws when the property is missing.
     *
     * @return void
     * @expectedException \LogicException
     * @expectedExceptionMessage Missing property definition
     */
    public function testMissingDefinition()
    {
        $validator = new CustomProtocol(
            new ProtocolDefinition()
        );

        $reflection = new \ReflectionObject($validator);
        $property = $reflection->getProperty('definition');
        $property->setAccessible(true);
        $property->setValue($validator, null);
        $property->setAccessible(false);

        $getter = $reflection->getMethod('getDefinition');
        $getter->setAccessible(true);
        $getter->invoke($validator);
        $getter->setAccessible(false);
    }
}
