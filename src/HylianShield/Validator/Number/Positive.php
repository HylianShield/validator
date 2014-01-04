<?php
/**
 * Validate positive numbers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Number;

use \HylianShield\Validator\Float;
use \HylianShield\Validator\Integer;
use \HylianShield\Validator\LogicalOr;

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
    protected $type = 'number_positive';

    /**
     * Create the validator
     */
    public function __construct()
    {
        // Set a custom validator.
        $this->validator = new LogicalOr(new Integer\Positive, new Float\Positive);
    }
}
