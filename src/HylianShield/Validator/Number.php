<?php
/**
 * Validate numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;

/**
 * Number.
 */
class Number extends \HylianShield\Validator\Range
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'number';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator;

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'round';

    /**
     * Check the properties of the validator to ensure a perfect implementation.
     *
     * @param integer $minLength the minimum length of the value
     * @param integer $maxLength the maximum length of the value
     * @throws \InvalidArgumentException when either minLength of maxLength is not an integer
     */
    public function __construct($minLength = 0, $maxLength = 0)
    {
        if (!is_int($minLength) || !is_int($maxLength)) {
            throw new InvalidArgumentException(
                'Min and max length should be of type integer.'
            );
        }

        // Set a custom validator.
        $this->validator = function ($value) {
            return is_int($value) || is_float($value);
        };

        parent::__construct($minLength, $maxLength);
    }
}
