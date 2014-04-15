<?php
/**
 * Validate a value of many.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\OneOf;

/**
 * Many.
 */
class Many extends \HylianShield\Validator\OneOf
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'oneof_many';

    /**
     * The constructor for Many.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        call_user_func_array('parent::__construct', $values);
    }
}
