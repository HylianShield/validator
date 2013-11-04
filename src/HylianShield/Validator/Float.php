<?php
/**
 * Validate floats.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

/**
 * Float.
 */
class Float extends \HylianShield\Validator\Countable
{
    /**
     * The type.
     *
     * @var integer $type
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
    protected $lengthCheck = 'round';
}
