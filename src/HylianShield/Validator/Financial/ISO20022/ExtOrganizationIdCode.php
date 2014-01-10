<?php
/**
 * Validates external organization id codes for ISO 20022 messages.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial\ISO20022;

/**
 * ISO 20022 external organization id code validator.
 */
class ExtOrganizationIdCode extends \HylianShield\Validator\Regexp
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_iso20022_extorganizationidcode';

    /**
     * A list of organization ID's for the OrgId.
     *
     * See the tab 9 named "9-OrganisationIdentification" of the spreadsheet linked here:
     * @see http://www.iso20022.org/external_code_list.page
     *
     * Last update: 2013-11-06
     *
     * @var array $organizationIdentifiers list of organization ids
     */
    protected $organizationIdentifiers = array(
        // BankPartyIdentification.
        // Unique and unambiguous assignment made by a specific bank or similar
        // financial institution to identify a relationship as defined between
        // the bank and its client.
        'BANK',

        // Central Bank Identification Number.
        // A unique identification number assigned by a central bank to identify
        // an organisation.
        'CBID',

        // Clearing Identification Number.
        // A unique identification number assigned by a clearing house to
        // identify an organisation
        'CHID',

        // CountryIdentificationCode.
        // Country authority given organisation identification (e.g., corporate
        // registration number)
        'COID',

        // CustomerNumber.
        // Number assigned by an issuer to identify a customer.
        // Number assigned by a party to identify a creditor or debtor
        // relationship.
        'CUST',

        // Data Universal Numbering System.
        // A unique identification number provided by Dun & Bradstreet to
        // identify an organisation.
        'DUNS',

        // EmployerIdentificationNumber.
        // Number assigned by a registration authority to an employer.
        'EMPL',

        // GS1GLNIdentifier.
        // Global Location Number. A non-significant reference number used to
        // identify legal entities, functional entities, or physical entities
        // according to GS1 numbering scheme rules.The number is used to
        // retrieve detailed information that is linked to it.
        'GS1G',

        // SIREN.
        // The SIREN number is a 9 digit code assigned by INSEE, the French
        // National Institute for Statistics and Economic Studies, to identify
        // an organisation in France.
        'SREN',

        // SIRET.
        // The SIRET number is a 14 digit code assigned by INSEE, the French
        // National Institute for Statistics and Economic Studies, to identify
        // an organisation unit in France. It consists of the SIREN number,
        // followed by a five digit classification number, to identify the local
        // geographical unit of that entity
        'SRET',

        // TaxIdentificationNumber.
        // Number assigned by a tax authority to identify an organisation.
        'TXID'
    );

    /**
     * Check the validity of an external organization id code.
     */
    public function __construct()
    {
        parent::__construct(
            '/^' . implode('|', $this->organizationIdentifiers) . '$/'
        );
    }
}
