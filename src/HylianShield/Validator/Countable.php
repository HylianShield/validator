<?php
/**
 * Validate countable values.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

use \InvalidArgumentException;

/**
 * Countable.
 */
class Countable extends \HylianShield\ValidatorAbstract
{
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
    protected $maxLength = 0;

    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'countable';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_scalar';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'intval';

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

        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    /**
     * Validate the supplied value against the current validator.
     *
     * @param mixed $value
     * @return boolean
     * @throws \LogicException when $this->validator or $this->lengthCheck is not callable
     * @throws \LogicException when either minLength of maxLength is not an integer
     */
    final public function validate($value)
    {
        if (!is_callable($this->lengthCheck)) {
            throw new LogicException('Length checker should be callable!');
        }

        $minLength = $this->minLength;
        $maxLength = $this->maxLength;

        if (!is_int($minLength) || !is_int($maxLength)) {
            throw new LogicException(
                'Min and max length should be of type integer.'
            );
        }

        // Check if the basic validation validates.
        $valid = parent::validate($value);

        // Check if the minimum length validates.
        $valid = $valid && (
            $minLength === 0
            || call_user_func_array($this->lengthCheck, array($value)) >= $minLength
        );

        // Check if the maximum length validates.
        $valid = $valid && (
            $maxLength === 0
            || call_user_func_array($this->lengthCheck, array($value)) <= $maxLength
        );

        return $valid;
    }

    /**
     * Return an indentifier.
     *
     * @return string
     */
    public function __tostring()
    {
        return "{$this->type}:{$this->minLength},{$this->maxLength}";
    }
}
