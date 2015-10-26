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

    /** @noinspection PhpMissingParentConstructorInspection
     * The constructor for Many.
     *
     * @param array $values
     * @deprecated Will be removed in version 1.0. Use OneOf::fromArray instead.
     */
    public function __construct(array $values)
    {
        call_user_func_array('parent::__construct', $values);
    }
}
