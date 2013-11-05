<?php
/**
 * Validate a conditional list in a logical AND fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial;

/**
 * String.
 */
class Iban extends \HylianShield\Validator\Countable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_iban';

    /**
     * Check the validity of an IBAN.
     *
     * @ToDo needs more elaborate validation for per country IBAN.
     */
    public function __construct()
    {
        $this->validator = function ($iban) {
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

        parent::__construct(15, 29);
    }
}
