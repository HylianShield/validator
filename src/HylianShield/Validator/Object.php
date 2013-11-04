<?php
/**
 * Validate arrays.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

/**
 * Array.
 */
class Array extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var integer $type
     */
    protected $type = 'object';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_object';
}
