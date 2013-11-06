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
     * The pattern used when validating.
     *
     * @var string $pattern
     */
    private $validator;

    /**
     * A list of organization ID's for the OrgId.
     * @link http://www.iso20022.org/external_code_list.page
     *
     * Last updated 2013-11-06
     *
     * @var array list of organization ids
     */
    private $organizationIdentifiers;

    /**
     * Check the validity of an external organization id.
     *
     * @todo needs more elaborate validation for per country BIC codes.
     */
    public function __construct()
    {
        // @todo make this list more dynamic, currently only available in an excel document.
        $this->organizationIdentifiers = array(
            'BANK' => array(
                'name' => 'BankPartyIdentification',
                'description' => 'Unique and unambiguous assignment made by a specific '
                    . 'bank or similar financial institution to identify a relationship '
                    . 'as defined between the bank and its client.'
            ),
            'CBID' => array(
                'name' => 'Central Bank Identification Number ',
                'description' => 'A unique identification number assigned by a central '
                    . 'bank to identify an organisation.'
            ),
            'CHID' => array(
                'name' => 'Clearing Identification Number',
                'description' => 'A unique identification number assigned by a clearing '
                    . 'house to identify an organisation'
            ),
            'COID' => array(
                'name' => 'CountryIdentificationCode',
                'description' => 'Country authority given organisation identification '
                    . '(e.g., corporate registration number)'
            ),
            'CUST' => array(
                'name' => 'CustomerNumber',
                'description' => 'Number assigned by an issuer to identify a customer. '
                    . 'Number assigned by a party to identify a creditor or debtor relationship.'
            ),
            'DUNS' => array(
                'name' => 'Data Universal Numbering System',
                'description' => 'A unique identification number provided by Dun & Bradstreet '
                    . 'to identify an organisation.'
            ),
            'EMPL' => array(
                'name' => 'EmployerIdentificationNumber',
                'description' => 'Number assigned by a registration authority to an employer.'
            ),
            'GS1G' => array(
                'name' => 'GS1GLNIdentifier',
                'description' => 'Global Location Number. A non-significant reference '
                    . 'number used to identify legal entities, functional entities, '
                    . 'or physical entities according to GS1 numbering scheme rules. '
                    . 'The number is used to retrieve detailed information that is linked to it.'
            ),
            'SREN' => array(
                'name' => 'SIREN',
                'description' => 'The SIREN number is a 9 digit code assigned by INSEE, '
                    . 'the French National Institute for Statistics and Economic Studies, '
                    . 'to identify an organisation in France.'
            ),
            'SRET' => array(
                'name' => 'SIRET',
                'description' => 'The SIRET number is a 14 digit code assigned by INSEE, '
                    . 'the French National Institute for Statistics and Economic Studies, '
                    . 'to identify an organisation unit in France. It consists of the '
                    . 'SIREN number, followed by a five digit classification number, '
                    . 'to identify the local geographical unit of that entity'
            ),
            'TXID' => array(
                'name' => 'TaxIdentificationNumber',
                'description' => 'Number assigned by a tax authority to identify an organisation.'
            )
        );

        $this->validator = function ($extorgid) {
            if (array_key_exists(strtoupper($extorgid), $this->organizationIdentifiers)) {
                return true;
            }

            return false;
        };

        parent::__construct(0, 35);
    }
}
