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
interface ViolationInterface extends IndicationInterface
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

    /**
     * Interpolate the context parameters into the supplied local translation
     * of the violation.
     *
     * The given string can use :param to denote the position where the
     * parameters can be interpolated.
     *
     * E.g.:
     *
     * Context: ['user' => 'Impa', 'domain' => 'gerudo.vil.hyr']
     * Translation: Invalid user :user and domain :domain found.
     * Interpolated: Invalid user Impa and domain gerudo.vil.hyr found.
     *
     * @param string $translation
     * @return string
     */
    public function interpolate($translation);
}
