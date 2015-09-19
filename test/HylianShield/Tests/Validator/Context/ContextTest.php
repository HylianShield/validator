<?php
/**
 * Test the context entity.
 *
 * @package HylianShield
 * @subpackage Tests
 */

namespace HylianShield\Tests\Validator\Context;

use \HylianShield\Validator\Context\Context;
use \HylianShield\Validator\Context\ContextInterface;
use \HylianShield\Validator\Context\Indication\IndicationInterface;

/**
 * Test the context entity.
 */
class ContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Data provider for tests in need of a filled context.
     *
     * @return array
     */
    public function filledContextProvider()
    {
        static $context;

        if (!isset($context)) {
            $context = new Context();
            $context->addAssertion('Am I an assertion?', true);
            $context->addViolation(
                'I violated our %trust%',
                1337,
                array('%trust%' => 'contract')
            );
            $context->addIntention('I intend to be filled');
        }

        return array(
            array(clone $context)
        );
    }

    /**
     * Test if only assertion indications are returned by their getter.
     *
     * @param ContextInterface $context
     * @dataProvider filledContextProvider
     */
    public function testGetAssertions(ContextInterface $context)
    {
        foreach ($context->getAssertions() as $assertion) {
            $this->assertInstanceOf(
                $context::ASSERTION_INTERFACE,
                $assertion
            );
        }
    }

    /**
     * Test if only intention indications are returned by their getter.
     *
     * @param ContextInterface $context
     * @dataProvider filledContextProvider
     */
    public function testGetIntentions(ContextInterface $context)
    {
        foreach ($context->getIntentions() as $intention) {
            $this->assertInstanceOf(
                $context::INTENTION_INTERFACE,
                $intention
            );
        }
    }

    /**
     * Test if only violation indications are returned by their getter.
     *
     * @param ContextInterface $context
     * @dataProvider filledContextProvider
     */
    public function testGetViolations(ContextInterface $context)
    {
        foreach ($context->getViolations() as $violation) {
            $this->assertInstanceOf(
                $context::VIOLATION_INTERFACE,
                $violation
            );
        }
    }

    /**
     * Test the structure and quality of the string representation of the
     * context.
     *
     * @param ContextInterface $context
     * @dataProvider filledContextProvider
     */
    public function testStringRepresentation(ContextInterface $context)
    {
        $lines = explode(PHP_EOL, "{$context}");
        $this->assertEquals('Context:', array_shift($lines));
        $this->assertEmpty(array_pop($lines));

        $reflection = new \ReflectionObject($context);
        $indicationsProperty = $reflection->getProperty('indications');
        $indicationsProperty->setAccessible(true);
        /** @var IndicationInterface[] $indications */
        $indications = $indicationsProperty->getValue($context);
        $indicationsProperty->setAccessible(false);

        $index = 1;
        $comparison = array();

        foreach ($indications as $indication) {
            $this->assertInstanceOf(
                '\HylianShield\Validator\Context'
                . '\Indication\IndicationInterface',
                $indication
            );

            $line = trim("#{$index} {$indication}");

            // @see https://phpunit.de/manual/current/en/appendixes.assertions.html#appendixes.assertions.assertStringMatchesFormat
            $this->assertStringMatchesFormat('#%d%s', $line);

            array_push($comparison, $line);
            $index++;
        }

        $lines = array_values($lines);
        $this->assertCount(count($lines), $comparison);

        foreach ($lines as $i => $line) {
            $this->assertEquals(
                $comparison[$i],
                $line
            );
        }
    }
}
