<?php
/**
 * Validate file existence.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\File;

/**
 * Exists.
 */
class Exists extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var integer $type
     */
    protected $type = 'file_exists';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'file_exists';
}
