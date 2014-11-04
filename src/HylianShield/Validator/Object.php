<?php
/**
 * Validate arrays.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

/**
 * Object.
 */
class Object extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'object';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_object';
}
