<?php
/**
 * Validate functions.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator;

/**
 * CoreFunction.
 */
class CoreFunction extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'function';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'function_exists';
}
