<?php
/**
 * Validate arrays.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

/**
 * CoreArray.
 */
class CoreArray extends \HylianShield\Validator\Range\Mutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'array';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_array';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'count';
}
