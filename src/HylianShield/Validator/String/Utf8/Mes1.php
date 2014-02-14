<?php
/**
 * Validate the UTF-8 MES-1 subset.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\String\Utf8;

/**
 * Mes1.
 */
class Mes1 extends \HylianShield\Validator\String\Subset
{
    /**
     * The character encoding to use when decoding entities.
     *
     * @const string ENCODING
     */
    const ENCODING = 'UTF-8';

    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'string_utf8_mes1';

    /**
     * The hexadecimal boundaries of the Mes-1 ranges.
     *
     * @var array $ranges
     */
    protected $ranges = array(
        array('0020', '007E'),
        array('00A0', '00FF'),
        array('0100', '017F'),
        array('02B0', '02FF'),
        array('2000', '206F'),
        array('20A0', '20CF'),
        array('2100', '214F'),
        array('2150', '218F'),
        array('2190', '21FF'),
        array('2600', '26FF')
    );
}
