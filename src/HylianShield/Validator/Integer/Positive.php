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
class Positive extends \HylianShield\Validator\Integer
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'integer_positive';

    /**
     * The minimum length of the value.
     *
     * @var integer $minLength
     */
    protected $minLength = 1;

    /**
     * The maximum length of the value.
     *
     * @var integer $maxLength
     */
    protected $maxLength = 0;
}
