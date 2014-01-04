<?php
/**
 * Validate positive integers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Integer;

use \HylianShield\Validator\Integer;

/**
 * Positive.
 */
class Positive extends \HylianShield\Validator
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'integer_positive';

    /**
     * Create a validator for positive integers.
     */
    public function __construct()
    {
        $this->validator = new Integer(1);
    }
}
