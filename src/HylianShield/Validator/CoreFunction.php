<?php
/**
 * Validate functions.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

use HylianShield\Validator\Context\ContextInterface;

/**
 * CoreFunction.
 */
class CoreFunction extends \HylianShield\Validator
{
    /**
     * The name of a function must be a string.
     *
     * @var integer VIOLATION_PARSER
     */
    const VIOLATION_STRING = 1;

    /**
     * The given function must be defined.
     *
     * @var integer VIOLATION_EXISTS
     */
    const VIOLATION_EXISTS = 2;

    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'function';

    /**
     * Create a validator that tests if a function exists.
     */
    public function __construct()
    {
        $this->validator = function ($value, ContextInterface $context) {
            $rv = true;

            if (!is_string($value)) {
                $context->addViolation(
                    'Function name must be a string',
                    CoreFunction::VIOLATION_STRING
                );

                $rv = false;
            } elseif (!function_exists($value)) {
                $context->addViolation(
                    'Function ":name" does not exist',
                    CoreFunction::VIOLATION_EXISTS,
                    array('name' => $value)
                );

                $rv = false;
            }

            return $rv;
        };
    }
}
