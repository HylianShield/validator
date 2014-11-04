<?php
/**
 * Context for validator constraint violations.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;


use InvalidArgumentException;

/**
 * Validator context for constraint violations.
 */
class Context
{
    /**
     * A list of constraint violations as registered by a validator.
     * The structure will be as follows:
     *
     * [
     *   0 => [
     *     (int) $violationCode,
     *     (string) $violationMessage,
     *     (array) $violationContext [
     *       (string) 'contextBinding' => (string|integer|float|bool) 'contextValue'
     *     ]
     *   ]
     * ]
     *
     * @var array $constraintViolations
     */
    protected $constraintViolations = array();


    /**
     * Add a constraint violation to the validator context.
     *
     * @param integer $violationCode
     * @param string $violationMessage
     * @param array $violationContext
     * @return \HylianShield\Validator\Context
     * @throws \InvalidArgumentException when $violationCode is not an integer
     * @throws \InvalidArgumentException when $violationMessage is not a string
     * @throws \InvalidArgumentException when $violationContext has non-string keys
     * @throws \InvalidArgumentException when $violationContext has non-scalar values
     */
    public function addConstraintViolation(
        $violationCode,
        $violationMessage,
        array $violationContext = array()
    ) {
        if (!is_integer($violationCode)) {
            throw new InvalidArgumentException(
                'Violation code must be an integer: '
                . var_export($violationCode, true)
            );
        }

        if (!is_string($violationMessage)) {
            throw new InvalidArgumentException(
                'Violation message must be a string: '
                . var_export($violationMessage, true)
            );
        }

        foreach ($violationContext as $key => $value) {
            if (!is_string($key)) {
                throw new InvalidArgumentException(
                    'Violation context must have string keys: '
                    . var_export($key, true)
                );
            }
            
            if (!is_scalar($value)) {
                throw new InvalidArgumentException(
                    'Violation context must have scalar values: '
                    . var_export($value, true)
                );
            }
        }

        array_push(
            $this->constraintViolations,
            array(
                $violationCode,
                $violationMessage,
                $violationContext
            )
        );

        return $this;
    }
}
