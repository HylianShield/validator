<?php
/**
 * Validate booleans.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

/**
 * Boolean.
 */
class Boolean extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var integer $type
     */
    protected $type = 'boolean';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_bool';
}
