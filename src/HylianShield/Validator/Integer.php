<?php
/**
 * Validate integers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

/**
 * Integer.
 */
class Integer extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var integer $type
     */
    protected $type = 'integer';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_int';
}
