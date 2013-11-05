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
class Iban extends \HylianShield\ValidatorAbstract;
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'iban';

    /**
     * List of classnames for \HylianShield\ValidatorAbstract descendants.
     *
     * @var array $validators
     */
    protected $validators = array();

    /**
     * Check the validity of an IBAN.
     *
     * @ToDo needs more elaborate validation for per country IBAN.
     */
    public function __construct()
    {
        $this->validator = new \HylianShield\Validator\LogicalAnd(
            new \HylianShield\Validator\String(15,29),
            function ($bic) {
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
            }
        );
    }
}
