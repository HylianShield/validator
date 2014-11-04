<?php
/**
 * Interface as a base for indications that can be added to a context.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Context\Indication;

/**
 * Interface as a base for indications that can be added to a context.
 */
interface IndicationInterface
{
    /**
     * Get the description of the indication.
     *
     * @return string
     */
    public function getDescription();
}
