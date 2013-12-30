<?php
/**
 * Validates External Local Instrument codes for ISO 20022 messages.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator\Financial\ISO20022;

/**
 * ISO 20022 external local instrument code validator.
 */
class ExtLocalInstrumentCode extends \HylianShield\Validator\Regexp
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'financial_iso20022_extlocalinstrumentcode';

    /**
     * A list of LocalInstrument codes.
     *
     * See the tab 7 named "7-LocalInstrument" of the spreadsheet linked here:
     * @see http://www.iso20022.org/external_code_list.page
     *
     * Last update: 2013-11-06
     *
     * @var array externalLocalInstrumentCodes list of organization ids
     */
    protected $externalLocalInstrumentCodes = array(
        // Transaction is related to credit transfers
        'TRF',

        // Transaction is related to truncated checks.
        // Conversion of physical instrument to electonric form for transmission to
        // the paying bank and where the original paper document does not continue in
        // the clearing process..The original instrument rules are retained throughout
        // the life of the instrument.
        'CHN',

        // Transaction is related to cash per post.
        // Transaction to ultimate recipient having no bank account.
        // Primary beneficiary is a postal service provider.
        // Funds are paid out by cash.
        // Additional necessary information for address and delivery options need to
        // be attached.
        'CPP',

        // Transaction is related to direct debits.
        'DDT',

        // Transaction is related to truncated credit transfers.
        // Conversion of physical instrument to electonric form for transmission to
        // the paying bank and where the original paper document does not continue in
        // the clearing process..The original instrument rules are retained throughout
        // the life of the instrument.
        // Transaction triggered by specific marked and populated paper slip.
        // Reconciliation reference is secured by check digits supporting secure
        // optical recognition. All other remittance information is truncated prior
        // transmission.
        'GST',

        // Transaction is related to returned direct debits.
        'RDD',

        // Transaction is related to returned credit transfers.
        'RTR',

        // Transaction is related to revoked truncated checks.
        'SCN',

        // Transaction is related to revoked direct debits.
        'SDD',

        // Transaction is related to revoked truncated credit transfers.
        'SGT',

        // Transaction is related to revoked returned direct debits.
        'SRD',

        // Transaction is related to revoked returned credit transfers
        'SRT',

        // Transaction is related to revoked credit transfers
        'STR',

        // Transaction is related to a direct debit that is not pre authorised
        // (Einzugsermächtigung).
        '82',

        // Transaction is related to a direct debit that is pre authorised (Abbuchungsauftrag).
        '83',

        // Transaction is related to card clearing.
        'CARD',

        // Transaction is related to a direct debit that is pre authorised (Abbuchungsauftrag).
        '04',

        // Transaction is related to a direct debit that is not pre authorised
        // (Einzugsermächtigung).
        '05',

        // Transaction is related to cross border customers credit transfers
        'IN',

        // Transaction is related to a business-to-customer direct debit (CSB19).
        '19',

        // Transaction is related to a business-to-business direct debit (CSB58).
        '58',

        // Transaction is related to a direct debit that is pre authorised (Avis de Prélèvement).
        '08',

        // LCR - Lettre de Change Relevé (Recovered Bill of Exchange) and BOR - Billet à Orde Relevé (Promissory Note)
        '60',

        // Transaction is related to an urgent direct debit that is pre authorised (Avis de Prélèvement accéléré).
        '85',

        // Transaction is related to an urgent direct debit that is pre authorised (Avis de Prélèvement vérifié).
        '89',

        // Transaction is related to a non-pre authorised collection (RIBA).
        'RIBA',

        // Transaction is related to a direct debit that is pre authorised and revocable (RID Ordinario).
        'RIDO',

        // Transaction is related to an urgent direct debit that is pre authorised and revocable (RID Veloce).
        'RIDV',

        // Transaction is related to payments via Acceptgiro owned by Currence.
        'ACCEPT',

        // Transaction is related to payments via internet owned by Currence.
        'IDEAL',

        // Transaction is related to a Domestic payment initiated by PAIN.001
        'NLDO',

        // Transaction is related to direct debit scheme owned by the NVB
        'NLGOV',

        // Transaction is related to a Domestic payment initiated by PAIN.001
        'NLUP',

        // Transaction is related to payments via a ‘Standaard Digitale Nota’ InvoiceAcceptgiro payment.
        'SDN',

        // Transaction is related to business payment
        '0000',

        // Transaction is related to converted (bank) payment.
        // Conversion of physical instrument to electonric form for transmission to
        // the paying bank and where the original paper document does not continue in
        // the clearing process.The instrument rules change upon conversion.
        '0001',

        // Transaction is related to standing order.
        '0002',

        // Transaction is related to mass payment beneficiary.
        '0090',

        // Transaction is related to mass payment ours.
        '0091',

        // Transaction is related to mass payment shared.
        '0092',

        // Transaction is related to standing authorisation general.
        '0220',

        // Transaction is related to one-off authorisation.
        '0221',

        // Transaction is related to standing authorisation companies.
        '0222',

        // Transaction is related to standing authorisation lotteries.
        '0223',

        // Transaction is related to one-off authorisation charities.
        '0224',

        // Transaction is related to one-off authorisation tuition fees.
        '0225',

        // Transaction is related to one-off authorisation construction industry.
        '0226',

        // Transaction is related to standing authorisation companies without debtor
        // revocation right.
        '0227',

        // Transaction is related to cross border customer credit transfer.
        'IN',

        // Transaction is related to overnight clearing.
        'ONCL',

        // Transaction is related to same day clearing.
        'SDCL',

        // Transaction is related to SEPA business to business direct debit.
        'B2B',

        // SEPA B2B Direct Debit AMI based on a paper mandate
        'B2BAMIPM',

        // Optional shorter time cycle (D-1) for SEPA Core Direct Debit
        'COR1',

        // SEPA Core Direct Debit AMI based on a paper mandate
        'CORAMIPM',

        // Transaction is related to SEPA direct debit -core.
        'CORE',

        // Optional shorter time cycle (D-1) for SEPA Core Direct Debit AMI based on a
        // paper mandate.
        'CR1AMIPM',

        // SEPA Fixed Amount Direct Debit
        'DDFA',

        // SEPA Core Direct Debit with ‘no refund’ option
        'DDNR',

        // SEPA Fixed Amount Direct Debit AMI based on a paper mandate
        'FADAMIPM',

        // Transaction is related to an intra-group bank initiated cash management payment
        'CCI',

        // Transaction is related to a bank transfer.
        'BTR',

        // Transaction is related to check same day settlement wire.
        'CKS',

        // Transaction is related to a customer transfer, which may include information
        // related to a cover payment or extended remittance information.
        'CTP',

        // Transaction is related to customer transfer.
        'CTR',

        // Transaction is related to deposit to sender's account.
        'DEP',

        // Transaction is related to bank-to-bank drawdown request or response (non-value).
        'DRB',

        // Transaction is related to customer or corporate drawdown request or response
        // (non-value).
        'DRC',

        // Transaction is related to drawdown response (value) to honor a drawdown request.
        'DRW',

        // Transaction is related to Fed funds returned.
        'FFR',

        // Transaction is related to Fed funds sold.
        'FFS',

        // Transaction is related to non-value service message.
        'SVC',

        // Transaction is related to accounts receivable check.
        'ARC',

        // Transaction is related to cash concentration or disbursement corporate counterparty.
        'CCD',

        // A credit entry initiated by or on behalf of the holder of a consumer account
        'CIE',

        // Transaction is related to corporate trade exchange.
        'CTX',

        // Transaction is related to international ACH.
        'IAT',

        // Transaction is related to point-of-purchase.
        'POP',

        // Transaction is related to point-of-sale.
        'POS',

        // Transaction is related to prearranged payment or deposit consumer counterparty.
        'PPD',

        // Transaction is related to re-presented check entry.
        'RCK',

        // Transaction is related to telephone initiated entry.
        'TEL',

        // Transaction is related to internet initiated entry.
        'WEB'
    );

    /**
     * Check the validity of an external localinstrument code.
     */
    public function __construct()
    {
        parent::__construct(
            '/^' . implode('|', $this->externalLocalInstrumentCodes) . '$/'
        );
    }
}
