<?php
/**
 * Validate the UTF-8 MES-2 subset.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\String\Utf8;

/**
 * Mes2.
 */
class Mes2 extends \HylianShield\Validator\String\Subset
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
    protected $type = 'string_utf8_mes2';

    /**
     * The hexadecimal boundaries of the Mes-2 ranges.
     *
     * @var array $ranges
     */
    protected $ranges = array(
        array('0020', '007E'),
        array('00A0', '00FF'),
        array('0100', '017F'),
        array('0180', '024F'),
        array('0250', '02AF'),
        array('02B0', '02FF'),
        array('0370', '03CF'),
        array('03D0', '03FF'),
        array('0400', '04FF'),
        array('1E00', '1EFF'),
        array('1F00', '1FFF'),
        array('2000', '206F'),
        array('2070', '209F'),
        array('20A0', '20CF'),
        array('2100', '214F'),
        array('2150', '218F'),
        array('2190', '21FF'),
        array('2200', '22FF'),
        array('2300', '23FF'),
        array('2500', '257F'),
        array('2580', '259F'),
        array('25A0', '25FF'),
        array('2600', '26FF'),
        array('FB00', 'FB4F'),
        array('FFF0', 'FFFD')
    );
}
