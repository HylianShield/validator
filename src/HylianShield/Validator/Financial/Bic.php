<?php
/**
 * Validate bank identification codes (BIC).
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial;

/**
 * BIC validation.
 */
class Bic extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'bic';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator;

    /**
     * Check the validity of a BIC.
     *
     * @ToDo needs more elaborate validation for per country BIC codes.
     */
    public function __construct()
    {
        $this->validator = function ($bic) {
            return !preg_match('/^\w{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/', $bic) === false;
        };
    }
}
