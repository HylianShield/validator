<?php
/**
 * Validate mutable value ranges.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Range;

use \InvalidArgumentException;

/**
 * Mutable.
 */
abstract class Mutable extends \HylianShield\Validator\Range
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'range_mutable';

    /**
     * Check the properties of the validator to ensure a perfect implementation.
     *
     * @param integer|float $minLength the minimum length of the value
     * @param integer|float $maxLength the maximum length of the value
     * @throws \InvalidArgumentException when either minLength of maxLength is not an integer or float
     */
    final public function __construct($minLength = null, $maxLength = null)
    {
        if ((isset($minLength) && !(is_int($minLength) || is_float($minLength)))
            || (isset($maxLength) && !(is_int($maxLength) || is_float($maxLength)))
        ) {
            // @codeCoverageIgnoreStart
            throw new InvalidArgumentException(
                'Min and max length should be of type integer or type float.'
            );
            // @codeCoverageIgnoreEnd
        }

        $this->minLength = $minLength;
        $this->maxLength = $maxLength;

        $this->initialize();
    }
}
