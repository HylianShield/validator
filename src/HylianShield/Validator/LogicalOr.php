<?php
/**
 * Validate a conditional list in a logical OR fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

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
        $this->validator = function ($value) use ($validators) {
            foreach ($validators as $validator) {
                if ($validator($value)) {
                    return true;
                }
            }

            return false;
        };
    }
}
