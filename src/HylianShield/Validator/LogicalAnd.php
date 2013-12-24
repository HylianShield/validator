<?php
/**
 * Validate a conditional list in a logical AND fashion.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Remko "CyberSecutor" Silvis
 */

namespace HylianShield\Validator;

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
     */
    final protected function createValidator(array $validators = array())
    {
        // Create a custom validator that returns true on the first match.
        // Since it is AND, all the validators should return true.
        $this->validator = function ($value) use ($validators) {
            foreach ($validators as $validator) {
                if (!$validator($value)) {
                    return false;
                }
            }

            return true;
        };
    }
}
