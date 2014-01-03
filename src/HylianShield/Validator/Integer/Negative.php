<?php
/**
 * Validate negative integers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Integer;

/**
 * Negative.
 */
class Negative extends \HylianShield\Validator\Range\Immutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'integer_negative';

    /**
     * The validator.
     *
     * @var string $validator
     */
    protected $validator = 'is_int';

    /**
     * The maximum length of the value.
     *
     * @var integer $maxLength
     */
    protected $maxLength = -1;
}
