<?php
/**
 * Validate the ability to write a given file.
 *
 * @package HylianShield
 * @subpackage Validator
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
