<?php
/**
 * Validates external person id codes for ISO 20022 messages.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial\ISO20022;

/**
 * ISO 20022 external person id code validator.
 */
class ExtPersonIdCode extends \HylianShield\Validator\Regexp
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_iso20022_extpersonidcode';

    /**
     * A list of person ID methods for the private identification.
     *
     * See the tab 10 named "10-PersonIdentification" of the spreadsheet linked here:
     * @see http://www.iso20022.org/external_code_list.page
     *
     * Last update: 2013-11-06
     *
     * @var array $personIdentifiers list of organization ids
     */
    protected $personIdentifiers = array(
        // AlienRegistrationNumber.
        // Number assigned by a social security agency to identify a non-resident person.
        'ARNU',

        // PassportNumber.
        // Number assigned by an authority to identify the passport number of a person.
        'CCPT',

        // CustomerIdentificationNumber.
        // Number assigned by an issuer to identify a customer.
        'CUST',

        // DriversLicenseNumber.
        // Number assigned by an authority to identify a driver's license.
        'DRLC',

        // EmployeeIdentificationNumber.
        // Number assigned by a registration authority to an employee.
        'EMPL',

        // NationalIdentityNumber.
        // Number assigned by an authority to identify the national identity number of a
        // person.
        'NIDN',

        // SocialSecurityNumber.
        // Number assigned by an authority to identify the social security number of a
        // person.
        'SOSE',

        // TaxIdentificationNumber.
        // Number assigned by a tax authority to identify a person.
        'TXID'
    );

    /**
     * Check the validity of an external organization id code.
     */
    public function __construct()
    {
        parent::__construct(
            '/^' . implode('|', $this->personIdentifiers) . '$/'
        );
    }
}
