<?php
/**
 * Validate floats.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

/**
 * Float.
 */
class Float extends \HylianShield\Validator\Range\Mutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'float';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_float';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'floatval';
}
