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
class Bic extends \HylianShield\Validator\Regexp
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_bic';

    /**
     * The pattern used when validating.
     *
     * @var string $pattern
     */
    private $pattern = '/^\w{6}[A-Z0-9]{2}([A-Z0-9]{3})?$/';

    /**
     * Check the validity of a BIC.
     *
     * @todo needs more elaborate validation for per country BIC codes.
     */
    public function __construct()
    {
        parent::__construct($this->pattern);
    }
}
