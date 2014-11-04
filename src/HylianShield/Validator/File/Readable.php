<?php
/**
 * Validate readability of files.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\File;

/**
 * Readable.
 */
class Readable extends \HylianShield\Validator
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
