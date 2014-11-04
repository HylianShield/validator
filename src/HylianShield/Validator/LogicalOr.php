<?php
/**
 * Validate a conditional list in a logical OR fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

use \HylianShield\Validator\Context\ContextInterface;

/**
 * LogicalOr.
 */
class LogicalOr extends \HylianShield\Validator\LogicalGate
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'or';

    /**
     * Initialize the validator.
     *
     * @param array $validators
     */
    final protected function createValidator(array $validators = array())
    {
        // Create a custom validator that returns true on the first match.
        // Since it is OR, the first match will suffice.
        $this->validator = function (
            $value,
            ContextInterface $context
        ) use (
            $validators
        ) {
            foreach ($validators as $validator) {
                if ($validator($value, $context)) {
                    return true;
                }
            }

            return false;
        };
    }
}
