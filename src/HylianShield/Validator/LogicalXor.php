<?php
/**
 * Validate a conditional list in a logical XOR fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

use HylianShield\Validator\Context\ContextInterface;

/**
 * LogicalXor.
 */
class LogicalXor extends \HylianShield\Validator\LogicalGate
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'xor';

    /**
     * Initialize the validator.
     *
     * @param array $validators
     * @return \Closure
     */
    final protected function createValidator(array $validators = array())
    {
        // Create a custom validator.
        // Since it is XOR, only one match should happen.
        return function (
            $value,
            ContextInterface $context
        ) use (
            $validators
        ) {
            // Create a test where only the passing validators will remain.
            $test = array_filter(
                $validators,
                function ($validator) use ($value, $context) {
                    return $validator($value, $context);
                }
            );

            // The result of this test must be exactly 1 to be a valid XOR gate.
            return count($test) === 1;
        };
    }
}
