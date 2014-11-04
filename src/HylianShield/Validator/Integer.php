<?php
/**
 * Validate integers.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

/**
 * Integer.
 */
class Integer extends \HylianShield\Validator\Range\Mutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'integer';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_int';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'intval';
}
