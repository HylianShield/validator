<?php
/**
 * Validate a SEPA Creditor Identifier.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2014 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial\SEPA;

/**
 * Creditor Identifier.
 */
class CreditorIdentifier extends \HylianShield\Validator\Range\Immutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_sepa_creditoridentifier';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'strlen';

    /**
     * The minimum length of the value.
     *
     * @var integer $minLength
     */
    protected $minLength = 12;

    /**
     * The maximum length of the value.
     *
     * @var integer $maxLength
     */
    protected $maxLength = 35;

    /**
     * Check the validity of a Creditor Identifier.
     */
    public function createValidator()
    {
        return function ($identifier) {
            // Remove the buisiness code.
            $identifier = substr_replace($identifier, '', 4, 3);

            $country = substr($identifier, 0, 2);
            $control = (int) substr($identifier, 2, 2);

            // Reference number without country and control codes.
            $identifierRef = substr($identifier, 4);

            // Do the mod 97 shuffle.
            $numerizedIban = $identifierRef . $country . '00';

            // Numerize using A=10, B=11 ... Z=35.
            $numerizedId = str_replace(range('A', 'Z'), range(10, 35), $numerizedIban);

            // Do the mod 97 check.
            $calccontrol = 98 - bcmod($numerizedId, 97);

            return $control === $calccontrol;
        };
    }
}
