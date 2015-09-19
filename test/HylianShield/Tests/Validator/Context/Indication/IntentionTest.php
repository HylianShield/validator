<?php
/**
 * Test intention entities.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Tests\Validator\Context\Indication;

use \HylianShield\Validator\Context\Indication\IndicationTestBase;

/**
 * Test intention entities.
 */
class IntentionTest extends IndicationTestBase
{
    /**
     * Get the reflection for the concrete indication class.
     *
     * @return \ReflectionClass
     */
    protected function createReflection()
    {
        return new \ReflectionClass(
            '\HylianShield\Validator\Context\Indication\Intention'
        );
    }
}
