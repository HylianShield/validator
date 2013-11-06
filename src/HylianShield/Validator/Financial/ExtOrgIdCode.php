<?php
/**
 * Validates external organization id codes for ISO 20022 messages.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial;

/**
 * ISO 20022 external organization id code validator.
 */
class ExtOrgIdCode extends \HylianShield\Validator\Countable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_extorgidcode';

    /**
     * A list of organization ID's for the OrgId.
     * @link http://www.iso20022.org/external_code_list.page
     *
     * Last updated 2013-11-06
     *
     * @var array list of organization ids
     */
    private $organizationIdentifiers = array(
        'BANK', 'CBID', 'CHID', 'COID', 'CUST', 'DUNS', 'EMPL', 'GS1G', 'SREN', 'SRET', 'TXID'
    );

    /**
     * Check the validity of an external organization id.
     */
    public function __construct()
    {
        $this->validator = function ($extorgid) {
            if (!isset($extorgid) && !is_string($extorgid)) {
                return false;
            }

            if (array_key_exists(strtoupper($extorgid), $this->organizationIdentifiers)) {
                return true;
            }

            return false;
        };
    }
}
