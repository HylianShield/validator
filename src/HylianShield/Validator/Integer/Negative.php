<?php
/**
 * Validate negative integers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Integer;

/**
 * Negative.
 */
class Negative extends \HylianShield\Validator\Integer
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'negative_integer';

    /**
     * Create a validator for a negative integer.
     */
    public function __construct()
    {
        parent::__construct(0, -1);
    }
}
