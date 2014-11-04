<?php
/**
 * Validate functions.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

/**
 * CoreFunction.
 */
class CoreFunction extends \HylianShield\Validator
{
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
        $this->validator = function ($value) {
            return is_string($value) && function_exists($value);
        };
    }
}
