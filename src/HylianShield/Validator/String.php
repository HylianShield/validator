<?php
/**
 * Validate strings.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator;

/**
 * String.
 */
class String extends \HylianShield\Validator\Range\Mutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'string';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_string';

    /**
     * The callable to return the length of the value.
     *
     * @var callable $lengthCheck
     */
    protected $lengthCheck = 'strlen';
}
