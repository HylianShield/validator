<?php
/**
 * Validate positive integers.
 *
 * @package HylianShield
 * @subpackage Validator
 * @copyright 2013 Jan-Marten "Joh Man X" de Boer
 */

namespace HylianShield\Validator\Integer;

/**
 * Positive.
 */
class Positive extends \HylianShield\Validator\Integer
{
    /**
     * The type.
     *
     * @var string $type
     */
    protected $type = 'positive_integer';

    /**
     * Create a validator for a positive integer.
     */
    public function __construct()
    {
        parent::__construct(1);
    }
}
