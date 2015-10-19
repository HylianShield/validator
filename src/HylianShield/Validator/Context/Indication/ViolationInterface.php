<?php
/**
 * Interface for constraint violations, created during a validation.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context\Indication;

/**
 * Interface for constraint violations, created during a validation.
 */
interface ViolationInterface extends IndicationInterface, InterpolatableInterface
{
    /**
     * Get the violation code.
     *
     * @return integer
     */
    public function getCode();

    /**
     * Get the context parameters of the violation.
     *
     * @return array
     */
    public function getContext();
}
