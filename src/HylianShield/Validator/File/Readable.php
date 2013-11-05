<?php
/**
 * Validate readability of files.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\File;

/**
 * Readable.
 */
class Readable extends \HylianShield\ValidatorAbstract
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'file_readable';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'is_readable';
}
