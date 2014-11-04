<?php
/**
 * Validate bank identification codes (BIC).
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\Financial;

/**
 * BIC validation according to ISO 9362.
 *
 * @see http://www.iso.org/iso/iso_catalogue/catalogue_tc/catalogue_detail.htm?csnumber=52017.
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
    private $pattern = '/^[A-Z]{6}[A-Z0-9][A-Z1-9][A-Z0-9]{0,3}$/';

    /**
     * Alternative pattern allowing test and passive BIC numbers.
     *
     * @var string $testPattern
     */
    private $testPattern = '/^[A-Z]{6}[A-Z0-9]{2}[A-Z0-9]{0,3}$/';

    /**
     * Check the validity of a BIC.
     *
     * @param boolean $allowTestBic
     * @todo needs more elaborate validation for per country BIC codes.
     */
    public function __construct($allowTestBic = false)
    {
        if (!is_bool($allowTestBic)) {
            throw new \InvalidArgumentException('Not a valid boolean');
        }

        if ($allowTestBic === true) {
            parent::__construct($this->testPattern);
        } else {
            parent::__construct($this->pattern);
        }
    }
}
