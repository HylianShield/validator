<?php
/**
 * Validate strings.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

/**
 * String.
 */
class String extends \HylianShield\Validator\Range
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
}
