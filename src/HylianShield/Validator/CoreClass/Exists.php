<?php
/**
 * Validate class existence.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\CoreClass;

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
    protected $type = 'class_exists';

    /**
     * The validator.
     *
     * @var callable $validator
     */
    protected $validator = 'class_exists';
}
