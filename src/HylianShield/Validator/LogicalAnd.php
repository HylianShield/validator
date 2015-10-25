<?php
/**
 * Validate a conditional list in a logical AND fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

use \HylianShield\Validator\Context\ContextInterface;

/**
 * LogicalAnd.
 */
class LogicalAnd extends \HylianShield\Validator\LogicalGate
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'and';

    /**
     * Initialize the validator.
     *
     * @param array $validators
     * @return \Closure
     */
    final protected function createValidator(array $validators = array())
    {
        // Create a custom validator that returns true on the first match.
        // Since it is AND, all the validators should return true.
        return function (
            $value,
            ContextInterface $context = null
        ) use (
            $validators
        ) {
            foreach ($validators as $validator) {
                if (!$validator($value, $context)) {
                    return false;
                }
            }

            return true;
        };
    }
}
