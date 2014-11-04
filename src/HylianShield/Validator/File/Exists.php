<?php
/**
 * Validate file existence.
 *
 * @package HylianShield
 * @subpackage Validator
 */

namespace HylianShield\Validator\File;

/**
 * Exists.
 */
class Exists extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'file_exists';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'file_exists';
}
