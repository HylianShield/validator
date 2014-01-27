<?php
/**
 * Validate value ranges.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;

/**
 * Range.
 */
abstract class Range extends \HylianShield\Validator
{
    /**
     * The minimum length of the value.
     *
     * @var integer|float $minLength
     */
    protected $minLength = null;

    /**
     * The maximum length of the value.
     *
     * @var integer|float $maxLength
     */
    protected $maxLength = null;

    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'range';

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
    protected $lengthCheck = 'intval';

    /**
     * Initialize the validator.
     *
     * @return void
     */
    final protected function initialize() {
        $validator = $this->createValidator();

        if (!is_callable($validator)) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Validator should be callable!');
            // @codeCoverageIgnoreEnd
        }

        if (!is_callable($this->lengthCheck)) {
            // @codeCoverageIgnoreStart
            throw new LogicException('Length checker should be callable!');
            // @codeCoverageIgnoreEnd
        }

        $lengthCheck = $this->lengthCheck;
        $minLength =& $this->minLength;
        $maxLength =& $this->maxLength;

        $this->validator = function (
            $value
        ) use (
            $validator,
            $minLength,
            $maxLength,
            $lengthCheck
        ) {
            // Check if the basic validation validates.
            if (!call_user_func_array($validator, array($value))) {
                return false;
            }

            // Check if the minimum length validates.
            // Cache the length, in case maxLength needs it.
            if ($minLength !== null
                && ($length = call_user_func_array($lengthCheck, array($value))) < $minLength
            ) {
                return false;
            }

            // Check if the maximum length validates.
            // Use a cached version of the length, if available, or trigger the length check.
            if ($maxLength !== null
                && (isset($length) ? $length : call_user_func_array($lengthCheck, array($value))) > $maxLength
            ) {
                return false;
            }

            return true;
        };
    }

    /**
     * Return the current validator or overload to create a new one.
     *
     * @return callable
     */
    protected function createValidator() {
        return $this->validator;
    }

    /**
     * Return an indentifier.
     *
     * @return string
     */
    public function __tostring()
    {
        $min = $this->minLength === null
            ? '_'
            : $this->minLength;

        $max = $this->maxLength === null
            ? '_'
            : $this->maxLength;

        return "{$this->type}:{$min},{$max}";
    }
}
