<?php
/**
 * Validate an IBAN number.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2014 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial;

/**
 * Iban.
 */
class Iban extends \HylianShield\Validator\Range\Immutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_iban';

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
    protected $minLength = 15;

    /**
     * The maximum length of the value.
     *
     * @var integer $maxLength
     */
    protected $maxLength = 29;

    /**
     * Create the validator
     *
     * @todo needs more elaborate validation for per country IBAN.
     * @return callable
     */
    protected function createValidator()
    {
        return function ($iban) {
            $country = substr($iban, 0, 2);
            $control = (int) substr($iban, 2, 2);

            // Account number without country and control codes.
            $ibanAccount = substr($iban, 4);

            // Do the mod 97 shuffle.
            $numerizedIban = $ibanAccount . $country . '00';

            // Numerize using A=10, B=11 ... Z=35.
            $numerizedIban = str_replace(range('A', 'Z'), range(10, 35), $numerizedIban);

            // Do the mod 97 check.
            $calccontrol = 98 - bcmod($numerizedIban, 97);

            return $control === $calccontrol;
        };
    }
}
