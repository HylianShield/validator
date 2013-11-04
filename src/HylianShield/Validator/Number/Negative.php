<?php
/**
 * Validate negative numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Number;

/**
 * Negative.
 */
class Negative extends \HylianShield\Validator\Number
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'negative_number';

    /**
     * Create a validator for a negative number.
     */
    public function __construct()
    {
        // PHP normally uses a precision of the IEEE 754 double precision format.
        // @see http://php.net/manual/en/language.types.float.php
        parent::__construct(0, -1e-16);
    }
}
