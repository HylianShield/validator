<?php
/**
 * Interface for assertions made by a validator.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context\Indication;

/**
 * Interface for assertions made by a validator.
 */
interface AssertionInterface extends IndicationInterface
{
    /**
     * Get the result of the assertion.
     *
     * @return bool
     */
    public function getResult();
}
