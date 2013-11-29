<?php
/**
 * Validate writability of files.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\File;

/**
 * Writable.
 */
class Writable extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'file_writable';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_writable';
}
