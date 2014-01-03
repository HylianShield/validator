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
class Negative extends \HylianShield\Validator\Integer
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'integer_negative';

    /**
     * The minimum length of the value.
     *
     * @var integer $minLength
     */
    protected $minLength = 0;

    /**
     * The maximum length of the value.
     *
     * @var integer $maxLength
     */
    protected $maxLength = -1;

    /**
     * Define the ability to overload the range while constucting the object.
     *
     * @var boolean $canOverloadRange
     */
    protected $canOverloadRange = false;
}
