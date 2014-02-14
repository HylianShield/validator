<?php
/**
 * Validate the UTF-8 Word character subset.
 *
 * A subset without symbols like /?()[]%& etc.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2014 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\String\Utf8;

/**
 * WordCharacter.
 */
class WordCharacter extends \HylianShield\Validator\String\Subset
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
    protected $type = 'string_utf8_wordcharacter';

    /**
     * The hexadecimal boundaries of the word character ranges.
     *
     * @var array $ranges
     */
    protected $ranges = array(
        array('0030', '0039'),
        array('0041', '005A'),
        array('0061', '007A'),
        array('00BF', '00FF')
    );
}
