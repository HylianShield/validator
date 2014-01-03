<?php
/**
 * Validate positive integers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Integer;

/**
 * Positive.
 */
class Positive extends \HylianShield\Validator\Range\Immutable
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'integer_positive';

    /**
     * The validator.
     *
     * @var string $validator
     */
    protected $validator = 'is_int';

    /**
     * The minimum length of the value.
     *
     * @var integer $minLength
     */
    protected $minLength = 1;
}
