<?php
/**
 * Validate booleans.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

/**
 * Boolean.
 */
class Boolean extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'boolean';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_bool';
}
