<?php
/**
 * Validate value ranges.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

use \LogicException;

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
     * @var \Closure $validator
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
     * @return \Closure
     */
    final protected function initialize()
    {
        // Forward validator creation logic to concrete validators.
        $validator = $this->createValidator();
        $lengthCheck = $this->lengthCheck;

        $minLength = $this->minLength;
        $maxLength = $this->maxLength;

        // We create a number of scenarios to optimize validators.
        // The first one doesn't require a length check at all.
        if (!isset($this->minLength) && !isset($this->maxLength)) {
            return $this->validator = $this->createBasicValidator($validator);
        }

        if (!isset($minLength)) {
            // We only need to check the max length here.
            return $this->validator = $this->createMaximalLengthValidator(
                $validator,
                $lengthCheck
            );
        }

        if (!isset($maxLength)) {
            // We only need to check the min length here.
            return $this->validator = $this->createMinimalLengthValidator(
                $validator,
                $lengthCheck
            );
        }

        return $this->validator = $this->createRangedValidator(
            $validator,
            $lengthCheck
        );
    }

    /**
     * Create a basic validator without length checks.
     *
     * @param callable $validator
     * @return \Closure
     * @throws \InvalidArgumentException when $validator is not a callable
     */
    private function createBasicValidator($validator)
    {
        if (!is_callable($validator)) {
            throw new \InvalidArgumentException(
                'Validator should be callable!'
            );
        }

        /**
         * Internal validator.
         *
         * @param mixed $value
         * @return bool
         */
        return function ($value) use ($validator) {
            return (bool) $validator($value);
        };
    }

    /**
     * Create a validator for the minimal length of the range.
     *
     * @param callable $validator
     * @param callable $lengthCheck
     * @return \Closure
     * @throws \InvalidArgumentException when $validator is not a callable
     * @throws \InvalidArgumentException when $lengthCheck is not a callable
     */
    private function createMinimalLengthValidator($validator, $lengthCheck)
    {
        if (!is_callable($validator)) {
            throw new \InvalidArgumentException(
                'Validator should be callable!'
            );
        }

        if (!is_callable($this->lengthCheck)) {
            throw new \InvalidArgumentException(
                'Length checker should be callable!'
            );
        }

        $minLength = $this->minLength;

        /**
         * Internal validator.
         *
         * @param mixed $value
         * @return bool
         */
        return function ($value) use ($validator, $lengthCheck, $minLength) {
            return $validator($value) && $lengthCheck($value) >= $minLength;
        };
    }

    /**
     * Create a validator for the maximal length of the range.
     *
     * @param callable $validator
     * @param callable $lengthCheck
     * @return \Closure
     * @throws \InvalidArgumentException when $validator is not a callable
     * @throws \InvalidArgumentException when $lengthCheck is not a callable
     */
    private function createMaximalLengthValidator($validator, $lengthCheck)
    {
        if (!is_callable($validator)) {
            throw new \InvalidArgumentException(
                'Validator should be callable!'
            );
        }

        if (!is_callable($this->lengthCheck)) {
            throw new \InvalidArgumentException(
                'Length checker should be callable!'
            );
        }

        $maxLength = $this->maxLength;

        /**
         * Internal validator.
         *
         * @param mixed $value
         * @return bool
         */
        return function ($value) use ($validator, $lengthCheck, $maxLength) {
            return $validator($value) && $lengthCheck($value) <= $maxLength;
        };
    }

    /**
     * Create a validator for the minimal length and maximal of the range.
     *
     * @param callable $validator
     * @param callable $lengthCheck
     * @return \Closure
     * @throws \InvalidArgumentException when $validator is not a callable
     * @throws \InvalidArgumentException when $lengthCheck is not a callable
     */
    private function createRangedValidator($validator, $lengthCheck)
    {
        if (!is_callable($validator)) {
            throw new \InvalidArgumentException(
                'Validator should be callable!'
            );
        }

        if (!is_callable($this->lengthCheck)) {
            throw new \InvalidArgumentException(
                'Length checker should be callable!'
            );
        }

        $minLength = $this->minLength;
        $maxLength = $this->maxLength;

        /**
         * Internal validator.
         *
         * @param mixed $value
         * @return bool
         */
        return function ($value) use (
            $validator,
            $lengthCheck,
            $minLength,
            $maxLength
        ) {
            return $validator($value) && (
                ($length = $lengthCheck($value)) >= $minLength
                && $length <= $maxLength
            );
        };
    }

    /**
     * Return the current validator or overload to create a new one.
     *
     * @return callable
     */
    protected function createValidator()
    {
        return $this->validator;
    }

    /**
     * Return an identifier.
     *
     * @return string
     */
    public function __toString()
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
